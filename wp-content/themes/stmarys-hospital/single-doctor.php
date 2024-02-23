<?php
get_header();
?>
<div class="single_details m-5">
    <span class="single_content">
    <?php
while(have_posts()){
    the_post();?>
<h3><?php the_title();?></h3>
<p><?php the_content();?></p>
<?php    
}
?>
    </span>
<span><?php the_post_thumbnail(array(420,420));?></span>
</div>
<?php
get_footer();
?>