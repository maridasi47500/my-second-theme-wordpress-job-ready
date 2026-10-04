<!DOCTYPE html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" type="text/css" />
<?php wp_head(); ?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">

<head>
        ...
<style type="text/css" id="custom-background-css">

body.custom-background {
  /*background-image: url("/wp-content/themes/my-second-theme/assets/img/terremusique.png");*/
  background-position: left top;
  background-size: auto;
  background-repeat: repeat;
  background-attachment: scroll;
}


#sidebar, h1, h2, h3, body p, .categories, .wp-block-paragraph, .mypost, #site-header, .showpost, .menu {
        background:<?php echo get_theme_mod( 'background_color_block_text', '#fff' ); ?>;
        color:<?php echo get_theme_mod( 'color_block_text', '#000' ); ?>;


}
h1 {
     color:<?php echo get_theme_mod( 'couleur_du_titre', '#fff' ); ?>;
        font-size:<?php echo get_theme_mod( 'taille_du_titre', '21' ); ?>px;
}
a, a:hover, a:visited, a:link {
     color:<?php echo get_theme_mod( 'couleur_des_liens', '#fff' ); ?>;
        font-size:25px;
}


.someerror {
background: #8B0000;
color:white;
font-size: 34;
font-weight:900;

}

</style>
        ...
</head>
<body <?php body_class(); ?>>
<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		</a>
	</div>
<?php endif; ?>
<?php
if ( function_exists( 'the_custom_logo' ) ) {
	the_custom_logo();
}
?>
<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
