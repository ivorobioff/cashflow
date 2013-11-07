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