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