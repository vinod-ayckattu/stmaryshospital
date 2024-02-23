<?php
get_header();
?>
<div class="single_details m-5">
    <span class="single_content">
    <?php
while(have_posts()){
    the_post();?>
<h3>Department of <?php the_title();?></h3>
<p><?php the_content();?></p>
<?php    
}
?>
    </span>
<span><?php the_post_thumbnail(array(420,420));?></span>
</div>

<?php
$doctors = new WP_Query(array(
    'post_type' => 'doctor',
    'meta_query' => array(
        array(
            'key' => 'department',
            'compare' => 'LIKE',
            'value' => get_the_ID()
        )
    ),
));
if($doctors->have_posts())
{
?>
<div class="m-5"><h3>Doctors in Department of <?php the_title();?></h3></div>
<div class="m-5 row">
<?php    
while($doctors->have_posts()) {
$doctors->the_post();
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
wp_reset_postdata();
?>
</div>
<?php
}
get_footer();
?>