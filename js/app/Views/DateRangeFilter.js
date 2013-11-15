/**
 * @load Views.AbstractForm
 */
Views.DateRangeFilter = Views.AbstractForm.extend({
	_id: 'date-range-filter',
	
	initialize: function(){
		this._super();
		this._el.find('#date_from').datepicker();
		this._el.find('#date_to').datepicker();
	},
	
	success: function(){
		location.reload();
	}
});