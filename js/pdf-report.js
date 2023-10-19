jQuery(document).ready(function ($) {
  $(".pdf-report-btn").on('click', function() {
    $('#pdf-report').modal({
      fadeDuration: 250,
      fadeDelay: 0.20
    });
  })

  $("#send-pdf-report").on('click', function(e) {
    e.preventDefault();
    jQuery.ajax({
        url         :   "/wp-admin/admin-ajax.php",
        type        :   "POST",
        data        :   { action : "fscs_generate_pdf" },
        dataType    :   "json"
    })
    .done(function (data, textStatus, jqXHR) {
      console.log(data)
    })
    .fail(function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR)
    });
  })
});