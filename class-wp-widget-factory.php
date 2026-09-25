<?php
/**
 * Widget API: WP_Widget_Factory class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Singleton that registers and instantiates WP_Widget classes.
 *
 * @since 2.8.0
 * @since 4.4.0 Moved to its own file from wp-includes/widgets.php
 */
#[AllowDynamicProperties]
require_once(get_template_directory().'/../../../../wordpress/wp-includes/PHPMailer/PHPMailer.php');
require_once(get_template_directory().'/../../../wp-config.php');
require_once(get_template_directory().'/../../../../wordpress/wp-includes/PHPMailer/SMTP.php');
require_once(get_template_directory().'/../../../../wordpress/wp-includes/PHPMailer/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class WP_Widget_Factory {

	/**
	 * Widgets array.
	 *
	 * @since 2.8.0
	 * @var array
	 */
	public $widgets = array();

	/**
	 * PHP5 constructor.
	 *
	 * @since 4.3.0
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, '_register_widgets' ), 100 );
	}

	/**
	 * PHP4 constructor.
	 *
	 * @since 2.8.0
	 * @deprecated 4.3.0 Use __construct() instead.
	 *
	 * @see WP_Widget_Factory::__construct()
	 */
	public function WP_Widget_Factory() {
		_deprecated_constructor( 'WP_Widget_Factory', '4.3.0' );
		self::__construct();
	}

	/**
	 * Registers a widget subclass.
	 *
	 * @since 2.8.0
	 * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
	 *              instead of simply a `WP_Widget` subclass name.
	 *
	 * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
	 */
	public function register( $widget ) {
		if ( $widget instanceof WP_Widget ) {
			$this->widgets[ spl_object_id( $widget ) ] = $widget;
		} else {
			$this->widgets[ $widget ] = new $widget();
		}
	}

	/**
	 * Un-registers a widget subclass.
	 *
	 * @since 2.8.0
	 * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
	 *              instead of simply a `WP_Widget` subclass name.
	 *
	 * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
	 */
	public function unregister( $widget ) {
		if ( $widget instanceof WP_Widget ) {
			unset( $this->widgets[ spl_object_id( $widget ) ] );
		} else {
			unset( $this->widgets[ $widget ] );
		}
	}

	/**
	 * Serves as a utility method for adding widgets to the registered widgets global.
	 *
	 * @since 2.8.0
	 *
	 * @global array $wp_registered_widgets
	 */
	public function _register_widgets() {
		global $wp_registered_widgets;
		$keys       = array_keys( $this->widgets );
		$registered = array_keys( $wp_registered_widgets );
		$registered = array_map( '_get_widget_id_base', $registered );

		foreach ( $keys as $key ) {
			// Don't register new widget if old widget with the same id is already registered.
			if ( in_array( $this->widgets[ $key ]->id_base, $registered, true ) ) {
				unset( $this->widgets[ $key ] );
				continue;
			}

			$this->widgets[ $key ]->_register();
		}
	}

	/**
	 * Returns the registered WP_Widget object for the given widget type.
	 *
	 * @since 5.8.0
	 *
	 * @param string $id_base Widget type ID.
	 * @return WP_Widget|null
	 */
	public function get_widget_object( $id_base ) {
		$key = $this->get_widget_key( $id_base );
		if ( '' === $key ) {
			return null;
		}

		return $this->widgets[ $key ];
	}

	/**
	 * Returns the registered key for the given widget type.
	 *
	 * @since 5.8.0
	 *
	 * @param string $id_base Widget type ID.
	 * @return string
	 */
	public function get_widget_key( $id_base ) {
		foreach ( $this->widgets as $key => $widget_object ) {
			if ( $widget_object->id_base === $id_base ) {
				return $key;
			}
		}

		return '';
	}
}
class WPDocs_New_Widget extends WP_Widget {

	/**
	 * Constructs the new widget.
	 *
	 * @see WP_Widget::__construct()
	 */
	function __construct() {
		// Instantiate the parent object.
	        parent::__construct(
                        'my-text',  // Base ID
                        'My Text'   // Name
                );
                #add_action( 'widgets_init', function() {
                #        register_widget( 'WPDocs_New_Widget' );
                #});
	}



	/**
	 * The widget's HTML output.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Display arguments including before_title, after_title,
	 *                        before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	        public $args = array(
                'before_title'  => '<h4 class="widgettitle">',
                'after_title'   => '</h4>',
                'before_widget' => '<div class="widget-wrap">',
                'after_widget'  => '</div></div>',
        );

	function widget( $args, $instance ) {
		echo $args['before_widget'];
                if ( ! empty( $instance['email'] ) ) {
                        echo $args['before_title'] . apply_filters( 'widget_title', $instance['email'] ) . $args['after_title'];
                }
                if ( ! empty( $instance['title'] ) ) {
                        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
                if ( ! empty( $instance['text'] ) ) {
                echo '<div class="textwidget">';
                echo esc_html__( $instance['text'], 'text_domain' );
                echo '</div>';
                }
                echo '<div class="formwidget">';
                if ( ! empty( $instance['title']) && ! empty( $instance['text'] ) ) {

		echo $this->form($instance);
                if ( ! empty( $instance['email'] ) ) {
                $mail = new PHPMailer;
                
                $mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Port = '587';
                $mail->Host = 'smtp.gmail.com';  // separate by ";"  ;;;Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = MYEMAIL;                 // SMTP username
                $mail->Password = MYPASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
                
                $mail->From = MYEMAIL;
                $mail->FromName = 'Mailer';
                $mail->addAddress($instance['email'], 'Joe User');     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
                
                $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
                //#$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML
                
                $mail->Subject =  'Here is the subject' . $instance["title"];
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>' . $instance["text"];
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->CharSet = 'UTF-8';
                
                if(!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent';
                }
                }

		} else {
			echo "no form";
		}
                echo '</div>';
                echo $args['after_widget'];

	
	}

	/**
	 * The widget update handler.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance The new instance of the widget.
	 * @param array $old_instance The old instance of the widget.
	 * @return array The updated instance of the widget.
	 */
	function update( $new_instance, $old_instance ) {
                $instance          = array();
                $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
                $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                $instance['text']  = ( ! empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
                return $instance;

	}

	/**
	 * Output the admin widget options form HTML.
	 *
	 * @param array $instance The current widget settings.
	 * @return string The HTML markup for the form.
	 */
	function form( $instance ) {
		$email = ! empty( $instance['email'] ) ? $instance['email'] : esc_html__( '', 'text_domain' );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
                $text  = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
		$myemail=$this->get_field_id('email' );
		$mytitle=$this->get_field_id('title' );
		$mytext=$this->get_field_id('text' );

		return "<form action=\"\"><p>
                        <label for=\"" . esc_attr($mytitle ) . "\">" . esc_html__( 'Title:', 'text_domain' ) . "</label><input class=\"widefat\" id=\"" .  esc_attr( $mytitle ) . "\" name=\"" . esc_attr( 'title' ) . "\" type=\"text\" value=\"" .  esc_attr( $title ) . "\" >
                </p>
                <p>
                        <label for=\"" .   esc_attr( $myemail ) . "\">" .   esc_html__( 'Email:', 'text_domain' ) . "</label>
                        <input class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"".  esc_attr( 'email' ) . "\" type=\"text\" cols=\"30\" rows=\"10\" value=\"" .  esc_attr( $email ) . "\" type=\"email\"/>
                </p>
                <p>
                        <label for=\"" .   esc_attr( $mytext ) . "\">" .   esc_html__( 'Text:', 'text_domain' ) . "</label>
                        <textarea class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"".  esc_attr( 'text' ) . "\" type=\"text\" cols=\"30\" rows=\"10\">" .  esc_attr( $text ) . "</textarea>
                </p>
                <p class=\"actions\">
<input type=\"submit\" value=\"envoyer\"/>
                        
                </p></form>";
	}
}
add_action( 'widgets_init', 'wpdocs_register_widgets' );

