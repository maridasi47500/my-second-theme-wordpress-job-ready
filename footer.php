<p>footer</p>
<?php get_sidebar(); ?>
<?php wp_list_categories(); ?>
<div class="widget-section">
	<?php the_widget( 'My_Widget_Class' ); ?>
</div><!-- .widget-section -->
<?php 
if ( is_user_logged_in() ):
    echo '<p>vous etes bien connecté(e)';
    echo '<a href="' . wp_logout_url() . '">se déconnecter</a>';

else:

    wp_login_form();
endif;
	 
?>
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

