/**
 * @load Views.Abstract
 * @load Helpers.BudgetClicker
 */

Views.BudgetEditor = Views.Abstract.extend({
	
	_key: null,
	_value: null,
	_popover: null,
	
	_config: {
		animation: false,
		title: "Custom Budget",
		content: '',
		html: true,
		placement: "top",
		trigger: "manual"
	},
	
	initialize: function(id, key, value){
		this._id = id;
		this._key = key;
		this._value = value;
		
		this._render();	
				
		Helpers.BudgetClicker.getInstance().onClick($.proxy(function(id){
			if (this._id == id && !this._el.hasClass("budget-active")) {
				this._showPopover();
			} else {
				this._hidePopover();
			}
		}, this));
	},
	
	_render: function(){
		this._super();
		this._popover = this._renderContent();
		this._el.popover($.extend(this._config, {content: this._popover}));
	},
	
	_renderContent: function()
	{
		return $($("#edit-budget-dialog").html().render({ref: this._id}));
	},
	
	_showPopover: function(){
		this._el.popover("show");
		
		this._popover.find("#close-popover").click($.proxy(function(){
			this._hidePopover();
		}, this));
		
		this._popover.find("#change-budget").click($.proxy(this._changeBudget, this));
		
		this._popover.find("[name=budget]").val(this._toMoney(this._value * 1));
		
		this._el.addClass("budget-active");
	},
	
	_changeBudget: function(){
		this._popover.find("input, button").attr("disabled", "disabled");
		
		var data = {
			date: this._key,
			amount: this._popover.find("[name=budget]").val()
		};
		
		post("/params/updateBudget", data, {
			error: $.proxy(function(data){
				this._popover.find("input, button").removeAttr("disabled");
				new Helpers.ErrorsHandler(data).show();
			}, this),
			success: function(){
				location.reload();
			}
		});
	},
	
	_hidePopover: function(){
		this._el.popover("hide");
		this._el.removeClass("budget-active");
	},
	
	_toMoney: function(n){
		return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1");
	}
});