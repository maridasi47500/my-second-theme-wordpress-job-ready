<!DOCTYPE html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" type="text/css" />
<?php wp_head(); ?>

        ...
<style type="text/css" id="custom-background-css">
body.custom-background {
  background-image: url("/wp-content/themes/my-second-theme/assets/img/terremusique.png");
  background-position: left top;
  background-size: auto;
  background-repeat: repeat;
  background-attachment: scroll;
}


#sidebar, h1, h2, h3, body p, .categories, .wp-block-paragraph, .mypost, #site-header, .menu {
        background:<?php echo get_theme_mod( 'background_color_block_text', '#fff' ); ?>; 
color:white;


}
h1 {
     color:<?php echo get_theme_mod( 'couleur_du_titre', '#fff' ); ?>;
        font-size:<?php echo get_theme_mod( 'taille_du_titre', '21' ); ?>px;
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
<style>
a:visited, a:hover, a:link {
color:white;
}
.someerror {
background: #8B0000;
color:white;
font-size: 34;
font-weight:900;

}

</style>
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
<h1>HEADER HOME</h1>
<div class="wp-block-cover alignfull">
        <span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim"></span>
        <img class="wp-block-cover__image-background wp-image-3838" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/hero-background.png' ) ); ?>" data-object-fit="cover"/>
        <div class="wp-block-cover__inner-container">

                <!-- wp:heading {"textAlign":"center"} -->
                <h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Welcome to My Site', 'themeslug' ); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center"} -->
                <p class="has-text-align-center"><?php esc_html_e( 'This is my little home away from home.', 'themslug' ); ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                <!-- /wp:buttons -->

        </div>
</div>

