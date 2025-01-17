<div class="fuel-savings-calculator-wrapper">
  <div id="fuel-savings-calculator">

    <div class="row">
      <div class="label">Number Of Units In Fleet
        <small>TOTAL VEHICLES</small>
        <div class="help-tip">
          <p>How many vehicles do you have in your fleet? Include gas and diesel.</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="number-of-units" type="range" min="0" max="80" step="1" value="17" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-units-input" type="text" size="4" min="20" max="1500" value="17">
      </div>
    </div>

    <div class="row">
      <div class="label">Frequency Of Fueling
        <small>DAYS</small>
        <div class="help-tip">
          <p>On average, how many days per week are you fueling your fleet?</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="frequency-of-fueling" type="range" min="0" max="14" step="1" value="6" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="frequency-of-fueling-input" type="text" size="4" min="20" max="1500" value="6">
      </div>
    </div>

    <div class="row">
      <div class="label">Estimated Gallons Per Fill
        <small>OF EACH VEHICLE</small>
        <div class="help-tip">
          <p>On average, how many gallons are you pumping into each vehicle?</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="estimated-gallons-per-fill" type="range" min="0" max="100" step="1" value="29" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="estimated-gallons-per-fill-input" type="text" size="4" min="20" max="1500" value="29">
      </div>
    </div>

    <div class="row">
      <div class="label">Round-Trip Per Fueling
        <small>MINUTES</small>
        <div class="help-tip">
          <p>How many minutes does it take to drive to the fuel station, fill up, and drive back?</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="round-trip-per-fueling" type="range" min="0" max="60" step="1" value="39" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="round-trip-per-fueling-input" type="text" size="4" min="20" max="1500" value="39">
      </div>
    </div>

    <div class="row">
      <div class="label">Number Of Operators
        <small>TOTAL EMPLOYEES</small>
        <div class="help-tip">
          <p>How many employees are typically in the vehicle?</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="number-of-operators" type="range" min="0" max="10" step="1" value="2" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="number-of-operators-input" type="text" size="4" min="20" max="1500" value="2">
      </div>
    </div>

    <div class="row">
      <div class="label">Average Hourly Rate
        <small>PER EMPLOYEE</small>
        <div class="help-tip">
          <p>What’s the average hourly rate? Include burden, insurance, and vacation.</p>
        </div>
      </div>
      <div class="range-slider">
        <input id="hourly-rate" type="range" min="0" max="50" step="1" value="24" data-orientation="horizontal">
      </div>
      <div class="range-value">
        <input id="hourly-rate-input" type="text" size="4" min="20" max="1500" value="24">
      </div>
    </div>

  </div>

  <span class="heading-text">ESTIMATED YEARLY SAVINGS WITH FUEL LOGIC:</span>
  <span id="estimated-savings-annually">$0</span>

  <span class="heading-text">ESTIMATED WEEKLY COST WITHOUT FUEL LOGIC:</span>
  <div class="estimated-savings">
    <div>
      <span class="computed-value" id="lost-assets-and-labor-hours">0</span>Hours Lost Per Week<br />
      <small>This is the time your fleet is not on the road. Lost Assets & Labor Hours Per Week</small>
    </div>
    <div>
      <span class="computed-value" id="labor-savings-per-week">$0</span>Labor Cost Per Week<br />
      <small>This is how much you pay your employee's to fill up your equipment</small>
    </div>
    <div>
      <span class="computed-value" id="every-gallon-you-pump-costs-an-additional">$0</span>Added Cost Per Gallon<br />
      <small>Every gallon you pump (<span id="gallons-per-week">XXXX</span> gallons per week) costs an additional <span id="per-gallon">$XX.XX</span> per gallon</small>
    </div>
  </div>

</div>