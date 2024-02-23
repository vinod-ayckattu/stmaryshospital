<?php
add_action('init','department_post_type');
function department_post_type(){
register_post_type('department', array(
	'show_in_rest'=>true,
'public'=>true, //show_ui=>true  for show in admin 
'labels'=>array(
	'name'=>'Departments',
	'add_new'=>'Add New Department',
	'add_new_item'=>'Add New Department'),
'has_archive'=> true, 
'supports'=>array('title','editor','excerpt','thumbnail'), 
'menu_icon'=> 'dashicons-building' 
));

register_post_type('doctor', array(
'show_in_rest'=>true,
'public'=>true, //show_ui=>true  for show in admin 
'labels'=>array(
	'name'=>'Doctors',
	'add_new'=>'Add New Doctor',
	'add_new_item'=>'Add New Doctor'),
'has_archive'=> true, 
'supports'=>array('title','editor','excerpt','thumbnail'), 
'menu_icon'=> 'dashicons-businessperson' 
));

register_post_type('Appointment', array(
	'show_in_rest'=>true,
	'public'=>true, //show_ui=>true  for show in admin 
	'labels'=>array(
		'name'=>'Appointments',
		'add_new'=>'Add New Appointment',
		'add_new_item'=>'Add New Appointment'),
	'has_archive'=> true, 
	'supports'=>array('title','editor'), 
	'menu_icon'=> 'dashicons-networking' 
	));

}


