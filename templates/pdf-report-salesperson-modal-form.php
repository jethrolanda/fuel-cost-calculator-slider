<?php
global $fscs;
$sales_persons = array(); // $fscs->hubspot_users->get_all_users();
?>
<form id="pdf-report-salesperson" class="modal">
  <input id="redirect_url" type="hidden" value="<?php echo get_option('fscs_modal_redirect_url'); ?>">
  <p>
    <input type="text" id="customer-name" placeholder="Customer Name">
  </p>
  <p>
    <input type="email" id="customer-email" placeholder="Customer Email">
  </p>
  <p>
    <!-- <input type="text" id="salesperson-name" placeholder="Salesperson Name"> -->
    <?php
    if (!empty($sales_persons)) {
      echo '<select name="salesperson-name" id="salesperson-name">';
      foreach ($sales_persons as $person) {
        echo '<option value="' . $person->email . '">' . $person->firstName . ' ' . $person->lastName . '</option>';
      }
      echo '</select>';
    } else {
      echo 'no sales persons';
    }
    ?>

  </p>
  <p>
    <input type="email" id="salesperson-email" placeholder="Salesperson Email" disabled>
  </p>
  <span class="actions">
    <div class="g-recaptcha recaptcha-2" data-sitekey="<?php echo get_option('fscs_site_key'); ?>"></div>
    <div><button id="send-pdf-report-salesperson" class="btn-m btn-primary"><span class="button__text">Submit</span></button></div>
  </span>
  <?php wp_nonce_field('submit_pdf_report'); ?>
</form>