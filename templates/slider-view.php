<div class="ct-section-inner-wrap fuel-savings-calculator">
  <div id="fuel-savings-calculator">
    <div class="row">
      <div class="label">Estimated gallons per a fill</div>
      <div class="range-slider">
        <input id="estimated-gallons-per-fill" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="estimated-gallons-per-fill-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Number of units in fleet</div>
      <div class="range-slider">
        <input id="number-of-units" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-units-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>

    <div class="row">
      <div class="label">Number of operators</div>
      <div class="range-slider">
        <input id="number-of-operators" type="range" min="0" max="10" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-operators-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Average hourly rate per operator</div>
      <div class="range-slider">
        <input id="hourly-rate" type="range" min="0" max="70" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="hourly-rate-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Round-trip per fueling</div>
      <div class="range-slider">
        <input id="round-trip-per-fueling" type="range" min="0" max="120" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="round-trip-per-fueling-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>

    <div class="row">
      <div class="label">Frequency of fueling</div>
      <div class="range-slider">
        <input id="frequency-of-fueling" type="range" min="0" max="20" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="frequency-of-fueling-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
  </div>


  <br/><br/><br/>
  <h5>Estimated Fuel Savings</h5>
  <br/>
  <div class="estimated-savings">
    <div><span id="estimated-gallons-consumed-per-month">0</span>Estimated Gallons Consumed per Month</div>
    <div><span id="man-hours-allocated-to-fueling-per-week">0</span>Man Hours Allocated to Fueling per Week</div>
    <div><span id="lost-asset-production-per-week">0</span>Lost Asset Production per Week</div>
    <div><span id="estimated-cost-of-self-fueling">$0</span>Estimated Cost of Self Fueling</div>
  </div>

  <div class="estimated-savings-annually">
    <div><span id="estimated-savings-annually-result">$0 / year</span>Estimated Savings Annually</div>
  </div>
</div>