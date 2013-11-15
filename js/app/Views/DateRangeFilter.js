/**
 * @load Views.AbstractForm
 */
Views.DateRangeFilter = Views.AbstractForm.extend({
	_id: 'date-range-filter',
	
	_config: {
		format: "mm/yyyy",
		minViewMode: "months",
		viewMode: "years",
		startView: "month",
		autoclose: true
	},
	
	initialize: function(config){
		this._super();
		
		this._el.find('#date_from').datepicker($.extend(this._config, {
			startDate: config.date_from_min,
			endDate: config.date_from_max
		}));
		this._el.find('#date_to').datepicker($.extend(this._config, {
			startDate: config.date_to_min,
			endDate: config.date_to_max
		}));
	},
	
	success: function(){
		location.reload();
	}
});