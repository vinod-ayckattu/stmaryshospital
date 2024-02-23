<?php
if(is_user_logged_in()){
    wp_redirect(site_url());
}
get_header();
$errors = '';
if(get_transient('patient_login_values') !== false){
    $transient_values = get_transient('patient_login_values');
    $errors = $transient_values['error_message'];
    delete_transient('patient_login_values');
}
else{
    $transient_values['user_email'] = '';
}
?>
<div>
    <form action="<?php echo esc_url( admin_url('admin-post.php') );?>" id="login_form" method="post">
    <div class="row m-5">
        <div class="col"></div>
        <div class="col border borer-1 border-primary rounded m-5 p-3">
            <h3 class="text-success text-center">Patient Login</h3>
            <div id="error_display"><?php echo $errors; ?></div>
            <div class="m-3">
                <label for="user_email">Email ID</label>
                <input type="text" class="form-control" name="user_email" id="login_user_email" value="<?php echo $transient_values['user_email']; ?>">
            </div>
            <div class="m-3">
                <label for="user_pass">Password</label>
                <input type="password" class="form-control" name="user_pass" id="login_user_pass">
            </div>
            <div class="m-3 float-end">
                <input type="hidden" name="action" value="patient_login">
                <input type="submit" class="btn btn-primary" value="Log In">
            </div>
        </div>
        <div class="col"></div>
    </div>
    
    </form>
</div>
<?php    
get_footer();
?>