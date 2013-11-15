Helpers.BudgetClicker = Class.extend({
	
	_subs: [],
	
	initialize: function(){
		var ths = this;
		
		$(".budget-editable").click(function(){
			for (var i in ths._subs){
				ths._subs[i]($(this).attr("id")); 
			}
		});
	},

	onClick: function(callback){
		this._subs.push(callback);
	}
});

create_singleton(Helpers.BudgetClicker);