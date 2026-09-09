

<footer id="colophon" class="site-footer" role="contentinfo">
<p>footer</p>
<?php get_sidebar(); ?>
<?php wp_list_categories(); ?>
<div class="widget-section">
widget here : 
	<?php 
$instance = array();
echo $_GET['title'];
echo $_GET['text'];
$instance['title'] = $_GET['title'];
$instance['text'] = $_GET['text'];
                if ( empty( $instance['title']) ) {
$instance['title'] = "hello";
}
                if ( empty( $instance['text'] )) {

$instance['text'] = "how are you today";
}
#$args = array();
#$args['title'] = 'sample';
#$args['text'] = 'text';

the_widget( 'WPDocs_New_Widget', $instance, $args ); ?>
</div><!-- .widget-section -->
<div>
<?php 
if ( is_user_logged_in() ):
    echo '<p>vous etes bien connecté(e)';
    echo '<a href="' . wp_logout_url() . '">se déconnecter</a>';

else:

    wp_login_form();
endif;
	 
?>
</div><!-- .site-content -->

	<div class="site-info">

		<?php
		/**
		 * Fires before the Twenty Fifteen footer text for footer customization.
		 *
		 * @since Twenty Fifteen 1.0
		 */
		do_action( 'twentyfifteen_credits' );
		?>
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyfifteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyfifteen' ), 'WordPress' ); ?></a>

	</div><!-- .site-info -->

</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

<style>
.someerror {
background: #8B0000;
color:white;
font-size: 34;
font-weight:900;

}

</style>

</body>
</html>

