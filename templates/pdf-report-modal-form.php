<form id="pdf-report" class="modal">
  <input id="redirect_url" type="hidden" value="<?php echo get_option('fscs_modal_redirect_url'); ?>">
  <p>
    <label>Name:</label>
    <input type="text" id="customer-name">
  </p>
  <p>
    <label>Email:</label>
    <input type="email" id="customer-email">
  </p>
  <span class="actions">
    <div class="g-recaptcha" data-sitekey="<?php echo get_option('fscs_site_key'); ?>"></div>
    <div><button id="send-pdf-report" class="btn-m btn-primary"><span class="button__text">Submit</span></button></div>
  </span>
  <?php wp_nonce_field( 'submit_pdf_report' ); ?>
</form>