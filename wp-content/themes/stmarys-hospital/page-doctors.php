<?php
get_header();?>
<div class="m-5 text-left">
    <h2><?php the_title();?></h2>
    <p>In order for WordPress to recognize the set of theme template files as a valid theme, the style.css file needs to be located in the root directory of your theme, not a sub directory.

For more detailed explanation on how to include the style.css file in a theme, see the “Stylesheets” section.In order for WordPress to recognize the set of theme template files as a valid theme, the style.css file needs to be located in the root directory of your theme, not a sub directory.

For more detailed explanation on how to include the style.css file in a theme, see the “Stylesheets” section.In order for WordPress to recognize the set of theme template files as a valid theme, the style.css file needs to be located in the root directory of your theme, not a sub directory.

For more detailed explanation on how to include the style.css file in a theme, see the “Stylesheets” section.</p>
</div>
<div class="m-5 row">

<?php
$departments = new WP_Query(array(
'post_type'=>'doctor'
));
while($departments->have_posts()){
    $departments->the_post();
    
    ?>

<div class="card custom_type_list" style="width:450px">
    <!--<img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">-->
    <div class="card-img-top"><?php the_post_thumbnail(array(430,430));?></div>
    <div class="card-body">
      <h4 class="card-title"><a href="<?php the_permalink()?>"><?php the_title();?></a></h4>
      <p class="card-text"><?php echo wp_trim_words(get_the_content(),30);?>...<a href="<?php the_permalink()?>">See more</a></p>
    </div>
  </div>
<?php    
}
wp_reset_postdata();?>
</div>
<?php
get_footer();
?>