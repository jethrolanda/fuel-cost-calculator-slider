<div class="fuel-savings-pdf-report-wrapper">
  <a href="#" class="pdf-report-btn">📄EMAIL ME THE REPORT</a>
  <form id="pdf-report" class="modal">
    <p>
      <label>Name:</label>
      <input type="text" id="name">
    </p>
    <p>
      <label>Email:</label>
      <input type="email" id="email">
    </p>
    <p class="actions">
      <div class="g-recaptcha" data-sitekey="<?php echo get_option('fscs_site_key'); ?>"></div>
      <img src="<?php echo FSCS_IMAGES_ROOT_URL; ?>spinner.gif"><button id="send-pdf-report" class="btn-m btn-primary">Submit</button>
    </p class="actions">
    <?php wp_nonce_field( 'submit_pdf_report' ); ?>
  </form>
</div>