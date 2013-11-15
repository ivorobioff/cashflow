Helpers.ErrorsHandler = Class.extend({

	_data: null,
	
	initialize: function(data){
		this._data = data;
	},
	
	show: function(){
		if (_.keys(this._data).length == 1){
			alert(this._data[_.first(_.keys(this._data))]);
			return ;
		}
		
		var errors = "";
		var c = 1;
		for (var i in this._data){
			errors += c + ". " + this._data[i] + "\n";
			c++;
		}
		
		alert(errors);
	}
});
Views.Abstract = Class.extend({
	_id: null,
	_tag: null,
	_el: null,

	_render: function(){
		if (_.isString(this._id)){
			this._el = $('#' + this._id);
		}else if(_.isString(this._tag)){
			this._el = $(this._tag);
		}
	},
	
	getElement: function(){
		return this._el;
	},
	
	remove: function(){
		this._el.remove();
	}
});
/**
 * @load Views.Abstract
 * @load Helpers.ErrorsHandler
 * 
 */
Views.AbstractForm = Views.Abstract.extend({
	
	_url: '',
	_id: 'single-form',
	_el: null,
	_data: {},
	
	initialize: function(){
		this._render();
		this._url = this._el.attr('action');
		this._el.submit($.proxy(function(){
			this._data = this._el.serialize();
			this.beforeSubmit();
			$.post(this._url, this._data, $.proxy(function(res){
				this.afterSubmit(res);
				
				if (typeof res.status != 'string'){
					throw 'wrong status';
				}
				
				if (res.status == 'success'){
					this.success(res.data);
				} else if (res.status == 'error') {
					this.error(res.data);
				} else {
					throw 'wrong status';
				}
			}, this), 'json');
			
			return false;
		}, this));
	},
	
	beforeSubmit: function(){
		this.disableUI();
	},
	
	afterSubmit: function(data){},
	
	success: function(data){},
	
	error: function(data){
		this._showErrors(data);
		this.enableUI();
	},
	
	disableUI: function(){
		this._el.find('input, select, textarea, button').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	},
	
	enableUI: function(){
		this._el.find('input, select, textarea, button').each(function(){
			$(this).removeAttr('disabled');
		});
	},
	
	_showErrors: function(data){
		new Helpers.ErrorsHandler(data).show();
	}
});
/**
 * @load Views.AbstractForm
 */
Views.AutoRedirectForm = Views.AbstractForm.extend({
	_redirect_url: '',

	initialize: function(url){
		this._super();
		this._redirect_url = url;
	},
	
	success: function(){
		location.href = this._redirect_url;
	}
});
/**
 * @load Views.AutoRedirectForm
 */
Views.ImportFreshbooks = Views.AutoRedirectForm.extend({
	_id: 'signin-form'
});
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
/**
 * @load Views.Abstract
 * @load Helpers.ErrorsHandler
 */
Views.MiniForms = Views.Abstract.extend({
	_id: 'mini-forms',
	
	initialize: function(){
		this._render();
				
		this._el.find(".btn").each(function(){
			var button = $(this);
			var input = button.prev('input');
			
			button.click(function(){
				input.attr("disabled", "disabled");
				
				var data = {
						key: input.attr('name'),
						value: input.val(), 
				};
				
				post('/params/update', data, {
					error: function(data){
						input.removeAttr("disabled");
						new Helpers.ErrorsHandler(data).show();
					},
					
					success: function(){
						location.reload();
					}
				});
			});
		});
	}
});
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
