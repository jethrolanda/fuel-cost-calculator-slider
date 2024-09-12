<?php
global $fscs;
$fscs->scripts->plugin_scripts();
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
// Local State/Context
$context = array('isOpen' => false);
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo $fscs->slider_shortcode->calculator_slider_shortcode(); ?>
</div>