

<footer id="colophon" class="site-footer" role="contentinfo">
<p>footer</p>
<?php get_sidebar(); ?>
<?php wp_list_categories(); ?>
<div class="widget-section mypost">
widget here : 
	<?php 
// Source - https://stackoverflow.com/a/12317831
// Posted by shasi kanth, modified by community. See post 'Timeline' for change history
// Retrieved 2026-09-13, License - CC BY-SA 3.0

/*require_once 'swift/lib/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('GMAIL_USERNAME')
  ->setPassword('GMAIL_PASSWORD');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('Test Subject')
  ->setFrom(array('abc@example.com' => 'ABC'))
  ->setTo(array('xyz@test.com'))
  ->setBody('This is a test mail.');

$result = $mailer->send($message);*/

$instance = array();
                if ( empty( $_GET['title'])  ) {
$instance['title'] = "hello";
		} else {
$instance['title'] = $_GET['title'];
		}
                if ( empty( $_GET['email'])  ) {
$instance['email'] = "";
		} else {
$instance['email'] = $_GET['email'];
		}


                if ( empty( $_GET['text'] )) {

$instance['text'] = "how are you today";
		} else {
$instance['text'] = $_GET['text'];
		}
#$args = array();
#$args['title'] = 'sample';
#$args['text'] = 'text';

the_widget( 'WPDocs_New_Widget', $instance ); ?>
</div><!-- .widget-section -->
<div class="mypost">
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

