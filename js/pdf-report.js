jQuery(document).ready(function ($) {
  var pdf_report = $("#pdf-report");
  var pdf_report_salesperson = $("#pdf-report-salesperson");

  const validateEmail = (email) => {
    return String(email)
      .toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  };

  // CUSTOMER
  $(".pdf-report-btn").on("click", function () {
    pdf_report.modal({
      fadeDuration: 250,
      fadeDelay: 0.2
    });
  });

  $("#send-pdf-report").on("click", function (e) {
    e.preventDefault();
    var calculator_data = $("div.fuel-savings-calculator-wrapper").attr(
      "data-calculator"
    );
    calculator_data = JSON.parse(decodeURIComponent(calculator_data));

    var customer_name = pdf_report.find("#customer-name").val();
    var customer_email = pdf_report.find("#customer-email").val();
    var g_recaptcha_response = $("#g-recaptcha-response").val();

    if (customer_name === "" || customer_email === "")
      toastr.error("Name and Email are required.");
    else if (!validateEmail(customer_email))
      toastr.error("The email is invalid.");
    else if (g_recaptcha_response === "")
      toastr.error("Recaptcha is required.");
    else {
      // Display loader
      $("#send-pdf-report").addClass("button--loading").attr("disabled", true);
      jQuery
        .ajax({
          url: "/wp-admin/admin-ajax.php",
          type: "POST",
          data: {
            action: "fscs_generate_pdf",
            customer_name,
            customer_email,
            calculator_data,
            g_recaptcha_response,
            _wpnonce: pdf_report.find("#_wpnonce").val()
          },
          dataType: "json"
        })
        .done(function (data, textStatus, jqXHR) {
          if (data.status === "success") toastr.success("Email sent");

          var redirect_url = pdf_report.find("#redirect_url").val();

          if (redirect_url) {
            window.location.replace(redirect_url);
          } else {
            // close modal, dont reload
            setTimeout(function () {
              // location.reload();
              pdf_report.modal("hide");
              $(".jquery-modal.blocker.current").click();

              // Reset to empty
              pdf_report.find("#customer-name").val("");
              pdf_report.find("#customer-email").val("");
              window.grecaptcha.reset();
            }, 500);
          }
          $("#send-pdf-report")
            .removeClass("button--loading")
            .removeAttr("disabled");
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          pdf_report.find("img").hide();
        });
    }
  });

  //-----------*----*----------------//

  // SALESPERSON
  $("#salesperson-email").val($("#salesperson-name").val());
  $("#salesperson-name").on("change", function () {
    $("#salesperson-email").val(this.value);
  });
  $(".pdf-report-salesperson-btn").on("click", function () {
    pdf_report_salesperson.modal({
      fadeDuration: 250,
      fadeDelay: 0.2
    });
  });

  $("#send-pdf-report-salesperson").on("click", function (e) {
    e.preventDefault();
    var errors = [];
    var errors_email = [];
    var calculator_data = $("div.fuel-savings-calculator-wrapper").attr(
      "data-calculator"
    );
    calculator_data = JSON.parse(decodeURIComponent(calculator_data));

    var customer_name = pdf_report_salesperson.find("#customer-name").val();
    var customer_email = pdf_report_salesperson.find("#customer-email").val();
    var salesperson_name = pdf_report_salesperson
      .find("#salesperson-name")
      .val();
    var salesperson_email = pdf_report_salesperson
      .find("#salesperson-email")
      .val();
    var g_recaptcha_response = $(".recaptcha-2")
      .find("textarea[name=g-recaptcha-response]")
      .val();

    if (customer_name === "") errors.push(["Customer Name"]);
    if (customer_email === "") errors.push(["Customer Email"]);
    if (salesperson_name === "") errors.push(["Salesperson Name"]);
    if (salesperson_email === "") errors.push(["Salesperson Email"]);

    if (errors.length > 0) toastr.error(errors.join(", ") + " are required.");

    if (!validateEmail(customer_email)) errors_email.push(["Customer Email"]);
    if (!validateEmail(salesperson_email))
      errors_email.push(["Salesperson Email"]);
    if (errors_email.length > 0)
      toastr.error("Invalid email format for " + errors_email.join(", "));
    if (g_recaptcha_response === "") toastr.error("Recaptcha is required.");

    if (
      errors.length === 0 &&
      errors_email.length === 0 &&
      g_recaptcha_response !== ""
    ) {
      // Display loader
      $("#send-pdf-report-salesperson")
        .addClass("button--loading")
        .attr("disabled", true);
      jQuery
        .ajax({
          url: "/wp-admin/admin-ajax.php",
          type: "POST",
          data: {
            action: "fscs_generate_pdf",
            customer_name,
            customer_email,
            salesperson_name,
            salesperson_email,
            calculator_data,
            g_recaptcha_response,
            _wpnonce: pdf_report_salesperson.find("#_wpnonce").val()
          },
          dataType: "json"
        })
        .done(function (data, textStatus, jqXHR) {
          if (data.status === "success")
            toastr.success(
              "<b>Custom report was sent to your customer!</b><br><p>And a copy was sent to your email too</p>"
            );

          var redirect_url = pdf_report_salesperson.find("#redirect_url").val();

          if (redirect_url) {
            window.location.replace(redirect_url);
          } else {
            // close modal, dont reload
            setTimeout(function () {
              // location.reload();
              pdf_report_salesperson.modal("hide");
              $(".jquery-modal.blocker.current").click();

              // Reset to empty
              pdf_report_salesperson.find("#customer-name").val("");
              pdf_report_salesperson.find("#customer-email").val("");
              pdf_report_salesperson.find("#salesperson-name").val("");
              pdf_report_salesperson.find("#salesperson-email").val("");
              window.grecaptcha.reset();
            }, 500);
          }

          $("#send-pdf-report-salesperson")
            .removeClass("button--loading")
            .removeAttr("disabled");
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          pdf_report_salesperson.find("img").hide();
        });
    }
  });
});
