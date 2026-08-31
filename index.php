

<?php get_header() ?>
<h1><?php bloginfo( 'name' ); ?></h1>

<h3>version : <?php bloginfo( 'version' ); ?></h3>
<h2><?php bloginfo( 'description' ); ?></h2>
<div class="allposts">

<?php if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>

<div class="mypost">
<?php

            echo '<li><h3><a href="' . get_permalink() . '">&#127758;&#127926;' . get_the_title() . '</a></h3></li>';
?>
<?php if ( has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail(); ?>
    </a>
<?php endif; ?>





<?php the_category(); ?>
<?php the_author(); ?>
<?php the_excerpt(); ?>
<?php wp_link_pages(); ?>
<?php edit_post_link(); ?>
</div>

<?php endwhile; ?>
</div>

<?php
if ( get_next_posts_link() ) {
next_posts_link();
}
?>
<?php
if ( get_previous_posts_link() ) {
previous_posts_link();
}
?>

<?php else: ?>

<p>No posts found. :(</p>

<?php endif; ?>
<figure class="wp-block-image size-large">
  <img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/ballons.png' ) ); ?>"
       alt="Yosemite Valley at sunset"
       class="wp-image-123" />
  <figcaption class="wp-element-caption">
    The iconic view of Yosemite Valley during golden hour
  </figcaption>
</figure>
<?php 

 $video_file = esc_url( get_theme_file_uri( 'assets/img/myvid.mp4' ) ); 

echo do_shortcode( '[video mp4=' . $video_file . ' loop="on" autoplay=1]' );
?>



<?php get_footer(); ?>
