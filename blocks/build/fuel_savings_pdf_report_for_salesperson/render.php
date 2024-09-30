<?php
global $fscs;
$fscs->scripts->plugin_scripts();
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo $fscs->pdf_report_shortcode->fuel_savings_sales_pdf_report_shortcode($attributes); ?>
</div>