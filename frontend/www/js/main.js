//jQuery('.product_add_cart').show();
jQuery(document).ready(function() {
	init();
	ProductPreview();
	Slider();
	Cart();
	
	function init(){
		jQuery('#mainContent').on('submit','#multiple-form', function(e){
			e.preventDefault();
			//var form = jQuery(this);
			
			jQuery.post( this.action,jQuery('form').serialize(),function(data){
				if (data.redirect) {
					// data.redirect contains the string URL to redirect to
					window.location.href = data.redirect;
				}
				else {
					jQuery('#mainContent').html(data);
				}
			}, 'json');
		});
		jQuery('#mainContent').on('click','.caddress .icon-minus-sign', function(e){
			var href = jQuery(this).parent().attr('href');
			var id = href.substring(href.indexOf('#'));
			jQuery(id).remove();
			tabActivate(jQuery(this).parent().parent().siblings().eq(0),jQuery('#tab_1'));
			jQuery(this).parent().parent().remove();
			return false;
		});
		jQuery('#mainContent').on('click','.add-ress', function(e){
			var prevA = jQuery(this).parent().prev('li').find('a');
			var anchor = prevA.attr('href');
			//anchor.substr(1)
			//alert(anchor.substr(anchor.indexOf('_')+1));
			
			jQuery(this).parent().siblings().removeClass('active');
			var acount = count = parseInt(anchor.substring(anchor.indexOf('_')+1));
			var ntab = jQuery(this).parent().clone().insertBefore(jQuery(this).parent());
			var a = ntab.find('a');
			count = (count == 1) ? 2 : count;
			//check if the tab was added with js to determine the number of the new tab
			acount = (count > 1) && !(prevA.hasClass('ajaxadd')) ? count-1 : count;
			
			//This makes the numbering consistent
			if(prevA.hasClass('ajaxadd')){
				a.addClass('ajaxadd');
			}
			a.html('<i class="icon-minus-sign"></i>'+' Address '+acount);		
			a.attr('href','#tab_'+(count+1));
			
			a.removeClass('add-ress');

			var ntabC = jQuery('<div class="tab-pane fade" id="tab_'+(count+1)+'"></div>').clone().appendTo('.tab-content');
			tabActivate(a.parent(),ntabC);
			
			
			//jQuery(this).attr('id');
			var clink = jQuery('#createAdd').html()+'id/'+(acount-1);
			jQuery.post( clink, {'id': (acount-1)}, function(data){
				ntabC.html(data);
			});
			return false;
		});
	}
	
	function Slider(){
		if( jQuery('#column3 .flexslider').get(0) != null){
			jQuery('#column3 .flexslider').flexslider({
				animation: "slide"
			});
		}
		
		
		if( jQuery('.product_gallery .flexslider').get(0) != null){
			jQuery('.product_gallery .flexslider').flexslider({
				animation: "fade",
				controlNav: "thumbnails"
			});
		}
		if( jQuery('.slider').get(0) != null){
			var Slide = jQuery('.slider').slider({ tooltip: 'hide'})
				.on('slide', function(ev){
					var arr = jQuery(this).slider('getValue');
					jQuery('.price_left input').val(arr[0]);
					jQuery('.price_right input').val(arr[1]);
				})
				.on('slideStop', function(ev){
					jQuery('#price-form').submit();
				});
			/*jQuery( ".price_left input[type='text'], .price_right input[type='text']" ).change(function() {
				var left = jQuery('.price_left input').val();
				var right = jQuery('.price_right input').val();
				var newValue = [ parseInt(left), parseInt(right) ];
				Slide.slider('setValue', newValue);
				jQuery('#price-form').submit();
	
			});*/
		}
		
		jQuery('.product_gallery .slides li img').elevateZoom({		
			scrollZoom : true,
		});
	}
	function ProductPreview(){
		jQuery('.product_add_cart').hide();
		jQuery('.product_preview').hover(function(){
			jQuery(this).children('.product_add_cart').show();},
			function(){jQuery(this).children('.product_add_cart').hide();}
		);
	}
	function Cart(){
		jQuery('#mainContent').on('change','.cart .quantity',function(e) {
			//e.preventDefault();		
			var pid = jQuery(this).siblings('.pid').text();
			var val = jQuery(this).val();
			var href = jQuery(this).siblings('.addlink').text()+'?cart=1&quantity='+val;
			
			//alert(val);
			//$(spinnertarget).spin("large", "white");
			jQuery('#mainContent').load(href, function(){
				//$(spinnertarget).spin(false);
			});
		});
	}
	function tabActivate(li,ntabC){
		li.siblings().removeClass('active');
		li.addClass('active');
		ntabC.siblings().removeClass('active');
		ntabC.removeClass('fade');
		ntabC.addClass('active');
	}
});
