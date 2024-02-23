class search{
       constructor(){
        this.icon = $('.search_icon');
        this.text = $('#search_text');
        this.box = $('.search_box');
        this.timeout;
        this.results = $('#search_results');
        this.events();
    }
    events()
    {
        this.icon.on('click',this.toggle_search.bind(this));
        this.text.keyup(this.checkTiming.bind(this));
    }
    toggle_search(){
        
        this.box.toggle(1000);
    }
    checkTiming(){
        clearTimeout(this.timeout);
        this.timeout = setTimeout(this.searchData.bind(this),750);
    }
    searchData(){
        //alert(this.text.val());
        //searchString = this.text.val()
        if(this.text.val().length > 0)
        {
                var html='';
                var  url = "http://localhost/hospital/wp-json/wp/v2/department?search=" + this.text.val();
            // alert(url);
            $.getJSON(url, function(data){
                    if(data.length > 0)
                    {
                            html = '<h3>Departments<h3>';
                            html += `<ul>`;
                            data.forEach(function(post,index){
                                
                                html += `<li><a href="${post.link}"  class='search_item'>${post.title.rendered}</a></li>`; 
                                   
                            });
                            html += `</ul>`;
                            $('#search_results').slideDown();
                            $('#search_results').html(html);
                            console.log(html);
                    }
                });
                
                    url = "http://localhost/hospital/wp-json/wp/v2/doctor?search=" + this.text.val();
                    $.getJSON(url, function(data){
                        if(data.length > 0)
                        {
                                html += '<h3>Doctors<h3>';
                                html += `<ul>`;
                                data.forEach(function(post,index){
                                        html += `<li><a href="${post.link}" class='search_item'>${post.title.rendered}</a></li>`;
                                });
                                html += `</ul>`;
                                $('#search_results').slideDown();
                                $('#search_results').html(html);
                                console.log(html);
                        }
                          
                    });     
        }
        else{
            $('#search_results').slideUp();
        }
    }
}

class Doctors{
    constructor(){
        this.department = $('#select_department');
        this.doctors = $('#select_doctor');
        this.watch_event();
    }
    watch_event(){
        this.department.change(this.get_doctors.bind(this));
       /* this.department.change(function(){
            alert("The text has been changed.");
          }); */
            }
    get_doctors(){
        if(this.department.val().length > 0){

        let url = "http://localhost/hospital/wp-json/stmaryshospital/v2/departments?dept_id=" + this.department.val();
        var html = `<option value="">Choose a Doctor</option>`;
        //console.log(url);
                    $.getJSON(url, function(data){
                        if(data.length > 0)
                        {
                                data.forEach(function(post,index){
                                html += `<option value="${post.id}">${post.title}</option>`;
                        });
                        }
                        $('#select_doctor').html(html);
                    });     

                }
                else{
                    $('#select_doctor').html('<option>Select a Department</option>');
                }
    }
}


class Appointments{
    constructor(){
        this.search_button = $('#search_appointment');
        this.doctors = $('#select_doctor');        
        this.app_date = $('#date_of_app');
        $('#error').attr('hidden','true');
        this.get_appointments().bind(this);
    }
    get_appointments(){
        if(this.doctors.val()==null || this.doctors.val()=='' || this.app_date.val()==null || this.app_date.val()==''){
            $('#error').removeAttr('hidden');
        }
        else{

        let url = "http://localhost/hospital/wp-json/stmaryshospital/v2/appointments?doctor="+this.doctors.val()+"&date_of_app="+this.app_date.val();
        var result = `No Appointments Booked!`;
        console.log(url);
                    $.getJSON(url, function(data){
                        if(data.length > 0)
                        {
                                result = `<table class="table border border-2 table-striped">
                                <thead><tr><th>Sl No</th><th>Appointment Reference ID</th><th>Patient Registration Number</th><th>Patient Name</th><th>Booked On</th></tr></thead>`;
                                data.forEach(function(post,index){
                                result += `<tr><td>${index+1}</td><td>${post.appointment_ref_id}</td><td>${post.pr_number}</td><td>${post.patient_name}</td><td>${post.booking_date}</td>`;
                        });
                            result += `</talble>`;
                        }
                        $('#appointments').html(result);
                    });   
            }  
    }
}



class PatintInformation{
    constructor(){
        this.pr_number = $('#pr_number');
        this.date_of_birth = $('#date_of_birth');
        this.user_mobile = $('#user_mobile');
        this.filled = true;
        this.pr_number.removeClass('registration_error');
        this.date_of_birth.removeClass('registration_error');
        this.user_mobile.removeClass('registration_error');
        $('#existingaccount').attr('hidden','true');
        $('#no_prn_found').attr('hidden','true');
        $('#first_name').val('');
        $('#last_name').val('');
        $('#user_address').val('');
        $('#user_email').val('');
        $('#user_pass').val('');
        $('#re_password').val('');
        $('#gender_male').removeAttr('checked');
        $('#gender_female').removeAttr('checked');



        $('#pr_number_required').attr('hidden','true');
        $('#date_of_birth_required').attr('hidden','true');
        $('#user_mobile_required').attr('hidden','true');

        if(this.pr_number.val()==null || this.pr_number.val()==''){

            this.pr_number.addClass('registration_error');
            $('#pr_number_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.date_of_birth.val()==null || this.date_of_birth.val()==''){

            this.date_of_birth.addClass('registration_error');
            $('#date_of_birth_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.user_mobile.val()==null || this.user_mobile.val()==''){

            this.user_mobile.addClass('registration_error');
            $('#user_mobile_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.filled){
            this.get_patientInfo().bind(this);
        }
    }
    get_patientInfo(){
        
        let url = "http://localhost/hospital/wp-json/stmaryshospital/v2/patients?pr_number="+this.pr_number.val()+"&date_of_birth="+this.date_of_birth.val()+"&user_mobile="+this.user_mobile.val();
        var result = `No results found!`;
        console.log(url);
                    $.getJSON(url, function(data){
                        if(data.length > 0)
                        {
                            data.forEach(function(post,index){
                                console.log(post.name);
                                $('#first_name').val(post.first_name);
                                $('#last_name').val(post.last_name);
                                $('#user_email').val(post.user_email);
                                $('#user_address').val(post.user_address);
                                if(post.gender == 'MALE'){
                                    $('#gender_male').attr('checked','checked');
                                }
                                else{
                                    $('#gender_female').attr('checked','checked');
                                }
                                if(post.user_pass.length != 0){
                                    $('#user_pass').attr('disabled','disabled');
                                    $('#re_password').attr('disabled','disabled');
                                    $('#existingaccount').removeAttr('hidden');
                                }
                            });
                           
                        }
                        else{
                            $('#no_prn_found').removeAttr('hidden');
                        }
                        
                    });     

    }
}

class validateRegistration{
    constructor(){
        this.error_html = '';
        this.filled = true;
        this.pr_number = $('#pr_number');
        this.date_of_birth = $('#date_of_birth');
        this.first_name = $('#first_name');
        this.last_name = $('#last_name');
        this.user_mobile = $('#user_mobile');
        this.user_address = $('#user_address');
        this.user_email = $('#user_email');
        this.date_of_birth = $('#date_of_birth');
        this.user_pass = $('#user_pass');
        this.re_password = $('#re_password');
        this.registr_btn = $('#registr_btn');

        this.date_of_birth.removeClass('registration_error');
        this.first_name.removeClass('registration_error');
        this.last_name.removeClass('registration_error');
        this.user_mobile.removeClass('registration_error');
        this.user_address.removeClass('registration_error');
        this.user_email.removeClass('registration_error');
        this.user_pass.removeClass('registration_error');
        this.re_password.removeClass('registration_error');

        $('#date_of_birth_required').attr('hidden','true');
        $('#user_mobile_required').attr('hidden','true');
        $('#first_name_required').attr('hidden','true');
        $('#last_name_required').attr('hidden','true');
        $('#gender_required').attr('hidden','true');
        $('#user_address_required').attr('hidden','true');
        $('#user_email_required').attr('hidden','true');
        $('#user_pass_required').attr('hidden','true');
        $('#re_password_required').attr('hidden','true');
        $('#user_email_required').text('This field is required');
        $('#user_pass_required').text('This field is required');
        $('#re_password_required').text('This field is required');

        $('#validation_errors').empty();
    }
    validate_data(){
        
        if(this.date_of_birth.val()==null || this.date_of_birth.val()==''){

            this.date_of_birth.addClass('registration_error');
            $('#date_of_birth_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.user_mobile.val()==null || this.user_mobile.val()==''){

            this.user_mobile.addClass('registration_error');
            $('#user_mobile_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.first_name.val()==null || this.first_name.val()==''){

            this.first_name.addClass('registration_error');
            $('#first_name_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.last_name.val()==null || this.last_name.val()==''){

            this.last_name.addClass('registration_error');
            $('#last_name_required').removeAttr('hidden');
            this.filled = false;
        }
        if(!$('#gender_male').is(':checked') && !$('#gender_female').is(':checked')){
            $('#gender_required').removeAttr('hidden');
            this.filled = false;
        }
        
        if($.trim(this.user_address.val())==null || $.trim(this.user_address.val())==''){

            this.user_address.addClass('registration_error');
            $('#user_address_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.user_email.val()==null || this.user_email.val()==''){

            this.user_email.addClass('registration_error');
            $('#user_email_required').removeAttr('hidden');
            this.filled = false;
        }
        else if(!this.IsEmail()){
            this.user_email.addClass('registration_error');
            $('#user_email_required').text('Please enter a valid email ID');
            $('#user_email_required').removeAttr('hidden');
            this.filled = false;
        }
        if(this.user_pass.val()==null || this.user_pass.val()==''){

            this.user_pass.addClass('registration_error');
            $('#user_pass_required').removeAttr('hidden');
            this.filled = false;
        }
        else if(this.user_pass.val().length < 5 || this.user_pass.val().length > 15){
            this.user_pass.addClass('registration_error');
            $('#user_pass_required').text('Password length should be 5-15 characters');
            $('#user_pass_required').removeAttr('hidden');
            this.filled = false;
        }
        else if(!this.IsPassword()){
            this.user_pass.addClass('registration_error');
            $('#user_pass_required').text('Password should contain only alphabets and numericals');
            $('#user_pass_required').removeAttr('hidden');
            this.filled = false;
        }
        else if(this.re_password.val()==null || this.re_password.val()==''){

            this.re_password.addClass('registration_error');
            $('#re_password_required').removeAttr('hidden');
            this.filled = false;
        }
        else if(this.user_pass.val()!==this.re_password.val()){
            this.re_password.addClass('registration_error');
            $('#re_password_required').text('Retyped Password should match password');
            $('#re_password_required').removeAttr('hidden');
            this.filled = false;
        }
        
        return this.filled;
    }
    IsEmail() {
        const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (regex.test(this.user_email.val())) {
            return true;
        }
        else {
            return false;
        }
    }
    IsPassword(){
        let pattern = /^[a-zA-Z0-9]+$/;
        return pattern.test(this.user_pass.val());
    }
}

class LoginValidation{
    constructor(){
        this.user_email = $('#login_user_email');
        this.user_pass = $('#login_user_pass');
        this.error_html = '';
        this.filled = true;
    }
    validateLogin(){
      //  alert('kjhkjh');
        if(this.user_email.val()==null || this.user_email.val()==''){

            this.user_email.addClass('registration_error');
            this.error_html += '<div> Please Provide your registerd Email ID</div>';
            this.filled = false;
        }
        if(this.user_pass.val()==null || this.user_pass.val()==''){

            this.user_pass.addClass('registration_error');
            this.error_html += '<div> Please provide Password</div>';
            this.filled = false;
        }
        $('#error_display').html(this.error_html);
        return this.filled;
    }
}


