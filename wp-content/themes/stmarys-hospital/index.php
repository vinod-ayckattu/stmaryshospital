<?php
if(is_user_logged_in()  AND current_user_can('edit_posts') AND !current_user_can('edit_users')) { 
    wp_redirect(site_url('manage-appointments'));
}
get_header();
?>
<div class="image_div">
<img class="main_image" src="<?php echo esc_url(get_theme_file_uri('images/main_image.jpg')) ?>">
<div class="searchbox_outer">
    <img class="search_icon" src="<?php echo esc_url(get_theme_file_uri('images/search_icon.jpg')) ?>">
<div class="search_box">
                    <input type="text" id="search_text" placeholder="Search for Departments/Doctors..">
                    <div id="search_results">
    </div>
</div>
</div>
</div>
<div class="p-5 bg-light">
    <h2 class="text-success">Why St.Mary's Hospital</h2>
    <p class="fs-5">Your health is our priority. St.Mary's Hospital ensures you and your family receive the best possible medical care and assistance. We strive to create a warm and safe healing environment for you and your family. Over the past decade, Amrita has been unflinchingly devoted to improving healthcare and treatment. Medical specialists have been working diligently to conduct research and educate future generations of doctors and healthcare workers.

As our entire team works toward your speedy recovery, we utilize highly-trained doctors and cutting-edge technology in the field of medical sciences.</p>
</div>
<div class="p-5">
    <h2>News</h2>
<?php
while(have_posts()){
    the_post();?>
    <div class="pt-3 fs-5">
<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
<p class="fs-5"><?php the_content();?></p>
</div>

<?php    
}
?>
</div>
<?php
get_footer();
?>