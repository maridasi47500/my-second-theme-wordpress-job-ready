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
class WPDocs_Musical_Widget extends WP_Widget {

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
                if ( ! empty( $instance['someemail'] ) ) {
                        echo $args['before_title'] . apply_filters( 'widget_title', $instance['someemail'] ) . $args['after_title'];
                }
                if ( ! empty( $instance['sometitle'] ) ) {
                        echo $args['before_title'] . apply_filters( 'widget_title', $instance['sometitle'] ) . $args['after_title'];
                }
                if ( ! empty( $instance['sometext'] ) ) {
                echo '<div class="textwidget">';
                echo esc_html__( $instance['sometext'], 'text_domain' );
                echo '</div>';
                }
                if ( ! empty( $instance['musicaltext'] ) ) {
                echo '<div class="musicaltextwidget"> MUSICAL TEXT : ';
                echo esc_html__( $instance['musicaltext'], 'text_domain' );
                echo '</div>';
                }
                echo '<div class="formwidget">';
                if ( ! empty( $instance['sometitle']) && ! empty( $instance['sometext'] ) ) {

		echo $this->form($instance);
                if ( ! empty( $instance['someemail'] ) ) {
			$myid=substr(md5(mt_rand()), 0, 7);
			  $realpicvalue= "scoretosend_myscore_sample_" . $myid . ".png";
			  $mypicvalue= "scoretosend_myscore_sample_" . $myid ;
			$getMyscore=stripslashes($instance["musicaltext"]);
			$getKeySignature=$instance["keysignature"];
			$getTimeSignature=$instance["timesignature"];
			$lilypondname="/../wp-content/themes/my-second-theme/assets/scores/scoretosend_myscore_sample_" . $myid . ".ly";
			$somepicname="/../wp-content/themes/my-second-theme/assets/scores/" . $mypicvalue;
			$picname="/../wp-content/themes/my-second-theme/assets/scores/" . $realpicvalue;
			$htmlname="/../wp-content/themes/my-second-theme/assets/scores/scoretosend_myscore_sample_" . $myid . ".html";
			$samplescore="/../wp-content/themes/my-second-theme/samplescoreexample.ly";

	    $file_pointer = fopen(__DIR__ . $samplescore, "r") or die("Unable to open file of the score example!");
            $contents= fread($file_pointer, filesize(__DIR__ . $samplescore));
            fclose($file_pointer);
	    //echo str_replace("world", "Peter", "Hello world!");
	    $contents= str_replace("KEYSCOREHERE", str_replace(" ", "\\", $getKeySignature), $contents);
	    $contents= str_replace("TIMESCOREHERE", $getTimeSignature, $contents);
	    $contents= str_replace("CONTENTSCOREHERE", $getMyscore, $contents);
            $myfile = fopen(__DIR__ . $lilypondname, "w") or die("Unable to open file to write the score in it!");
            fwrite($myfile, $contents);
            fclose($myfile);
            $myfile = fopen(__DIR__ . $htmlname, "w") or die("Unable to open file!");
            fwrite($myfile, "<lilypond staffsize=34>" . $contents . "</lilypond>");
            fclose($myfile);

            ob_start();



            $p1=["lilypond", "-dclip-systems",  "--output=\"" . __DIR__ . $somepicname . "\"", "--png", __DIR__ . $lilypondname];


            //echo "j'ai voulu essayer" . (join(" ", $p1));
            $dir = shell_exec(join(" ", $p1));
            if (is_null($dir))
            {


		    echo "<p>hop! la partition doit avoir été transformée en image</p>";
	    } else {

		    echo "<p>hop! la partition a été transformée en image</p>";
	    }
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
                $mail->addAddress($instance['someemail'], 'Joe User');     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
                
                $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
                //#$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                //$mail->addAttachment(__DIR__ . $lilypondname, 'MyId1');    // Optional name
                //$mail->addAttachment(__DIR__ . $picname);    // Optional name
                $mail->addEmbeddedImage(__DIR__ . $picname, "MyId1");    // Optional name
                //$mail->addAttachment(__DIR__ . $lilypondname, 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML
                
                $mail->Subject =  'Here is the subject' . $instance["sometitle"];
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>' . stripslashes($instance["sometext"]) . "<img src=\"cid:MyId1\"/>";
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
                $instance['musicaltext'] = ( ! empty( $new_instance['musicaltext'] ) ) ? strip_tags( $new_instance['musicaltext'] ) : '';
                $instance['someemail'] = ( ! empty( $new_instance['someemail'] ) ) ? strip_tags( $new_instance['someemail'] ) : '';
                $instance['sometitle'] = ( ! empty( $new_instance['sometitle'] ) ) ? strip_tags( $new_instance['sometitle'] ) : '';
                $instance['sometext']  = ( ! empty( $new_instance['sometext'] ) ) ? $new_instance['sometext'] : '';
                $instance['timesignature']  = ( ! empty( $new_instance['timesignature'] ) ) ? $new_instance['timesignature'] : '';
                $instance['keysignature']  = ( ! empty( $new_instance['keysignature'] ) ) ? $new_instance['keysignature'] : '';
                return $instance;

	}

	/**
	 * Output the admin widget options form HTML.
	 *
	 * @param array $instance The current widget settings.
	 * @return string The HTML markup for the form.
	 */
	function form( $instance ) {
		$email = ! empty( $instance['someemail'] ) ? $instance['someemail'] : esc_html__( '', 'text_domain' );
		$title = ! empty( $instance['sometitle'] ) ? $instance['sometitle'] : esc_html__( '', 'text_domain' );
                $text  = ! empty( $instance['sometext'] ) ? $instance['sometext'] : esc_html__( '', 'text_domain' );
                $musicaltext  = ! empty( $instance['musicaltext'] ) ? $instance['musicaltext'] : esc_html__( '', 'text_domain' );
                $keysignature  = ! empty( $instance['keysignature'] ) ? $instance['keysignature'] : esc_html__( '', 'text_domain' );
                $timesignature  = ! empty( $instance['timesignature'] ) ? $instance['timesignature'] : esc_html__( '', 'text_domain' );
		$myemail=$this->get_field_id('someemail' );
		$mytitle=$this->get_field_id('sometitle' );
		$mytext=$this->get_field_id('sometext' );
		$mymusicaltext=$this->get_field_id('musicaltext' );
		$mykeysignature=$this->get_field_id('keysignature' );
		$mytimesignature=$this->get_field_id('timesignature' );

		return "<form action=\"\">
			<p>
                        <label for=\"" . esc_attr($mytitle ) . "\">" . esc_html__( 'Title:', 'text_domain' ) . "</label><input class=\"widefat\" id=\"" .  esc_attr( $mytitle ) . "\" name=\"" . esc_attr( 'sometitle' ) . "\" type=\"text\" value=\"" .  esc_attr( $title ) . "\" >
                </p>
                <p>
                        <label for=\"" .   esc_attr( $myemail ) . "\">" .   esc_html__( 'Email:', 'text_domain' ) . "</label>
                        <input class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"".  esc_attr( 'someemail' ) . "\" cols=\"30\" rows=\"10\" value=\"" .  esc_attr( $email ) . "\" type=\"email\"/>
                </p>
                <p>
                        <label for=\"" .   esc_attr( $mytext ) . "\">" .   esc_html__( 'Text:', 'text_domain' ) . "</label>
                        <textarea class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"".  esc_attr( 'sometext' ) . "\" type=\"text\" cols=\"30\" rows=\"10\">" .  esc_attr( stripslashes($text) ) . "</textarea>
                </p>
                <p>
                        <label for=\"" .   esc_attr( $mykeysignature ) . "\">" .   esc_html__( 'My key signature (c major, d minor, etc):', 'text_domain' ) . "</label>
                        <input class=\"widefat\" id=\"" .  esc_attr( $mykeysignature ) . "\" name=\"".  esc_attr( 'keysignature' ) . "\" type=\"text\" cols=\"30\" rows=\"10\" value=\"" .  esc_attr( $keysignature ) . "\" />
                </p>
                <p>
                        <label for=\"" .   esc_attr( $mytimesignature ) . "\">" .   esc_html__( 'My time signature (4/4, 3/4, 6/8, etc):', 'text_domain' ) . "</label>
                        <input class=\"widefat\" id=\"" .  esc_attr( $mytimesignature ) . "\" name=\"".  esc_attr( 'timesignature' ) . "\" type=\"text\" cols=\"30\" rows=\"10\" value=\"" .  esc_attr( $timesignature ) . "\" />
                </p>
                <p>
                        <label for=\"" .   esc_attr( $mymusicaltext ) . "\">" .   esc_html__( 'My musical Text like a signature:', 'text_domain' ) . "</label>
                        <textarea class=\"widefat\" id=\"" .  esc_attr( $mymusicaltext ) . "\" name=\"".  esc_attr( 'musicaltext' ) . "\" type=\"text\" cols=\"30\" rows=\"10\">" . esc_attr( stripslashes( $musicaltext )) . "</textarea>
                </p>
                <p class=\"actions\">
<input type=\"submit\" value=\"envoyer\"/>
                        
                </p></form>";
	}
}
class WPDocs_IG_Widget extends WP_Widget {

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
                if ( ! empty( $instance['account'] ) ) {
                        echo $args['before_title'] . "photos du compte " . apply_filters( 'widget_title', $instance['account'] ) . $args['after_title'];

		} else {
                        echo $args['before_title'] . "chercher les photos d'un compte instagram " . $args['after_title'];
                }
                echo '<div class="formwidget">';

		echo $this->form($instance);
                echo '</div>';
                if ( ! empty( $instance['account'] ) ) {
                    echo '<div class="photoswidget">';
                    $username = $instance['account'];
		    $header = array();
                    $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
                    $header[] = 'Cache-Control: max-age=0';
                    $header[] = 'Content-Type: text/html; charset=utf-8';
                    $header[] = 'Connection: keep-alive';
                    $header[] = 'Keep-Alive: 300';
                    $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
                    $header[] = 'Accept-Language: en-us,en;q=0.5';
                    $header[] = 'Pragma: ';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/' . $username );
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_ENCODING, '');
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    $instaResult = curl_exec($ch);
		    
                    curl_close ($ch);

		    $mypizza=explode("<script", $instaResult);
		    function array_get_nested_value($data, array $keys) {
                        if (empty($keys)) {
                            return $data;
                        }
                        $current = array_shift($keys);
			echo "array:: <p>" . json_encode($data) . "</p>";
			echo "key:::: <p>" . $current . "</p>";
			try{
                        if (!is_array($data) || !isset($data[$current])) {
                        if (!isset($data[$current])) {
                            // key does not exist or $data does not contain an array
                            // you could also throw an exception here
			    echo "division by zero";
			        throw new Exception('Division by zero.');
			}
		         $i = array_search($current, $data);
			 if (! $i) {
                            return null;
			 } else {
				 $current=$i;
			 }
			}else{
			    echo "HEYYY";
                        }
			}catch(Exception $e) {
		         $i = array_search($current, $data);
			 if (! $i) {
                            return null;
			 } else {
				 $current=$i;
			 }
			}
			//echo $current;
                        return array_get_nested_value($data[$current], $keys);
                    }

		    foreach ($mypizza as $item) {
			    //echo "item";
			    if (str_contains($item, "Photo by")){
				    //echo "photo";
				    $jsoncontent=explode(">", $item)[1];
				    //echo $jsoncontent;
				    $jsoncontent1=explode("</script>", $jsoncontent)[0];
				    //echo "<code>" . $jsoncontent1 . "</code>";
				    //$insta= (array) json_decode($jsoncontent1, true);
				    $insta= $jsoncontent1;
				    //$pizza=$insta["require"][0][3][0]["__bbox"]["require"][0][3][1]["__bbox"]["result"]["data"]["xig_user_by_username"]["polaris_ordered_timeline_connection"]["edges"];

				    $array = [
                                        'test1' => [
                                            'foo' => [
                                                'hello' => 123
                                            ]
                                        ],
                                        'test2' => 'bar'
                                    ];
                                    //echo array_get_nested_value($array, ['test1', 'foo', 'hello']); // will return 123
                                    //$pizza1=array_get_nested_value($insta, ["require", 0, 3, 0, "__bbox", "require", 0, 3, 1, "__bbox", "result", "data", "xig_user_by_username", "polaris_ordered_timeline_connection", "edges"]); 
				    echo "<h1>LAST POSTS from " . $username . "</h1>";
				    //echo json_encode($pizza1, true);


		    $pizza=explode("\"text\":\"", $insta);
		    $paspremier=false;
		    function unenc_utf16_code_units($string) {
    /* go for possible surrogate pairs first */
    $string = preg_replace_callback(
        '/\\\\U(D[89ab][0-9a-f]{2})\\\\U(D[c-f][0-9a-f]{2})/i',
        function ($matches) {
            $hi_surr = hexdec($matches[1]);
            $lo_surr = hexdec($matches[2]);
            $scalar = (0x10000 + (($hi_surr & 0x3FF) << 10) |
                ($lo_surr & 0x3FF));
            return "&#x" . dechex($scalar) . ";";
        }, $string);
    /* now the rest */
    $string = preg_replace_callback('/\\\\U([0-9a-f]{4})/i',
        function ($matches) {
            //just to remove leading zeros
            return "&#x" . dechex(hexdec($matches[1])) . ";";
        }, $string);
    return $string;
}
		    foreach ($pizza as $part) {
			    if ($paspremier) {
		    $mapart=explode("\"}", $part)[0];
		    $mypic=explode("uri\":\"", $part)[1];
		    $pic=explode("\"", $mypic)[0];
                        //echo "<p class\"ig-post\">". htmlentities(utf8_decode($mapart)) . "</p>";

                          $html_utf8 = unenc_utf16_code_units($mapart);
 
                        //echo "<p class\"ig-post\">" . utf8_decode($mapart) . "</p>";
                        //echo "<p class\"ig-post\">" . $html_utf8 . "</p>";
                        echo "<p class\"ig-post\">" . str_replace("\\n", "<br>", $html_utf8) . "</p>";
			    }
			    $paspremier=true;
                    }
                    }
                    }

		   
                    //#$insta = json_decode($instaResult);
                    //#$instagram_photos = $insta->graphql->user->edge_owner_to_timeline_media->edges;
		    //#foreach ($instagram_photos as $value) {
                    //    echo "<img src=\"" . $value->node->display_url . "\>";
                    //#}
                echo '</div>';

		} else {
			echo "<p>no account</p>";
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
                $instance['account'] = ( ! empty( $new_instance['account'] ) ) ? strip_tags( $new_instance['account'] ) : '';
                return $instance;

	}

	/**
	 * Output the admin widget options form HTML.
	 *
	 * @param array $instance The current widget settings.
	 * @return string The HTML markup for the form.
	 */
	function form( $instance ) {
                $text  = ! empty( $instance['account'] ) ? $instance['account'] : esc_html__( '', 'text_domain' );
		$mytext=$this->get_field_id('account' );

		return "<form action=\"\">
			<p>
                        <label for=\"" . esc_attr($mytext ) . "\">" . esc_html__( 'Instagram account:', 'text_domain' ) . "</label><input class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"" . esc_attr( 'account' ) . "\" type=\"text\" value=\"" .  esc_attr( $text ) . "\" >
                </p>
                <p class=\"actions\">
<input type=\"submit\" value=\"envoyer\"/>
                        
                </p></form>";
	}
}
class WPDocs_Map_Widget extends WP_Widget {

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
                if ( ! empty( $instance['address'] ) ) {
                        echo $args['before_title'] . "Carte centrée sur <span id=\"sentaddress\"> " . apply_filters( 'widget_title', $instance['address'] ) . "</span>" . $args['after_title'];

		} else {
                        echo $args['before_title'] . "chercher une adresse à voir sur la carte " . $args['after_title'];
                }
                echo '<div class="formwidget">';

		echo $this->form($instance);
                echo '</div>';
                if ( ! empty( $instance['address'] ) ) {
                    echo '<div class="mapwidget">';
		    try {
                    $address = $instance['address'];
		    $header = array();
                    $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
                    $header[] = 'Cache-Control: max-age=0';
                    $header[] = 'Connection: keep-alive';
                    $header[] = 'Keep-Alive: 300';
                    $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
                    $header[] = 'Accept-Language: fr-FR,en;q=0.5';
                    $header[] = 'Pragma: ';
                    $ch = curl_init();
		    $url = sprintf('http://nominatim.openstreetmap.org/search?q=%s&format=%s&polygon=%s&addressdetails=%s', $address, 'json', '1', '1');
                    curl_setopt($ch, CURLOPT_URL, $url );
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_ENCODING, '');
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    $instaResult = curl_exec($ch);
		    //echo "request" . $instaResult;
		    if ($instaResult == "Bad Request"){
			            throw new Exception('Third');
		    }

		   $someinfo= json_decode($instaResult, true)[0];
		   echo "<div>LAT and LON : " ;
		echo "<div hidden id=\"chosenaddress\">" . $someinfo["name"] .  "</div>";
		echo "<div hidden id=\"yourlat\">" . $someinfo["lat"] . "</div>";
		echo "<div hidden id=\"yourlon\">" . $someinfo["lon"] . "</div>";
		echo $someinfo["lat"];

		   echo ",";
		echo $someinfo["lon"];
		echo " <div id=\"somemap\"></div>";
		echo "<p> plus d'informations sur ce lieu : " . $someinfo["display_name"] . "</p>";
		echo "<p> type d'adresse : " . $someinfo["addresstype"] . "</p>";
                echo '</div>';
                echo '</div>';
		    } catch (Exception $e) {
			    $someinfo =array("lat" => "48.852966", "lon"=> "2.349902", "addresstype"=> "cathédrale ", "display_name"=> "cathédrale Notre-Dame de Paris");
		   echo "<div>Désolée, une erreur s'est produite, voilà à la place l'emplacement de Paris : LAT and LON : " ;
		echo "<div hidden id=\"chosenaddress\">Paris</div>";
		echo "<div hidden id=\"yourlat\">" . $someinfo["lat"] . "</div>";
		echo "<div hidden id=\"yourlon\">" . $someinfo["lon"] . "</div>";
		echo $someinfo["lat"];

		   echo ",";
		echo $someinfo["lon"];
		echo " <div id=\"somemap\"></div>";
		echo "<p> plus d'informations sur ce lieu : " . $someinfo["display_name"] . "</p>";
		echo "<p> type d'adresse : " . $someinfo["addresstype"] . "</p>";
                echo '</div>';
                echo '</div>';
		    }
                    curl_close ($ch);


		    //foreach ($mypizza as $item) {
		    //        //echo "item";
		    //        if (str_contains($item, "Photo by")){
		    //    	    //echo "photo";
		    //    	    $jsoncontent=explode(">", $item)[1];
		    //    	    //echo $jsoncontent;
		    //    	    $jsoncontent1=explode("</script>", $jsoncontent)[0];
		    //    	    //echo "<code>" . $jsoncontent1 . "</code>";
		    //    	    //$insta= (array) json_decode($jsoncontent1, true);
		    //    	    $insta= $jsoncontent1;
		    //    	    //$pizza=$insta["require"][0][3][0]["__bbox"]["require"][0][3][1]["__bbox"]["result"]["data"]["xig_user_by_username"]["polaris_ordered_timeline_connection"]["edges"];

		    //    	    $array = [
                    //                    'test1' => [
                    //                        'foo' => [
                    //                            'hello' => 123
                    //                        ]
                    //                    ],
                    //                    'test2' => 'bar'
                    //                ];
                    //                //echo array_get_nested_value($array, ['test1', 'foo', 'hello']); // will return 123
                    //                //$pizza1=array_get_nested_value($insta, ["require", 0, 3, 0, "__bbox", "require", 0, 3, 1, "__bbox", "result", "data", "xig_user_by_username", "polaris_ordered_timeline_connection", "edges"]); 
		    //    	    echo "<h1>LAST POSTS from " . $username . "</h1>";
		    //    	    //echo json_encode($pizza1, true);


		    //$pizza=explode("\"text\":\"", $insta);
		    //$paspremier=false;
		    //foreach ($pizza as $part) {
		    //        if ($paspremier) {
		    //$mapart=explode("\"}", $part)[0];
		    //$mypic=explode("uri\":\"", $part)[1];
		    //$pic=explode("\"", $mypic)[0];
                    //    //echo "<p class\"ig-post\">". htmlentities(utf8_decode($mapart)) . "</p>";

                    //      $html_utf8 = unenc_utf16_code_units($mapart);
 
                    //    //echo "<p class\"ig-post\">" . utf8_decode($mapart) . "</p>";
                    //    //echo "<p class\"ig-post\">" . $html_utf8 . "</p>";
                    //    echo "<p class\"ig-post\">" . str_replace("\\n", "<br>", $html_utf8) . "</p>";
		    //        }
		    //        $paspremier=true;
                    //}
                    //}
                    //}
		    
		//echo $instaResult;
                    //#$insta = json_decode($instaResult);
                    //#$instagram_photos = $insta->graphql->user->edge_owner_to_timeline_media->edges;
		    //#foreach ($instagram_photos as $value) {
                    //    echo "<img src=\"" . $value->node->display_url . "\>";
                    //#}
                echo '</div>';

		} else {
			echo "<p>no account</p>";
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
                $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
                return $instance;

	}

	/**
	 * Output the admin widget options form HTML.
	 *
	 * @param array $instance The current widget settings.
	 * @return string The HTML markup for the form.
	 */
	function form( $instance ) {
                $text  = ! empty( $instance['address'] ) ? $instance['address'] : esc_html__( '', 'text_domain' );
		$mytext=$this->get_field_id('address' );

		return "<form action=\"\">
			<p>
                        <label for=\"" . esc_attr($mytext ) . "\">" . esc_html__( 'Address to see on the map:', 'text_domain' ) . "</label><input class=\"widefat\" id=\"" .  esc_attr( $mytext ) . "\" name=\"" . esc_attr( 'address' ) . "\" type=\"text\" value=\"" .  esc_attr( $text ) . "\" >
                </p>
                <p class=\"actions\">
<input type=\"submit\" value=\"envoyer\"/>
                        
                </p></form>";
	}
}
add_action( 'widgets_init', 'wpdocs_register_widgets' );

