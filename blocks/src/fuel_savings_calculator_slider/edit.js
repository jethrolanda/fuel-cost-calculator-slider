import { useEffect } from "@wordpress/element";

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	useEffect(() => {
		jQuery(document).ready(function ($) {
			var fuel_savings_calculator = $("body").find("#fuel-savings-calculator");

			var weeks = 52;
			var months = 12;
			var rate_per_minute = 0;
			var minutes_in_an_hour = 60;
			var total_gallons = 0;
			var estimated_savings_annually;

			var calculateSavedFuel = function () {
				// Update Estimated Savings
				var a = parseInt($("#estimated-gallons-per-fill-input").val());
				var b = parseInt($("#number-of-units-input").val());
				var c = parseInt($("#number-of-operators-input").val());
				var d = parseInt($("#hourly-rate-input").val());
				var e = parseInt($("#round-trip-per-fueling-input").val());
				var f = parseInt($("#frequency-of-fueling-input").val());

				total_gallons = a * b * f * weeks;
				rate_per_minute = d / 60;
				estimated_savings_annually = rate_per_minute * e * c * b * f * weeks;

				// Estimated Gallons Consumed per Month
				var estimated_gallons_consumed_per_month = (a * b * f * weeks) / months;
				estimated_gallons_consumed_per_month = Math.round(
					estimated_gallons_consumed_per_month,
				);

				// Man Hours Allocated to Fueling per Week
				var man_hours_allocated_to_fueling_per_week =
					(e * c * b * f) / minutes_in_an_hour;
				man_hours_allocated_to_fueling_per_week = Math.round(
					man_hours_allocated_to_fueling_per_week,
				);

				// Lost Assets and Labor Hours
				var lost_assets_and_labor_hours = (b * e * f) / minutes_in_an_hour;
				if (lost_assets_and_labor_hours > 0) {
					lost_assets_and_labor_hours =
						lost_assets_and_labor_hours.toLocaleString("en-US", {
							maximumFractionDigits: 2,
						});
					$("#lost-assets-and-labor-hours").text(lost_assets_and_labor_hours);
				}

				// Estimated Cost of Self Fueling / Labor Savings Per Week
				var labor_savings_per_week = rate_per_minute * e * c * b * f;
				labor_savings_per_week = Math.round(labor_savings_per_week);
				labor_savings_per_week = "$" + labor_savings_per_week.toLocaleString();
				$("#labor-savings-per-week").text(labor_savings_per_week);

				// Every Gallon You Pump Costs You An Additional
				var additional_costs = "$0";
				if (total_gallons > 0 && estimated_savings_annually > 0) {
					additional_costs = estimated_savings_annually / total_gallons;
					additional_costs =
						"$" +
						additional_costs.toLocaleString("en-US", {
							maximumFractionDigits: 2,
						});
					$("#every-gallon-you-pump-costs-an-additional").html(
						"<span style='color: #ce5353;'>+</span>" + additional_costs,
					);
				}

				$("span#gallons-per-week").text(b * f * a);
				$("span#per-gallon").text(additional_costs);

				// Estimated Savings Annually Display
				estimated_savings_annually = Math.round(estimated_savings_annually);
				estimated_savings_annually =
					"$" +
					estimated_savings_annually.toLocaleString("en-US", {
						maximumFractionDigits: 2,
					});
				$("#estimated-savings-annually").text(estimated_savings_annually);

				var data = {
					// Slider data
					number_of_operators: c,
					number_of_units_in_fleet: b,
					frequency_of_fueling: f,
					round_trip_per_fueling: e,
					estimated_gallons_per_fill: a,
					average_hourly_rate: d,
					// Calculations data
					every_gallon_you_pump_cost_an: additional_costs,
					estimated_gallons_consumed_per_week: (
						estimated_gallons_consumed_per_month / 7
					).toLocaleString("en-US", { maximumFractionDigits: 2 }),
					man_hours_allocated_to_fueling_per_week:
						man_hours_allocated_to_fueling_per_week,
					lost_asset_production_hours_per_week: lost_assets_and_labor_hours,
					estimated_cost_of_self_fueling_per_week: labor_savings_per_week,
					yearly_fuel_savings: estimated_savings_annually,
				};

				// Store data to div attr
				$("div.fuel-savings-calculator-wrapper").attr(
					"data-calculator",
					encodeURIComponent(JSON.stringify(data)),
				);
			};

			fuel_savings_calculator.find('input[type="range"]').rangeslider({
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
				onInit: function () {
					calculateSavedFuel();
				},

				// Callback function
				onSlide: function (position, value) {
					// Change input values
					var id = this.$element.attr("id");
					if (id) {
						$("#" + id + "-input").val(value);
					}

					calculateSavedFuel();
				},

				// Callback function
				onSlideEnd: function (position, value) {},
			});

			fuel_savings_calculator
				.find('input[type="text"]')
				.on("keyup", function () {
					var id = $(this).attr("id");
					var value = parseInt(this.value);

					if (value === undefined) return;

					switch (id) {
						case "estimated-gallons-per-fill-input":
							$("#estimated-gallons-per-fill").val(value).change();
							break;

						case "number-of-units-input":
							$("#number-of-units").val(value).change();
							break;

						case "number-of-operators-input":
							$("#number-of-operators").val(value).change();
							break;

						case "hourly-rate-input":
							$("#hourly-rate").val(value).change();
							break;

						case "round-trip-per-fueling-input":
							$("#round-trip-per-fueling").val(value).change();
							break;

						case "frequency-of-fueling-input":
							$("#frequency-of-fueling").val(value).change();
							break;
					}
				});
		});
	}, []);

	return (
		<div class="fuel-savings-calculator-wrapper" {...useBlockProps()}>
			<div id="fuel-savings-calculator">
				<div class="row">
					<div class="label">
						Number Of Units In Fleet
						<small>(Total Vehicles)</small>
						<div class="help-tip">
							<p>
								How many vehicles do you have in your fleet? Include gas and
								diesel.
							</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="number-of-units"
							type="range"
							min="0"
							max="80"
							step="1"
							value="17"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="number-of-units-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="17"
						/>
					</div>
				</div>

				<div class="row">
					<div class="label">
						Frequency Of Fueling
						<small>(Days)</small>
						<div class="help-tip">
							<p>
								On average, how many days per week are you fueling your fleet?
							</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="frequency-of-fueling"
							type="range"
							min="0"
							max="14"
							step="1"
							value="6"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="frequency-of-fueling-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="6"
						/>
					</div>
				</div>

				<div class="row">
					<div class="label">
						Estimated Gallons Per Fill
						<div class="help-tip">
							<p>
								On average, how many gallons are you pumping into each vehicle?
							</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="estimated-gallons-per-fill"
							type="range"
							min="0"
							max="100"
							step="1"
							value="29"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="estimated-gallons-per-fill-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="29"
						/>
					</div>
				</div>

				<div class="row">
					<div class="label">
						Round-Trip Per Fueling
						<small>(Minutes)</small>
						<div class="help-tip">
							<p>
								How many minutes does it take to drive to the fuel station, fill
								up, and drive back?
							</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="round-trip-per-fueling"
							type="range"
							min="0"
							max="60"
							step="1"
							value="39"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="round-trip-per-fueling-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="39"
						/>
					</div>
				</div>

				<div class="row">
					<div class="label">
						Number Of Operators
						<div class="help-tip">
							<p>How many employees are typically in the vehicle?</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="number-of-operators"
							type="range"
							min="0"
							max="10"
							step="1"
							value="2"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="number-of-operators-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="2"
						/>
					</div>
				</div>

				<div class="row">
					<div class="label">
						Average Hourly Rate
						<div class="help-tip">
							<p>
								What’s the average hourly rate? Include burden, insurance, and
								vacation.
							</p>
						</div>
					</div>
					<div class="range-slider">
						<input
							id="hourly-rate"
							type="range"
							min="0"
							max="50"
							step="1"
							value="24"
							data-orientation="horizontal"
						/>
					</div>
					<div class="range-value">
						<input
							id="hourly-rate-input"
							type="text"
							size="4"
							min="20"
							max="1500"
							value="24"
						/>
					</div>
				</div>
			</div>

			<span className="heading-text">
				ESTIMATED YEARLY SAVINGS WITH FUEL LOGIC:
			</span>
			<span id="estimated-savings-annually">$0</span>

			<span class="heading-text">
				ESTIMATED WEEKLY COST WITHOUT FUEL LOGIC:
			</span>
			<div class="estimated-savings">
				<div>
					<span className="computed-value" id="lost-assets-and-labor-hours">
						0
					</span>
					Hours Lost Per Week
					<br />
					<small>
						This is the time your fleet is not on the road. Lost Assets & Labor
						Hours Per Week
					</small>
				</div>
				<div>
					<span className="computed-value" id="labor-savings-per-week">
						$0
					</span>
					Labor Cost Per Week
					<br />
					<small>
						This is how much you pay your employee's to fill up your equipment
					</small>
				</div>
				<div>
					<span
						className="computed-value"
						id="every-gallon-you-pump-costs-an-additional"
					>
						$0
					</span>
					Added Cost Per Gallon
					<br />
					<small>
						Every gallon you pump (<span id="gallons-per-week">XXXX</span>{" "}
						gallons per week) costs an additional{" "}
						<span id="per-gallon">$XX.XX</span> per gallon
					</small>
				</div>
			</div>
		</div>
	);
}
