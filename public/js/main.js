$(document).ready(function(){
	$('body').inspira();
});

(function($){
	var feature = {
		_init: function() {
			return this.each(function(){
				var _this = $(this);
				var _buttons = _this.find('a[data-role=change], div[data-role=submit]');
				feature._set_change( _buttons );

				$.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	}});

			});
		}, 
		_set_actions: function( element ){
			feature._set_change(element.find('div[data-role=submit],a[data-role=change]'));
		},
		_set_change: function( element ) {
			element.bind('click', function(){
				var _this = $(this);
				var _response = _this.closest('div[data-role=response]');
				var _form = _response.find('form:first');
				var _route = _this.data('route');

				var _data = {};
				
				if(typeof _form[0] == 'object'){
					_data = _form.serialize();
				}

				$.ajax({url:_route, data: _data, type: 'POST'}).done(function(_html){
					_response.html(_html);
					feature._set_actions(_response);
				}).fail(function(){
	
				});
			});
		}, 
	
	};
	
	$.fn.inspira = function( method ){
		if ( feature[method] ) return feature[method].apply(this, Array.prototype.slice.call( arguments, 1 ) );
		if ( "object" === typeof method || !method ) return feature._init.apply(this, arguments);
		$.error("Method " + method + " does not exist on jQuery.inspira");
	}
})(jQuery);