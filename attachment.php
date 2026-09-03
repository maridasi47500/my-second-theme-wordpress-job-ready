<div class="entry-attachment">
	<?php
	$image_size = apply_filters( 'wporg_attachment_size', 'large' );
	echo wp_get_attachment_image( get_the_ID(), $image_size );
	?>

	<?php if ( has_excerpt() ) : ?>
		<div class="entry-caption">
			<?php the_excerpt(); ?>
		</div><!-- .entry-caption -->
	<?php endif; ?>
</div><!-- .entry-attachment -->
