<div class="fuel-savings-pdf-report-wrapper">
  <h5>Email Me This Report</h5>
  <p>Want a detailed breakdown of your potential savings? Click the button below, Enter your email, and we'll send you a comprehensive report instantly.</p>
  <a href="#" class="pdf-report-btn">📄EMAIL ME THE REPORT</a>
  <p>we never share data. we respect your privacy</p>
  <form id="pdf-report" class="modal">
    <p>
      <label>Name:</label>
      <input type="text" id="name">
    </p>
    <p>
      <label>Email:</label>
      <input type="email" id="email">
    </p>
    <span>
      <div class="g-recaptcha" data-sitekey="6Le7JcQoAAAAAP_lzaT0xXp2_IpmSTXZOlSyB8po"></div>
      <img src="<?php echo FSCS_IMAGES_ROOT_URL; ?>spinner.gif"><button id="send-pdf-report" class="btn-primary">Submit</button>
    </span>
  </form>
</div>