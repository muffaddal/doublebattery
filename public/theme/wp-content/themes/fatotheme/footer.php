<?php $fatotheme_theme_option = fatotheme_get_theme_option(); ?>
    	<footer id="page-footer" class="page-footer clearfix">
         <?php
            do_action( 'fatotheme_footer_layout_style' );
         ?>
         <div class="footer-copyright">
	         <div class="container">
               <?php if($fatotheme_theme_option!=null) : ?>
               <div class="copyright">
                  <?php echo wp_kses_post($fatotheme_theme_option['footer-copyright']); ?>
               </div>
               <?php else: ?>
               <div class="copyright">
                  <p><?php esc_html_e('&copy; 2017 Fato. All Rights Reserved. Designed with love by Bily.','fatotheme') ?></p>
               </div>
               <?php endif; ?>
            </div>
		   </div>
    	</footer>
   </div><!--  End .page-wrapper -->
   <?php if($fatotheme_theme_option!=null && $fatotheme_theme_option['promo_popup'] =='1'): ?>
   <div class="popup_link hide"><a class="promo-popup-newsletter open-click" href="#promo-popup-newsletter"><?php esc_html_e('Newsletter', 'fatotheme'); ?></a></div>
   <?php endif;// End Promo Popup ?>
   <?php do_action('fatotheme_after_wrapper'); ?>
	<?php wp_footer(); ?>
</body>
</html>