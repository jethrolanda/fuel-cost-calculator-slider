<div id="fuel-savings-calculator">
  <div class="row">
    <div class="label">Estimated Gallons per Fill</div>
    <div class="range-slider">
      <input id="estimated-gallons-per-fill" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="estimated-gallons-per-fill-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>
  
  <div class="row">
    <div class="label"># of Units</div>
    <div class="range-slider">
      <input id="number-of-units" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="number-of-units-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>

  <div class="row">
    <div class="label"># of Operators</div>
    <div class="range-slider">
      <input id="number-of-operators" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="number-of-operators-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>
  
  <div class="row">
    <div class="label">Hourly Rate (Burdened)</div>
    <div class="range-slider">
      <input id="hourly-rate" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="hourly-rate-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>
  
  <div class="row">
    <div class="label">Round-Trip per Fueling (Minutes)</div>
    <div class="range-slider">
      <input id="round-trip-per-fueling" type="range" min="0" max="100" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="round-trip-per-fueling-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>

  <div class="row">
    <div class="label">Frequency of Fueling (Days/Wk)</div>
    <div class="range-slider">
      <input id="frequency-of-fueling" type="range" min="0" max="52" step="1" value="0" data-orientation="horizontal">
    </div>
    <div class="range-value">
      <input id="frequency-of-fueling-input" type="text" size="4" min="20" max="1500" value="0">
    </div>
  </div>
  
</div>


<br/><br/><br/>
<h4>Estimated Savings</h4>
<br/>
<div class="estimated-savings">
  <div>Estimated Gallons Consumed per Month<span id="estimated-gallons-consumed-per-month">0</span></div>
  <div>Man Hours Allocated to Fueling per Week<span id="man-hours-allocated-to-fueling-per-week">0</span></div>
  <div>Lost Asset Production per Week<span id="lost-asset-production-per-week">0</span></div>
  <div>Estimated Cost of Self Fueling<span id="estimated-cost-of-self-fueling">$0</span></div>
  <div>Estimated Savings Annually<span id="estimated-savings-annually">$0</span></div>
</div>