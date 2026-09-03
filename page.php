
<?php
if ( is_front_page() ) :
	get_header( 'home' );
elseif ( is_page( 'About' ) ) :
	get_header( 'about' );
else:
	get_header();
endif;?>
<?php if ( is_category( 'musique' ) ) : ?>
        <p>This is the text to describe category A.</p>
<?php elseif ( is_category( 'voyage' ) ) : ?>
        <p>This is the text to describe category B.</p>
<?php else : ?>
        <p>hey hey hey This is some generic text to describe all other category pages, I could be left blank.</p>

<?php endif; ?>
<?php while ( have_posts() ) : the_post();?>
<h1><?php the_title(); ?></h1>
<p><?php the_content(); ?></p>
<?php endwhile; ?>

