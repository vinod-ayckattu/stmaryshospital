<form action="<?php echo esc_url( admin_url('admin-post.php') );?>" method="POST">
<div class="form_item">
    <select name="doctor" id="doctor">
    <?php
        $doctors = new WP_Query(array(
                'post_type'=>'doctor'
        ));
        while($doctors->have_posts()){
            $doctors->the_post();
        
    ?>
    <option value="<?php echo get_the_ID()?>"><?php echo get_the_title(); ?></option>
    <?php
    }
    ?>
    </select>
</div>
<div class="form_item">
    <input type="date" name="date_of_app">
</div>
<input type="hidden" name="action" value="get_appointments">
<div class="form_item">
    <input type="submit" value="Submit">
</div>
</form>