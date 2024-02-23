<?php
get_header();

//delete_transient('patient_registration_values');
$filled_values = array(
    'first_name'=>'',
    'last_name'=>'',
    'gender'=>'',
    'date_of_birth'=>'',
    'user_mobile'=>'',
    'user_address'=>'',
    'user_email'=>''
);

$errors = '';
if(get_transient('patient_registration_values') !== false){
    $filled_values = get_transient('patient_registration_values');
    $errors = 'Kindly fill all the details!';
    delete_transient('patient_registration_values');
}
?>
<h3 class="text-success text-center m-3">Patient Registration</h3>
<div class="row m-3">
    <div class="col-sm-2"></div>
    <div class="col border border-1 border-primary rounded-3 m-2">
        <div class="form_type">
            <div class="form_basic">
                <input type="radio" name="prn_status" id="prn_no" value="prn_no" checked> I am new at the Hospital
            </div>
            <div class="form_basic">
                <input type="radio" name="prn_status" id="prn_yes" value="prn_yes"> I have already a PR Number at the Hospital
            </div>
            <div id="validation_errors" style="color: red;">
                <?php echo $errors; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>    
</div>

<form action="<?php echo esc_url( admin_url('admin-post.php') );?>" id="registration_form" method="post">
<div class="row">
<div class="col-sm-2"></div>
<div class="col">
<div class="row border border-1 border-primary rounded-3 m-2">
    <div class="col form_group">
        <div class="form_basic m-3">    
            <label for="pr_number" class="form-label">PR Number</label>
            <input class="form-control" type="text" name="pr_number" id="pr_number"  value=""  disabled>
            <label class="text-danger" id="pr_number_required" hidden="true">This field is required</label>
        </div>
        <div class="form_basic m-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input class="form-control" type="date" name="date_of_birth" id="date_of_birth" min="1900-01-01" value="<?php echo $filled_values['date_of_birth'];?>">
            <label class="text-danger" id="date_of_birth_required" hidden="true">This field is required</label>
        </div>
        <div class="form_basic m-3">
            <label for="user_mobile" class="form-label">Mobile Numer</label>
            <input class="form-control" type="text" name="user_mobile" id="user_mobile"  value="<?php echo $filled_values['user_mobile'];?>">
            <label class="text-danger" id="user_mobile_required" hidden="true">This field is required</label>
            <div class="m-2 float-end"><a href="#" id="get_from_prn" class="bg-primary text-white rounded p-1"  hidden="true">Get My Details</a></div>
            <div id="no_prn_found" hidden="true">Sorry! No patients found with the above PR NUmber, Date of Birth and Mobile Number! You can Register as a New Patient!</div>
        </div>
        <div class="form_basic m-3">
            <label for="first_name" class="form-label">First Name</label>
            <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo $filled_values['first_name'];?>">
            <label class="text-danger" id="first_name_required" hidden="true">This field is required</label>
        </div>
        <div class="form_basic m-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input class="form-control" type="text" name="last_name" id="last_name"  value="<?php echo $filled_values['last_name'];?>">
            <label class="text-danger" id="last_name_required" hidden="true">This field is required</label>
        </div>
        <div class="form_basic m-3">
            <label for="gender" class="form-label">Gender</label>
            <input type="radio" class="form-check-input" name="gender" id="gender_male"  value="MALE" <?php if($filled_values['gender']=='MALE') {?> checked<?php }?>> Male
            <input type="radio" class="form-check-input" name="gender" id="gender_female"  value="FEMALE" <?php if($filled_values['gender']=='FEMALE') {?> checked<?php }?>> Female
            <label class="text-danger" id="gender_required" hidden="true">This field is required</label>
        </div>
    </div>   
    <div class="col">    
        
            <div class="form_basic m-3">
            <label for="user_address" class="form-label">Address</label>
            <textarea class="form-control" name="user_address" id="user_address" style="resize:none"><?php echo $filled_values['user_address'];?></textarea>
            <label class="text-danger" id="user_address_required" hidden="true">This field is required</label>
            </div>
        <div class="form_basic m-3">
            <label for="user_email" class="form-label">Email Id</label>
            <input class="form-control" type="text" name="user_email" id="user_email"  value="<?php echo $filled_values['user_email'];?>">
            <label class="text-danger" id="user_email_required" hidden="true">This field is required</label>   
        </div>
        <div class="form_basic m-3">
            <label for="user_pass" class="form-label">Password</label>
            <input class="form-control" type="password" name="user_pass" id="user_pass">
            <label class="text-danger" id="user_pass_required" hidden="true">This field is required</label>    
        </div>
        <div class="form_basic m-3">
            <label for="re_password" class="form-label">Confirm Password</label>
            <input class="form-control" type="password" name="re_password" id="re_password">
            <label class="text-danger" id="re_password_required" hidden="true">This field is required</label>
            <input type="hidden" name="action" value="patient_registration">
            </div>
        <div class="form_basic m-3">
            <div id="existingaccount" hidden="true">There is already an account existing for this PR Number. You can <a href="<?php echo site_url('/login'); ?>">Log In</a> here!</div>
            <input type="reset" value="Clear"  class="btn btn-primary m-3" id="reset_form"><input type="submit" id="register_btn" class="m-3 btn btn-primary" value="Register">
        </div>
</div>
</div>
</div>
<div class="col-sm-2"></div>
</div>
</form>

<?php
get_footer();
?>