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
				var _email = _this.find('input[type="email"].validate-email');
				var _card = _this.find('input#card_number');
				feature._set_change( _buttons );
				feature._on_change_country( _change_country );
				feature._on_change_email( _email );
				feature._apply_card_validation( _card );

				$.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	}});

			});
		}, 
		_set_actions: function( element ){
			feature._set_change(element.find('div[data-role=submit],a[data-role=change]'));
			feature._on_change_country( element.find('select.select-country') );
			feature._apply_card_validation( element.find('input#card_number') );
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
			var _countries = [ "MX", "US", "CA", "AU" ];
			//var _countries = inspira.countries;
			element.on('change', function(){
				var _this = $(this);
				var _value = _this.val();
				var _placeholder = _this.data('placeholder');
				var _html =  $('<input>').attr({ 'type' : 'text', 'name' : 'state', 'class' : 'form-control'});

				var _select_state = _this.data('change');
				
				if( _countries.indexOf(_value) > -1 ){
					$.ajax({url: '/api/states', data: { country: _value }, type: 'POST'}).done(function(_response){
						var _states = _response.data;
						var _option = '';
						$.each(_states, function( index, value ){
							_option+= '<option value="'+value['code']+'" name="state">'+ value['name'] +'</option>';
						});
						_html = '<select name="state" class="form-control">' + _option + '</select>';
						$('.'+_select_state).html(_html);
					});
				}else{
					$('.'+_select_state).html(_html);
				}
			});
		},
		_on_change_email : function(element){
			element.on('keyup', function(){
				var _this = $(this);
				var _email = _this.val();
				var _error =  _this.parent().find('label.error-db');
		
				delay(function(){
		
					$.get('/api/users/exists', {'email': _email }, function( response ){
						var _result = response.data;
						if(_result.exists == true ){
							if(typeof _error[0] != 'object') {
								_this.parent().append('<label class="error-db">'+_result.message+'</label>');
								_this.on('focus', function(){
									_error.remove();
								});
		
							}
						}else{
							_error.remove();
						}
		
					});
				}, 500 );
		
			});
			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();

		}, 
		_apply_card_validation : function( element ){
			var last_valid = '';
			if(typeof element[0] == 'object') {
				element.validateCreditCard(function(result){
					if(result.card_type != null){
						last_valid = result.card_type.name + " valid";
						this.addClass(last_valid);
					}else{
						this.removeClass(last_valid);
					}
				 });
			}
		}
	
	};
	
	$.fn.inspira = function( method ){
		if ( feature[method] ) return feature[method].apply(this, Array.prototype.slice.call( arguments, 1 ) );
		if ( "object" === typeof method || !method ) return feature._init.apply(this, arguments);
		$.error("Method " + method + " does not exist on jQuery.inspira");
	}
})(jQuery);