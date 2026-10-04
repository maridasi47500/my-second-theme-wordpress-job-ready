<?php
if ( is_front_page() ) :
        get_header( 'home' );
elseif ( is_page( 'About' ) ) :
        get_header( 'about' );
else:
        get_header();
endif;?>


<?php if ( is_category( 'musique' ) ) : ?>
	<p>Voici la catégorie musique.</p>
<?php elseif ( is_category( 'voyage' ) ) : ?>
	<p>Dans cette catégorie, vous allez découvrir tous les articles sur le voyage.</p>
<?php else : ?>
	<p>Ici vous allez découvrir tous les articles non classés.</p>
<?php endif; ?>
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
echo "<div class=\"showpost\">";
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
echo "</div>";
    endwhile;
else:
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
endif;
?>



<?php get_footer(); ?>

