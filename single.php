<?php get_header() ?>

<?php
if ( have_posts() ) : ?>
	     <!-- Start the pagination functions before the loop. -->
    <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
    <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
    <!-- End the pagination functions before the loop. -->

<?php while ( have_posts() ) : the_post();

if ( is_user_logged_in() ):

 edit_post_link(); 
 endif; 

        the_title( '<h1>', '</h1>' );
        // Source - https://stackoverflow.com/a/22182574
        // Posted by Rahil Wazir, modified by community. See post 'Timeline' for change history
        // Retrieved 2026-08-30, License - CC BY-SA 4.0
        

        the_content();
        $post = get_post();
        //$post_id = empty( $post ) ? $post->ID : false;
	
         $gallery_shortcode = '[gallery id="' . intval( $post->ID ) . '"]';
         print apply_filters( 'the_content', $gallery_shortcode );

	 endwhile;?>
    <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
    <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

<?php else:
    _e( 'Sorry, no pages matched your criteria.', 'textdomain' );
endif;
?>
<?php
if ( is_user_logged_in() ):?>

<?php edit_post_link(); ?>
<?php endif; ?>



<?php get_footer() ?>
