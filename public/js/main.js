$(document).ready(function(){
	$('body').inspira();
	
	setResizeWindow();

	function setResizeWindow(){
		var wd = document.documentElement.clientWidth;
		if($('.swiper-container')) {
			$('.swiper-container').css('width', wd);
		}
	}

	$(window).on('resize orientationChanged', function(){ setResizeWindow(); });

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
				var _masked = _this.find('input[data-mask-type]');
				var _fund = _this.find('input[name="fondo"]');
				var _language = _this.find('select[id="language"]');
				var _radio_bonus = _this.find('#bonus input[type="radio"]');
				var _anchor = $(this).find('a[data-anchor]');

				feature._set_change( _buttons );
				feature._on_change_country( _change_country );
				feature._on_change_email( _email );
				feature._apply_card_validation( _card );
				feature._apply_masked_input( _masked );
				feature._enable_fund( _fund );
				feature._change_language( _language );
				feature._apply_bonus( _radio_bonus );
				feature._apply_anchor( _anchor );

				$.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	}});

			});
		}, 
		_set_actions: function( element ){
			feature._set_change(element.find('div[data-role=submit],a[data-role=change]'));
			feature._on_change_country( element.find('select.select-country') );
			feature._apply_card_validation( element.find('input#card_number') );
			feature._on_change_email( element.find('input[type="email"].validate-email') );
			feature._apply_masked_input( element.find('input[data-mask-type]') );
			feature._enable_fund( element.find('input[name="fondo"]') );
			feature._apply_bonus( element.find('#bonus input[type="radio"]') );
		},
		_set_change: function( element ) {
			element.bind('click', function(){
				var _this = $(this);
				var _response = _this.closest('div[data-role=response]');
				var _form = _this.parents('form');
				var _route = _this.data('route');

				var _data = {};
				
				if(typeof _route == 'undefined'){
					_form.submit();
					return;
				}
								
				if(typeof _form[0] == 'object'){
					_data = _form.serialize();
				}
				
				$('#loading-inspira, #bg-loading').toggle();
				_this.removeAttr('data-role');
				$.ajax({url:_route, data: _data, type: 'POST'}).done(function(_ajax_response){
					$('#loading-inspira, #bg-loading').toggle();
								
					if(_ajax_response.redirect){
						$('.modal').modal('hide');

						if(_ajax_response.html){
	
							$('#message div[class=modal-body]').html(htmlDecode(_ajax_response.html));
							$('#message').modal('show');
							$('#message').on('hidden.bs.modal', function () {
								window.location.href = _ajax_response.redirect;
							});
								
							function htmlDecode(input){
							  var e = document.createElement('div');
							  e.innerHTML = input;
							  return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
							}
							
							feature._set_actions($('#message div[class=modal-body]'));
							return false;
						}else if(_ajax_response.message){
							//Modal 
							$('#message #text').html(_ajax_response.message);
							$('#message').modal('show');
							$('#message').on('hidden.bs.modal', function () {
								window.location.href = _ajax_response.redirect;
							});
						}else{
							window.location.href = _ajax_response.redirect;	
						}
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
				var _route = _this.data('route') ? _this.data('route') : 'api/states';
				var _html =  $('<input>').attr({ 'type' : 'text', 'name' : 'state', 'class' : 'form-control'});

				var _select_state = _this.data('change');
				
				if( _countries.indexOf(_value) > -1 ){
					$.ajax({url: _route, data: { country: _value }, type: 'POST'}).done(function(_response){
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
				var _route = _this.data('route');
				var _email = _this.val();
				var _error =  _this.parent().find('label.error-db');
		
				delay(function(){
		
					$.get(_route, {'email': _email }, function( response ){
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
		},
		_apply_masked_input : function( element ) {
			$.each(element, function(){
				var _this = $(this);
			
				var _placeholder = _this.attr('placeholder');
				var _type = _this.data('mask-type');
				var _mask = '';
				if(_type == 'expiration'){
					_mask = "9999/99";
				}
				else if(_type == 'date'){
					_mask = "9999/99/99";
				}
				else if( _type == 'celular'){
					_mask = "(999) 999-9999"
				}
				_this.mask( _mask, {placeholder: _placeholder } );
			});
		},
		_enable_fund : function ( element ) {
			element.on('change', function(){
				var _this = $(this);
				var _amount_input = $('input[name="amount"]');
				var _disabled = _this.val() == 1 ? false : true;
				var _value = _disabled == true ? '0.00' : '0.00';
				_amount_input.val(_value);
				_amount_input.attr( 'placeholder', _value );
				_amount_input.prop('disabled', _disabled );
			});
		},
		_change_language : function( element ) {
			element.on('change', function() {
				var _this = $(this);
				var _route = _this.data('route');
				var _response = _this.closest('div[data-role=response]');
				var _form = _this.parents('form');
								
				var _data = {};
				
				if(typeof _form[0] == 'object'){
					_data = _form.serialize();
				}
				
				$('#loading-inspira, #bg-loading').toggle();
				$.ajax({url: _route, data: _data, type: 'POST'}).done(function(_response){
					if(!_response.error){
						$('#loading-inspira, #bg-loading').toggle();
						window.location.href =_response.redirect;	
					}
				});

			});
		},
		_apply_bonus : function( element ){
			element.on('change', function(){
				var _this = $(this);
				var _response = _this.closest('div[data-role=response]');
				var _form = _this.parents('form');
				var _route = _form.attr('action');
			
				if(typeof _form[0] == 'object'){
					_data = _form.serialize();
				}

				if( _route ){
					$('#loading-inspira, #bg-loading').toggle();

					$.ajax({url:_route, data: _data, type: 'POST'}).done(function(_ajax_response){
						$('#loading-inspira, #bg-loading').toggle();
						_response.html(_ajax_response);
						feature._set_actions(_response);
					}).fail(function(){
		
					});


				}
			});
		},
		_apply_anchor : function( element ){
			element.on('click', function(){
				var _this = $(this);
				var _name = $(this).data('anchor');			
				var _top = $('div.header').height();
				$("html,body").animate({scrollTop:$("div[data-id="+_name+"]").offset().top - _top},"500");
			});
		}
	};
	
	$.fn.inspira = function( method ){
		if ( feature[method] ) return feature[method].apply(this, Array.prototype.slice.call( arguments, 1 ) );
		if ( "object" === typeof method || !method ) return feature._init.apply(this, arguments);
		$.error("Method " + method + " does not exist on jQuery.inspira");
	}
	
	var wd = document.documentElement.clientWidth;
	var swiperH = new Swiper('.swiper-container-h', {
		pagination: '.swiper-pagination-h',
	    paginationClickable: true,
	    slidesPerView: 1,
		width:wd,
	    speed: 500,
 	    autoplay: 10000
	});
	

})(jQuery);