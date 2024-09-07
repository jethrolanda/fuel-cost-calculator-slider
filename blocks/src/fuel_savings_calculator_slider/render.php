<?php
wp_enqueue_style('range-slider-style-custom');
wp_enqueue_style('range-slider-style');

wp_enqueue_script('range-slider-script');
wp_enqueue_script('range-slider-setup-script');
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
global $fscs;
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php //esc_html_e( 'Blocks – hello from a dynamic block!', 'blocks' ); 
	?>
	<?php echo $fscs->slider_shortcode->calculator_slider_shortcode(); ?>
</p>