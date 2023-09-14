<div class="ct-section-inner-wrap">
  <div id="fuel-savings-calculator">
    <div class="row">
      <div class="label">Estimated gallons per a fill<span class="dashicons dashicons-editor-help label1"></span></div>
      <div class="range-slider">
        <input id="estimated-gallons-per-fill" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="estimated-gallons-per-fill-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Number of units in fleet<span class="dashicons dashicons-editor-help label2"></span></div>
      <div class="range-slider">
        <input id="number-of-units" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-units-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>

    <div class="row">
      <div class="label">Number of operators<span class="dashicons dashicons-editor-help label3"></span></div>
      <div class="range-slider">
        <input id="number-of-operators" type="range" min="0" max="10" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-operators-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Average hourly rate per operator<span class="dashicons dashicons-editor-help label4"></span></div>
      <div class="range-slider">
        <input id="hourly-rate" type="range" min="0" max="70" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="hourly-rate-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
    <div class="row">
      <div class="label">Round-trip per fueling<span class="dashicons dashicons-editor-help label5"></span></div>
      <div class="range-slider">
        <input id="round-trip-per-fueling" type="range" min="0" max="120" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="round-trip-per-fueling-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>

    <div class="row">
      <div class="label">Frequency of fueling<span class="dashicons dashicons-editor-help label6"></span></div>
      <div class="range-slider">
        <input id="frequency-of-fueling" type="range" min="0" max="20" step="1" value="0" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="frequency-of-fueling-input" type="text" size="4" min="20" max="1500" value="0">
      </div>
    </div>
    
  </div>


  <br/><br/><br/>
  <h4>Estimated Fuel Savings</h4>
  <br/>
  <div class="estimated-savings">
    <div>Estimated Gallons Consumed per Month<span id="estimated-gallons-consumed-per-month">0</span></div>
    <div>Man Hours Allocated to Fueling per Week<span id="man-hours-allocated-to-fueling-per-week">0</span></div>
    <div>Lost Asset Production per Week<span id="lost-asset-production-per-week">0</span></div>
    <div>Estimated Cost of Self Fueling<span id="estimated-cost-of-self-fueling">$0</span></div>
    <div>Estimated Savings Annually<span id="estimated-savings-annually">$0</span></div>
  </div>
</div>