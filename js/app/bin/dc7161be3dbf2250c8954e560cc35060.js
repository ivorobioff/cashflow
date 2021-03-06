Libs.Event = Class.extend({
	_events: null,
	
	initialize: function(){
		this._events = {};
	},
	
	add: function (event, callback){
		if (_.isUndefined(this._events[event])){
			this._events[event] = [];
		}
		
		this._events[event].push(callback);
	},
	
	trigger: function(event, params){
		
		if (_.isUndefined(this._events[event])) return ; 
		if (_.isUndefined(params)) params = [];	
		
		var events = this._events[event];
		
		for (var i in events){
			events[i].apply(this, params)
		}
	}
});
/**
 * @load Libs.Event
 */
Models.Abstract = Class.extend({
	
	_data: null,
	_event: null,
	
	initialize: function(data){
		
		if (_.isUndefined(data)) data = {};
		
		this._data = data;
		this._event = new Libs.Event();
	},
		
	get: function(key){
		return this._data[key];
	},
	
	set: function(key, value, silent){
		
		if (_.isUndefined(silent)) silent = false;
		
		if (!silent) this._event.trigger("set:" + key + ":before", [this]);
		this._set(key, value);		
		if (!silent) this._event.trigger("set:" + key + ":after", [value, this]);
		return this;
	},
	
	update: function(data, silent)
	{
		if (_.isUndefined(silent)) silent = false;
		
		if (!silent) this._event.trigger("update:before", [this]);
	
		for(var i in data){
			this._set(i, data[i]);
		}
		
		if (!silent) this._event.trigger("update:after", [this]);
		return this;
	},
	
	getAll: function(){
		return this._data;
	},
	
	onUpdate: function(callback){
		if (!_.isFunction(callback)){
			this._event.add("update:before", callback.before);
			this._event.add("update:after", callback.after);
		} else {
			this._event.add("update:after", callback);
		}
		return this;
	},
	
	onSet: function(key, callback){
		if (!_.isFunction(callback)){
			this._event.add("set:" + key + ":before", callback.before);
			this._event.add("set:" + key + ":after", callback.after);
		} else {
			this._event.add("set:" + key + ":after", callback);
		}
		
		return this;
	},
	
	_set: function(key, value){
		this._data[key] = value;
	}
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
