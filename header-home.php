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
  /*background-image: url("/wp-content/themes/my-second-theme/assets/img/terremusique.png");*/
  background-position: left top;
  background-size: auto;
  background-repeat: repeat;
  background-attachment: scroll;
}


#sidebar, h1, h2, h3, body p, .categories, .wp-block-paragraph, .mypost, #site-header, .menu {
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
.containerimagepagedaccueil {
position: relative;
}
.imagepagedaccueil {
position: absolute;
left:0;top:0;width:100%;
}
.texteimagepagedaccueil {
position: absolute;
z-index: 30;
background:transparent;
width:100%;
top: <?php echo get_theme_mod('header_image_top', '80'); ?>px;


}
.texteimagepagedaccueil h2 {
font-size: <?php echo get_theme_mod('header_image_title_size', '40'); ?>px;
color: <?php echo get_theme_mod('header_image_title_color', '#fff'); ?>;

}
.texteimagepagedaccueil p {
font-size: <?php echo get_theme_mod('header_image_description_size', '20'); ?>px;
color: <?php echo get_theme_mod('header_image_title_color', '#fff'); ?>;

}
.texteimagepagedaccueil * {
position:relative; 
z-index: 30;
height:100%;
left:30px;top:50%;width:100%;
color: white;
text-align:center;
background:transparent;
}

</style>
        ...
</head>
<body <?php body_class(); ?>>
<style>
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
<h1>
Bienvenue sur 
Voyage et musique
</h1>
<h6 class="mypost">
<?php if (!empty(get_theme_mod("date_prochain_evenement")) ){ ?>
Date de mon prochain évènement : <?php echo get_theme_mod("date_prochain_evenement")?></h6>
<?php }else {
echo "pas de prochain evenement prévu";
}
?>
</h6>
<div class="wp-block-cover alignfull containerimagepagedaccueil">
        <span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim"></span>
	<img class="imagepagedaccueil wp-block-cover__image-background wp-image-3838" alt="" src="<?php 

if (wp_get_attachment_image_src(get_theme_mod("image_control"))) {
echo str_replace("-150x150",null,wp_get_attachment_image_src(get_theme_mod("image_control"))[0]);
}else {
        echo esc_url( get_theme_file_uri( 'assets/img/hero-background.png' ) ); 
}
	
; ?>" data-object-fit="cover"/>
        <div class="texteimagepagedaccueil wp-block-cover__inner-container">

                <!-- wp:heading {"textAlign":"center"} -->
		<h2 class="wp-block-heading has-text-align-center"><?php 
if (!empty (get_theme_mod("header_image_title")) ){	
	esc_html_e( get_theme_mod("header_image_title"), 'themeslug' );
}else {
	echo 'Welcome to my site!';
}?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><?php 
if (!empty (get_theme_mod("header_image_description")) ){	
	esc_html_e( get_theme_mod("header_image_description"), 'themeslug' );
}else {
	echo 'This is my little home away from home.';
}?></h2>

</p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                <!-- /wp:buttons -->

        </div>
</div>

