<?php
if(!is_user_logged_in()) {

    wp_redirect(site_url('login'));
}
else if(!current_user_can('edit_posts')){
    wp_redirect(site_url('appointments'));
}
get_header();?>

<form action="#" method="get" onsubmit="return false">
<div class="row m-3">
    <div class="col"></div>
    <div class="col border border-1 border-success rounded-2 m-3 p-3">
                    <h2 class="text-success text-center"><?php the_title();?></h2>
                    <div class="form_item m-3">
                    <select class="form-control" name="department" id="select_department">
                        <option value="">Select Department</option>
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
                    <div class="form_item m-3">
                    <select name="doctor" id="select_doctor" class="form-control">
                        <option>Choose a Department First</option>
                    </select>
                </div>
                <div class="form_item m-3">
                    <input type="date" name="date_of_app" id="date_of_app" class="form-control"> 
                </div>
                <div class="form_item m-3 text-center">
                    <input type="submit" id="search_appointment" value="Get Appointments" class='btn btn-primary'> 
                    <div id="error" hidden="true" class="text-danger">Please fill all the fields</div>
                </div>
                <input type="hidden" name="action" value="contact_form">
                </form>
                
    </div>
    <div class="col"></div>
</div>
<div class="row">
    <div class="col"></div>
    <div class="col-8 text-center">
    <div id="appointments">
    </div>
    </div>
    <div class="col"></div>
</div>
<?php
get_footer();
?>