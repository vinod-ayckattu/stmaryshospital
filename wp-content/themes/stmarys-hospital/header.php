
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php bloginfo('name')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
  </head>
<body class="fs-6">
    <div class="header_bar row">
        
        <div class="site_name col-4"><a href="<?php echo site_url()?>"><?php bloginfo('name')?></a></div>
        <div class="col pt-3">
            <ul>
                <?php
                $appointment_manager = false;
                if(is_user_logged_in()  AND current_user_can('edit_posts') AND !current_user_can('edit_users')) { 
                    $appointment_manager = true;
                }
                if(!$appointment_manager){
                ?>
                <li class="menu_item"><a href="<?php echo site_url()?>">Home</a></li>
                <li class="menu_item"><a href="<?php echo site_url('about-us')?>">About Us</a></li>
                <li class="menu_item"><a href="<?php echo site_url('departments')?>">Departments</a></li>
                <li class="menu_item"><a href="<?php echo site_url('doctors')?>">Doctors</a></li>
                <li class="menu_item"><a href="<?php echo site_url('contact-us')?>">Contact Us</a></li>
                <li class="menu_item"><a href="<?php echo site_url('appointments')?>">Appointments</a></li>
                <?php
                }
                else{
                    $current_user = wp_get_current_user();
                    ?>
                    <li class="menu_item">Logged in Official Role: <?php echo $current_user->display_name;?></li>
                    <li class="menu_item"><a href="<?php echo site_url('manage-appointments')?>">Manage Appointments</a></li>  
                <?php
                }
                 if(!is_user_logged_in()) {?>
                <li class="menu_item"><a href="<?php echo site_url('login')?>">Patient Login</a> / <a href="<?php echo site_url('patient-registration')?>">Register</a></li>
                <?php }
                else {                    
                ?>
                <li class="menu_item"><a href="<?php echo site_url('logout')?>">Logout</a></li>
                
                <?php
                }
                if(is_user_logged_in() AND !current_user_can('edit_posts')){
                    $current_user = wp_get_current_user();

                        ?>
                        <li class="patient_info">Patient: <?php echo ucwords(strtolower($current_user->display_name));?> <br>PR Number: <?php echo get_user_meta($current_user->ID,'pr_number',true); ?></li>
                        <?php
                }
                ?>
    
    </ul>
</div>
</div>
<?php
wp_head();
?>