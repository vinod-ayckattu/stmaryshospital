<?php
if(!is_user_logged_in()) {

    wp_redirect(site_url('login'));
}
else if(current_user_can('edit_posts')){
    wp_redirect(site_url('manage-appointments'));
}
get_header();
$error = array('error'=>'');

if(get_transient('error_appointment')!=false){
    $error = get_transient('error_appointment');
    delete_transient('error_appointment');
}
?>

    
</div>
<form action="<?php echo esc_url( admin_url('admin-post.php') );?>" method="post">
<div class="row m-3">
    <div class="col"></div>
    <div class="col-6 m-3 p-3 border border-1 rounded-2 border-success ">
    <h3 class="text-success text-center">Add New Appointment</h3>
                <div class="text-danger"><?php echo $error['error']; ?></div>
                <div class="form_item">
                    <select name="department" id="select_department" class="form-control">
                        <option value="">Select your Department</option>
                    <?php
                    $departments = new WP_Query(array(
                        'post_type'=>'department'
                    ));
                    //print_r($departments);

                    while($departments->have_posts()){
                        $departments->the_post();
                        ?>
                        <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                    </select>
                </div>
                    <div class="form_item">
                    <select name="doctor" id="select_doctor" class="form-control">
                        <option>Choose a Department First</option>
                    </select>
                </div>
                <div class="form_item text-left">
                    <label for="date_of_app">Date of Appointment</label>
                    <input type="date" name="date_of_app" id="book_app" class="form-control">
                </div>
                <div class="form_item text-center">
                    <input type="submit" value="Book Appointment" class="btn btn-primary"> 
                </div>
                <input type="hidden" name="action" value="contact_form">

    </div>
    <div class="col"></div>
</div>
</form>

<?php

    $appointments = new WP_Query(array(
        'post_type'=> 'appointment',
        'author'=> get_current_user_id(),
        'meta_key'=>'date_of_appointment',
        'orderby'=> 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'date_of_appointment',
                'compare' => '>=',
                'value' => date_format(date_create(),'Y/m/d'),
                'type' => 'DATE'
            )
        )
    ));
    
if($appointments->have_posts()){
    ?>
    
<div class="row">
    <div class="col"></div>
    <div class="col-8 text-center">
    <h3 class="text-primary">Upcoming Appointments</h3>
        <table class="table border border-2 table-striped">
            <thead><tr><th>Sl No</th><th>Appointment Reference ID</th><th>Department</th><th>Doctor</th><th>Date of Appointment</th><th>Booking Date</th></tr></thead>
            <?php
                $count = 1;
                while($appointments->have_posts()){
                    $appointments->the_post();
                    $doctor_id = get_field('doctor_',get_the_ID());
                    $department = get_field('department',$doctor_id);
                    $date_of_app = date_create(get_field('date_of_appointment',get_the_ID()));
               ?>        
               <tr><td><?php echo $count; ?></td><td><?php echo get_post_meta(get_the_ID(),'appointment_ref_id',true); ?></td><td><?php echo $department[0]->post_title; ?></td><td><?php echo get_the_title($doctor_id); ?></td><td><?php echo date_format($date_of_app,"d-m-Y"); ?><td><?php echo get_the_date('d-m-Y'); ?></td></td></tr> 
                 <?php   
                    $count++;
                 }
            ?>                
        </table>
    </div>
    <div class="col"></div>
</div>


<?php
}


//History of Appointments

$app_his = new WP_Query(array(
    'post_type'=> 'appointment',
    'author'=> get_current_user_id(),
    'meta_key'=>'date_of_appointment',
    'orderby'=> 'meta_value',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key' => 'date_of_appointment',
            'compare' => '<',
            'value' => date_format(date_create(),'Y/m/d'),
            'type' => 'DATE'
        )
    )
));

if($app_his->have_posts()){
?>
<div class="row">
<div class="col"></div>
<div class="col-6 text-center">
<h3 class="text-primary">History of Appointments</h3>
    <table class="table border border-2 table-striped">
        <thead><tr><th>Sl No</th><th>Appointment Reference ID</th><th>Department</th><th>Doctor</th><th>Date of Appointment</th><th>Booking Date</th></tr></thead>
        <?php
            $count = 1;
            while($app_his->have_posts()){
                $app_his->the_post();
                $doctor_id = get_field('doctor_',get_the_ID());
                $department = get_field('department',$doctor_id);
                $date_of_app = date_create(get_field('date_of_appointment',get_the_ID()));
           ?>        
           <tr><td><?php echo $count; ?></td><td><?php echo get_post_meta(get_the_ID(),'appointment_ref_id',true); ?></td><td><?php echo $department[0]->post_title; ?></td><td><?php echo get_the_title($doctor_id); ?></td><td><?php echo date_format($date_of_app,"d-m-Y"); ?><td><?php echo get_the_date('d-m-Y'); ?></td></td></tr> 
             <?php   
                $count++;
             }
        ?>                
    </table>
</div>
<div class="col"></div>
</div>
<?php
}
?>


<?php    
get_footer();
?>