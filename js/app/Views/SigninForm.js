/**
 * @load Views.AutoRedirectForm
 */
Views.SigninForm = Views.AutoRedirectForm.extend({
	_id: 'signin-form',
	
	success: function(res){
		location.href = this._redirect_url;
		/*if (res.has_freshbooks){
			this._el.find('#action-label').show();
			this._el.find('#inputs-container').hide();
			
			post('/import/update', {}, {
				'callback': $.proxy(function(){
					location.href = this._redirect_url;
				}, this)
			});
		} else {
			location.href = this._redirect_url;
		}*/
	}
});