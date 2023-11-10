<div class="fuel-savings-pdf-report-wrapper">
  <p><a href="#" class="pdf-report-btn">📄EMAIL ME THE REPORT</a></p>
  <form id="pdf-report" class="modal">
    <p>
      <label>Name:</label>
      <input type="text" id="name">
    </p>
    <p>
      <label>Email:</label>
      <input type="email" id="email">
    </p>
    <span class="actions">
      <div class="g-recaptcha" data-sitekey="<?php echo get_option('fscs_site_key'); ?>"></div>
      <div><button id="send-pdf-report" class="btn-m btn-primary"><span class="button__text">Submit</span></button></div>
    </span>
    <?php wp_nonce_field( 'submit_pdf_report' ); ?>
  </form>
</div>