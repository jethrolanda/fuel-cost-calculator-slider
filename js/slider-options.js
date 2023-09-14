jQuery(document).ready(function($){
  var weeks = 52;
  var months = 12;
  var rate_per_minute = 0;
  var minutes_in_an_hour = 60;

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ", ");
  }

  $('input[type="range"]').rangeslider({

    // Feature detection the default is `true`.
    // Set this to `false` if you want to use
    // the polyfill also in Browsers which support
    // the native <input type="range"> element.
    polyfill: false,

    // Default CSS classes
    // rangeClass: 'rangeslider',
    // disabledClass: 'rangeslider--disabled',
    // horizontalClass: 'rangeslider--horizontal',
    // verticalClass: 'rangeslider--vertical',
    // fillClass: 'rangeslider__fill',
    // handleClass: 'rangeslider__handle',

    // Callback function
    onInit: function() {},

    // Callback function
    onSlide: function(position, value) {

      // Change input values
      var id = this.$element.attr('id');
      if(id){
        $('#'+id+'-input').val(value);
      }

      // Update Estimated Savings
      var a = parseInt($("#estimated-gallons-per-fill-input").val());
      var b = parseInt($("#number-of-units-input").val());
      var c = parseInt($("#number-of-operators-input").val());
      var d = parseInt($("#hourly-rate-input").val());
      var e = parseInt($("#round-trip-per-fueling-input").val());
      var f = parseInt($("#frequency-of-fueling-input").val());

      rate_per_minute = d / 60;
      // Estimated Gallons Consumed per Month
      var estimated_gallons_consumed_per_month = a * b * f * weeks / months;
      estimated_gallons_consumed_per_month = Math.round(estimated_gallons_consumed_per_month);
      estimated_gallons_consumed_per_month = numberWithCommas(estimated_gallons_consumed_per_month);
      $("#estimated-gallons-consumed-per-month").text(estimated_gallons_consumed_per_month);

      // Man Hours Allocated to Fueling per Week
      var man_hours_allocated_to_fueling_per_week = e * c * b * f / minutes_in_an_hour;
      man_hours_allocated_to_fueling_per_week = Math.round(man_hours_allocated_to_fueling_per_week);
      man_hours_allocated_to_fueling_per_week = numberWithCommas(man_hours_allocated_to_fueling_per_week);
      $("#man-hours-allocated-to-fueling-per-week").text(man_hours_allocated_to_fueling_per_week);

      // Lost Asset Production per Week
      var lost_asset_product_per_week = e * b * f / minutes_in_an_hour;
      lost_asset_product_per_week = Math.round(lost_asset_product_per_week);
      lost_asset_product_per_week = numberWithCommas(lost_asset_product_per_week)
      $("#lost-asset-production-per-week").text(lost_asset_product_per_week);

      // Estimated Cost of Self Fueling
      var estimated_cost_of_self_fueling = rate_per_minute * e * c * b * f;
      estimated_cost_of_self_fueling = Math.round(estimated_cost_of_self_fueling);
      estimated_cost_of_self_fueling = numberWithCommas(estimated_cost_of_self_fueling);
      $("#estimated-cost-of-self-fueling").text("$"+estimated_cost_of_self_fueling);

      // Estimated Savings Annually
      var estimated_savings_annually = rate_per_minute * e * c * b * f * weeks;
      estimated_savings_annually = Math.round(estimated_savings_annually);
      estimated_savings_annually = numberWithCommas(estimated_savings_annually);
      $("#estimated-savings-annually").text("$"+estimated_savings_annually);

    },

    // Callback function
    onSlideEnd: function(position, value) {}

  });

  $('input[type="text"]').on('keyup', function(){
    var id = $(this).attr("id");
    var value = parseInt(this.value);

    if(value === undefined) return;

    switch(id) {
      case "estimated-gallons-per-fill-input":
        $('#estimated-gallons-per-fill').val(value).change();
        break;

      case "number-of-units-input":
        $('#number-of-units').val(value).change();
        break;

      case "number-of-operators-input":
        $('#number-of-operators').val(value).change();
        break;

      case "hourly-rate-input":
        $('#hourly-rate').val(value).change();
        break;

      case "round-trip-per-fueling-input":
        $('#round-trip-per-fueling').val(value).change();
        break;
        
      case "frequency-of-fueling-input":
        $('#frequency-of-fueling').val(value).change();
        break;
    }

  });

  // TOOLTIPS
  tippy('.label1', {
    content: 'On average, how many gallons are you pumping into each vehicle?',
    animation: 'scale',
  });

  tippy('.label2', {
    content: 'How many vehicles do you have in your fleet?',
    animation: 'scale',
  });

  tippy('.label3', {
    content: 'How many employees are typically in the vehicle?',
    animation: 'scale',
  });

  tippy('.label4', {
    content: 'What’s the average hourly rate? Include burden, insurance, and vacation.',
    animation: 'scale',
  });

  tippy('.label5', {
    content: 'How many minutes does it take to drive to the fuel station, fill up, and drive back?',
    animation: 'scale',
  });

  tippy('.label6', {
    content: 'On average, how many days per week are you fueling your fleet?',
    animation: 'scale',
  });
  
});