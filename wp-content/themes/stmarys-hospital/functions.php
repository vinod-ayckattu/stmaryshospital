<?php
function css_and_js()
{

	wp_enqueue_style('basic_stylesheet',get_stylesheet_uri());
    wp_enqueue_style('google_fonts','https://fonts.googleapis.com/css?family=Varela Round');
	wp_enqueue_style('bootstrap_styles','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('jquery_cdn','https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
	wp_enqueue_script('bootstrap_script','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('script_library',get_theme_file_uri('scripts/library.js'));
    wp_enqueue_script('main_script',get_theme_file_uri('scripts/main.js'));
	//show_admin_bar(false);

}
add_action('wp_enqueue_scripts','css_and_js');
function features(){
    add_theme_support( 'post-thumbnails' );
	if(is_user_logged_in() AND !current_user_can('edit_users') AND !is_admin()){
		show_admin_bar(false);
	}
}
add_action('after_setup_theme','features');



add_action( 'admin_post_nopriv_contact_form', 'appointment_registration' );
add_action( 'admin_post_contact_form', 'appointment_registration' );

function appointment_registration(){
	$post['date_of_app'] = sanitize_text_field($_POST['date_of_app']);
	$post['department'] = sanitize_text_field($_POST['department']);
	$post['doctor'] = sanitize_text_field($_POST['doctor']);
	if(!empty($post['date_of_app']) AND !empty($post['department']) AND !empty($post['doctor'])){

		$reference_id = get_current_user_id().$post['doctor'].date_format(date_create($post['date_of_app']),"ymd");
		//echo $reference_id;

		$appointments = new WP_Query(array(
			'post_type'=> 'appointment',
			'author'=> get_current_user_id(),
			'meta_key' => 'appointment_ref_id',
			'meta_query' => array(
				array(
					'key' => 'appointment_ref_id',
					'compare' => 'LIKE',
					'value' => $reference_id				
					)
			)
		));

		if($appointments->have_posts()){
			//print_r($appointments);
			set_transient('error_appointment',array('error' => 'You have already an appointment for the same doctor on the same day!'),60*15);
		}
		else{

			$insert_data = [
								'post_type'=> 'appointment',
								'author'=> get_current_user_id(),
								'post_status'=>'publish'
							];
			$insert_id = wp_insert_post($insert_data);
			$r1 = add_post_meta($insert_id,'date_of_appointment',$post['date_of_app']);
			$r2 = add_post_meta($insert_id,'department',$post['department']);
			$r3 = add_post_meta($insert_id,'doctor_',$post['doctor']);
			$r4 = add_post_meta($insert_id,'appointment_ref_id',$reference_id);
		}
	}
	else{
		set_transient('error_appointment',array('error' => 'Please fill all fields'),60*15);
	}
	wp_redirect(site_url('appointments'));
}



//Login 

add_action( 'admin_post_nopriv_patient_login', 'patient_login' );
add_action( 'admin_post_patient_login', 'patient_login' );

function patient_login(){

	//print_r($_POST);
	$validated_login = validate_login($_POST);
	
	/*if(!$validated_login){
		print_r(get_transient('patient_login_values'));
		wp_redirect(site_url('login'));
	}*/
	//echo 'jhhhjjhg';
	
	$current_user = wp_signon(array(
		'user_login' => $validated_login['user_email'],
		'user_password' => $validated_login['user_pass'])
	);
	print_r($current_user);
	if(is_wp_error($current_user)){
		$validated_login['error_message'] = 'The Email ID or Password is wrong!';
		set_transient('patient_login_values',$validated_login,3600);
		wp_redirect(site_url('login'));
	}
	wp_set_current_user($current_user->ID);

	if(current_user_can('edit_posts')){
		wp_redirect(site_url('manage-appointments'));
	}
	
	wp_redirect(site_url('appointments'));

}
function validate_login($post){

	$sanitized_post = array(
		'user_email' => sanitize_text_field($post['user_email']),
		'user_pass' => sanitize_text_field($post['user_pass'])
	);
	//print_r($sanitized_post);
	/*foreach($sanitized_post as $sp){
		if(empty($sp)){
			$sanitized_post['error_message'] = 'Please fill all the fields!';
			set_transient('patient_login_values',$sanitized_post,3600);
			return false;
		}
	}*/
	
	return $sanitized_post;
}

add_action( 'admin_post_nopriv_patient_registration', 'patient_registration' );
add_action( 'admin_post_patient_registration', 'patient_registration' );

function patient_registration(){

	if(get_transient('patient_registration_values') !== false){
		delete_transient('patient_registration_values');
	}

	$validated_data = validate_patient_registration($_POST);

	if($validated_data == false){
		wp_redirect(site_url('patient-registration'));
	}
	
	$insert_user = [
						'first_name'=> $validated_data['first_name'],
						'last_name'=> $validated_data['last_name'],
						'user_email'=>$validated_data['user_email'],
						'user_login'=>$validated_data['user_email'],
						'user_pass'=>$validated_data['user_pass'],
						'meta_input'=>array(
							'gender'=>$validated_data['gender'],
							'date_of_birth'=>$validated_data['date_of_birth'],
							'user_address'=>$validated_data['user_address'],
							'user_mobile'=>$validated_data['user_mobile']
						)
					];
	$insert_id = wp_insert_user($insert_user);
	//print_r($insert_id);
	if(is_numeric($insert_id)){
		$num_part = (date("Y")%1000)*100000+$insert_id;
		$pr_number = 'STM'.$num_part;
		$meta_id = add_user_meta($insert_id,'pr_number',$pr_number,true);
		$current_user = wp_signon(array(
			'user_login' => $validated_data['user_email'],
			'user_password' => $validated_data['user_pass'])
		);
		wp_set_current_user($current_user->ID);
		wp_redirect(site_url('appointments'));
		

	}
	else{
		echo 'some error!';
	}
}

function validate_patient_registration($post){
	$transient_values = [];
	$return_flag = false;

	$sanitized_post['first_name']=strtoupper(sanitize_text_field(substr($post['first_name'],0,50)));	
	$sanitized_post['last_name']=strtoupper(sanitize_text_field(substr($post['last_name'],0,50)));		
	$sanitized_post['user_email'] = strtolower(sanitize_email($post['user_email']));
	$sanitized_post['user_pass'] = sanitize_text_field($post['user_pass']);
	$sanitized_post['user_mobile'] = sanitize_text_field($post['user_mobile']);
	$sanitized_post['user_address'] = strtoupper(sanitize_textarea_field($post['user_address']));
	$sanitized_post['date_of_birth'] = sanitize_text_field($post['date_of_birth']);
	$sanitized_post['gender'] = strtoupper(sanitize_text_field($post['gender']));
	

	foreach($sanitized_post as $field){
		if(empty($field)){
			set_transient('patient_registration_values',$sanitized_post,3600);
			return false;
		}
	}

	return $sanitized_post;

}

//REST API


function register_search_department(){

register_rest_route('stmaryshospital/v2','departments', array(
'methods' => WP_REST_SERVER::READABLE, 
'callback' => 'searchDoctors'
));
}

function searchDoctors($data)
{
	$query = new WP_Query(array(
		'post_type'=>'doctor', 
		'meta_query'=> array(
            array(
                'key'=>'department',
                'compare'=>'LIKE',
                'value'=> $data['dept_id']
            )
        )
));

//return $query->found_posts;
	$result_array = array();
	while($query->have_posts())
	{
		$query->the_post();
		array_push($result_array, array(
		'title' => get_the_title(),
		'id' => get_the_ID()
));
	}
	
return $result_array;
//return 'url is fine';
}

add_action('rest_api_init','register_search_department');




function register_search_appointment(){

	register_rest_route('stmaryshospital/v2','appointments', array(
	'methods' => WP_REST_SERVER::READABLE, 
	'callback' => 'searchAppointments'
	));
	}
	
	function searchAppointments($data)
	{
		$query = new WP_Query(array(
			'post_type'=>'appointment', 
			'orderby'=>'date',
			'order'=>'DESC',
			'meta_query'=> array(
				'relation'=> 'AND',
				array(
					'key'=>'doctor_',
					'compare'=>'LIKE',
					'value'=> $data['doctor']
				),
				array(
					'key'=>'date_of_appointment',
					'compare'=>'LIKE',
					'value'=> $data['date_of_app'],
					'type'=>'DATE'
				)
			)
	));
	
	//return $query->found_posts;
		$result_array = array();
		while($query->have_posts())
		{
			$query->the_post();
			array_push($result_array, array(
			'patient_name' => get_the_author(),
			'pr_number' => get_the_author_meta('pr_number'),
			'appointment_ref_id' => get_post_meta(get_the_ID(),'appointment_ref_id',true),
			'booking_date' => get_the_date('d-m-Y')
	));
		}
		
	return $result_array;
	//return 'url is fine';
	}
	
	add_action('rest_api_init','register_search_appointment');

// REST API for patient information


	function register_patient_information(){

		register_rest_route('stmaryshospital/v2','patients', array(
		'methods' => WP_REST_SERVER::READABLE, 
		'callback' => 'patientInformation'
		));
		}
		
		function patientInformation($data)
		{
			$result = array();

			if(!empty($data['pr_number']) OR !empty($data['date_of_birth']) OR !empty($data['user_mobile'])){

			$patient = new WP_User_Query(array(
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'pr_number',
						'compare' => 'LIKE',
						'value' => $data['pr_number']
					),
					array(
						'key' => 'date_of_birth',
						'compare' => 'LIKE',
						'value' => $data['date_of_birth']
					),
					array(
						'key' => 'user_mobile',
						'compare' => 'LIKE',
						'value' => $data['user_mobile']
					)
				)
			));
			
		if(!empty($patient->get_results()))
		{
			 foreach($patient->get_results() as $pat){
				
				array_push($result,array(
					'first_name'=> $pat->user_firstname,
					'last_name'=> $pat->user_lastname,
					'user_email'=> $pat->user_email,
					'user_pass'=> $pat->user_pass,
					'gender'=> get_user_meta($pat->ID,'gender',true),
					'user_address'=> get_user_meta($pat->ID,'user_address',true)
				));
			 }
			 
		}
		}
		return $result;
		
	}
		
		add_action('rest_api_init','register_patient_information');
	