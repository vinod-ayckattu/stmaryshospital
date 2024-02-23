$(document).ready(function ()
{
    search_rest = new search();
    select_doctor = new Doctors();
    $('#search_appointment').on('click',function(){
        appointment = new Appointments();
    });
    $('#get_from_prn').on('click',function(){
        patient_info = new PatintInformation();
    });
    $('#registration_form').on('submit',function(){
      newPatient = new validateRegistration();
      return newPatient.validate_data();
    });
    $('#login_form').on('submit',function(){
      login = new LoginValidation();
      return login.validateLogin();
    });
    $('input[name="prn_status"]').change(function() {

      $('#pr_number').val('');
      $('#date_of_birth').val('');
      $('#first_name').val('');
      $('#last_name').val('');
      $('#user_mobile').val('');
      $('#user_address').val('');
      $('#user_email').val('');
      $('#date_of_birth').val('');
      $('#user_pass').val('');
      $('#re_password').val('');
      $('#gender_male').removeAttr('checked');
      $('#gender_female').removeAttr('checked');

      $('#first_name').removeClass('registration_error');
      $('#last_name').removeClass('registration_error');
      $('#gender_male').removeClass('registration_error');
      $('#gender_female').removeClass('registration_error');
      $('#user_mobile').removeClass('registration_error');
      $('#user_address').removeClass('registration_error');
      $('#user_email').removeClass('registration_error');
      $('#date_of_birth').removeClass('registration_error');
      $('#user_pass').removeClass('registration_error');
      $('#re_password').removeClass('registration_error');

      $('#existingaccount').attr('hidden','true');
      $('#pr_number_required').attr('hidden','true');
      $('#date_of_birth_required').attr('hidden','true');
        $('#user_mobile_required').attr('hidden','true');
        $('#first_name_required').attr('hidden','true');
        $('#last_name_required').attr('hidden','true');
        $('#gender_required').attr('hidden','true');
        $('#user_address_required').attr('hidden','true');
        $('#user_email_required').attr('hidden','true');
        $('#user_pass_required').attr('hidden','true');
        $('#re_password_required').attr('hidden','true');

      $('#validation_errors').empty();
      
        var selectedOption = $('input[name="prn_status"]:checked').attr('id');
        
        switch(selectedOption) {
          case 'prn_no':
            $('#pr_number').attr('disabled','disabled');
            $('#get_from_prn').attr('hidden','true');
            $('#first_name').removeAttr('disabled');
            $('#last_name').removeAttr('disabled');
            $('#gender_male').removeAttr('disabled');
            $('#gender_female').removeAttr('disabled');
            $('#user_mobile').removeAttr('disabled');
            $('#user_address').removeAttr('disabled');
            $('#user_email').removeAttr('disabled');
            $('#date_of_birth').removeAttr('disabled');
            $('#user_pass').removeAttr('disabled');
            $('#re_password').removeAttr('disabled');
            $('#register_btn').removeAttr('disabled');
            
            break;
          case 'prn_yes':
            $('#pr_number').removeAttr('disabled');
            $('#first_name').attr('disabled','disabled');
            $('#last_name').attr('disabled','disabled');
            $('#gender_male').attr('disabled','disabled');
            $('#gender_female').attr('disabled','disabled');
            $('#user_address').attr('disabled','disabled');
            $('#user_email').attr('disabled','disabled');
            $('#register_btn').attr('disabled','disabled');
            $('#get_from_prn').removeAttr('hidden');
            
            break;
          case 'prn_unknown':
            alert('ok3');
            break;
          default:
            alert('nothing');
            break;
        }
      });
      $('#reset_form').on('click',function(){
         // $('#gender_male').removeAttr('checked');
         // $('#gender_female').removeAttr('checked');
      });

      const d = new Date();
      let month_str = '0';
      let month = d.getMonth()+1;
      if(month < 9){
        month_str = month_str + month;
      }
      else{
        month_str = month;
      }
      let dob_max = d.getFullYear()+"-"+month_str+"-"+d.getDate();
      $('#date_of_birth').attr('max',dob_max);      


      let tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      

      let tom_month_str = '0';
      let tom_month = tomorrow.getMonth()+1;
      if(tom_month < 9){
        tom_month_str = tom_month_str + tom_month;
      }
      else{
        tom_month_str = tom_month;
      }

      let app_min = tomorrow.getFullYear()+"-"+tom_month_str+"-"+tomorrow.getDate();
      $('#book_app').attr('min',app_min);    


      let max_date = new Date();
      max_date.setDate(max_date.getDate() + 90);
      let max_month_str = '0';
      let max_month = max_date.getMonth()+1;
      if(max_month < 9){
        max_month_str = max_month_str + max_month;
      }
      else{
        max_month_str = max_month;
      }


      let app_max = max_date.getFullYear()+"-"+max_month_str+"-"+max_date.getDate();
      $('#book_app').attr('max',app_max);    
});


