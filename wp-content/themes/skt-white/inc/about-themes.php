<?php
//about theme info
add_action( 'admin_menu', 'skt_white_abouttheme' );
function skt_white_abouttheme() {    	
	add_theme_page( esc_html__('About Theme', 'skt-white'), esc_html__('About Theme', 'skt-white'), 'edit_theme_options', 'skt_white_guide', 'skt_white_mostrar_guide');   
} 
//guidline for about theme
function skt_white_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>
<div class="wrapper-info">
	<div class="col-left">
   		   <div class="col-left-area">
			  <?php esc_html_e('Theme Information', 'skt-white'); ?>
		   </div>
          <p><?php esc_html_e('SKT White is a free responsive WordPress theme which is flexible, simple, adaptable, artistic, clean, creative, fullscreen, modern, portfolio, elegant, stylish, multipurpose, easy, minimalistic, simplistic, sleek, plain, minimal and clear for any type of website you want to create. So corporate, business, photography, wedding, industrial, restaurant or any sort of industry. SKT White has the ability to change the link colors. So make it suit your style you want. Built with page builder. WooCommerce and SEO compatible. Translation ready.','skt-white'); ?></p>
          <a href="<?php echo esc_url(SKT_WHITE_SKTTHEMES_PRO_THEME_URL); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/free-vs-pro.png" alt="" /></a>
	</div><!-- .col-left -->
	<div class="col-right">			
			<div class="centerbold">
				<hr />
				<a href="<?php echo esc_url(SKT_WHITE_SKTTHEMES_LIVE_DEMO); ?>" target="_blank"><?php esc_html_e('Live Demo', 'skt-white'); ?></a> | 
				<a href="<?php echo esc_url(SKT_WHITE_SKTTHEMES_PRO_THEME_URL); ?>"><?php esc_html_e('Buy Pro', 'skt-white'); ?></a> | 
				<a href="<?php echo esc_url(SKT_WHITE_SKTTHEMES_THEME_DOC); ?>" target="_blank"><?php esc_html_e('Documentation', 'skt-white'); ?></a>
                <div class="space5"></div>
				<hr />                
                <a href="<?php echo esc_url(SKT_WHITE_SKTTHEMES_THEMES); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sktskill.jpg" alt="" /></a>
			</div>		
	</div><!-- .col-right -->
</div><!-- .wrapper-info -->
<?php } ?>