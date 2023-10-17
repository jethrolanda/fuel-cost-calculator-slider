jQuery(document).ready(function ($) {

  var fuel_savings_calculator_wrapper = $('body').find('.fuel-savings-calculator-wapper');
  var weeks = 52;
  var months = 12;
  var rate_per_minute = 0;
  var minutes_in_an_hour = 60;

  var calculateSavedFuel = function() {

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

    // Man Hours Allocated to Fueling per Week
    var man_hours_allocated_to_fueling_per_week = e * c * b * f / minutes_in_an_hour;
    man_hours_allocated_to_fueling_per_week = Math.round(man_hours_allocated_to_fueling_per_week);

    // Lost Assets and Labor Hours
    var lost_assets_and_labor_hours = estimated_gallons_consumed_per_month + man_hours_allocated_to_fueling_per_week;
    if(lost_assets_and_labor_hours > 0) {
      lost_assets_and_labor_hours = Math.round(lost_assets_and_labor_hours);
      $("#lost-assets-and-labor-hours").text(lost_assets_and_labor_hours.toLocaleString());
    }

    // Estimated Cost of Self Fueling / Labor Savings Per Week
    var labor_savings_per_week = rate_per_minute * e * c * b * f;
    labor_savings_per_week = Math.round(labor_savings_per_week);
    $("#labor-savings-per-week").text("$"+labor_savings_per_week.toLocaleString());

    // Every Gallon You Pump Costs You An Additional
    var additional_costs = rate_per_minute * e * c * b * f;
    if(additional_costs > 0 && estimated_gallons_consumed_per_month > 0) {
      additional_costs = additional_costs / estimated_gallons_consumed_per_month;
      $("#every-gallon-you-pump-costs-an-additional").text("$"+additional_costs.toLocaleString('en-US', {maximumFractionDigits:2}));
    }
    
    // Estimated Savings Annually
    var estimated_savings_annually = rate_per_minute * e * c * b * f * weeks;
    estimated_savings_annually = Math.round(estimated_savings_annually);
    $("#estimated-savings-annually").text("$"+estimated_savings_annually.toLocaleString('en-US', {maximumFractionDigits:2}));

  }

  fuel_savings_calculator_wrapper.find('input[type="range"]').rangeslider({

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
    onInit: function() { calculateSavedFuel(); },

    // Callback function
    onSlide: function(position, value) {

      // Change input values
      var id = this.$element.attr('id');
      if(id){
        $('#'+id+'-input').val(value);
      }

      calculateSavedFuel();

    },

    // Callback function
    onSlideEnd: function(position, value) {}

  });

  fuel_savings_calculator_wrapper.find('input[type="text"]').on('keyup', function(){
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
  
});