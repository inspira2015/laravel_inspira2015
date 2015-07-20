$(document).ready(function(){
	$('body').inspira();
});

(function($){
	var feature = {
		_init: function() {
			return this.each(function(){
				var _this = $(this);
				var _buttons = _this.find('a[data-role=change], div[data-role=submit]');
				var _change_country = _this.find('select.select-country');
				feature._set_change( _buttons );
				feature._on_change_country( _change_country );

				$.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	}});

			});
		}, 
		_set_actions: function( element ){
			feature._set_change(element.find('div[data-role=submit],a[data-role=change]'));
			feature._on_change_country( element.find('select.select-country') );
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

				$.ajax({url:_route, data: _data, type: 'POST'}).done(function(_ajax_response){
					if(_ajax_response.redirect){
						window.location.href = _ajax_response.redirect;
					}else{
						_response.html(_ajax_response);
					}
					feature._set_actions(_response);
				}).fail(function(){
	
				});
			});
		}, 
		_on_change_country : function( element ){
			//var _countries = [ "MX", "US", "CA", "AU" ];
			var _countries = inspira.countries;
			element.on('change', function(){
				var _this = $(this);
				var _value = _this.val();
				var _placeholder = _this.data('placeholder');
				var _html =  $('<input>').attr({ 'type' : 'text', 'name' : 'state'});

				var _select_state = _this.data('change');
				
				if( _countries.indexOf(_value) > -1 ){
					//make request form list - states 
					$.ajax({url: '/api/states', data: { country: _value }, type: 'POST'}).done(function(_response){
						var _states = _response.data;
						var _option = '';
						$.each(_states, function( index, value ){
							_option+= '<option value="'+value['code']+'">'+ value['name'] +'</option>';
						});
						_html = '<select name="state">' + _option + '</select>';
						$('.'+_select_state).html(_html);
					});
				}else{
					$('.'+_select_state).html(_html);
				}
			});
		},
	
	};
	
	$.fn.inspira = function( method ){
		if ( feature[method] ) return feature[method].apply(this, Array.prototype.slice.call( arguments, 1 ) );
		if ( "object" === typeof method || !method ) return feature._init.apply(this, arguments);
		$.error("Method " + method + " does not exist on jQuery.inspira");
	}
})(jQuery);