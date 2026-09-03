<?php if ( is_category( 'musique' ) ) : ?>
	<p>This is the text to describe category A.</p>
<?php elseif ( is_category( 'voyage' ) ) : ?>
	<p>This is the text to describe category B.</p>
<?php else : ?>
	<p>hey hey hey This is some generic text to describe all other category pages, I could be left blank.</p>
<?php while ( have_posts() ) : the_post();?>
hey
<?php the_content(); ?>
<?php endwhile; ?>
<?php endif; ?>

