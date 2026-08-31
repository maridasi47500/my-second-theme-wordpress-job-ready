<?php get_header() ?>
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        if ( is_category( 'voyage' ) ):
            echo '<li><h3><a href="' . get_permalink() . '">&#127758;' . get_the_title() . '</a></h3></li>';
        elseif ( is_category( 'musique' ) ):

            echo '<li><h3><a href="' . get_permalink() . '">&#127926;' . get_the_title() . '</a></h3></li>';


        else:
            echo '<li><h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3></li>';

	endif;

        echo '<p>' . get_the_author() . "</p>";
        the_post_thumbnail();
        the_excerpt();
    endwhile;
else:
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
endif;
?>
<?php get_footer() ?>
