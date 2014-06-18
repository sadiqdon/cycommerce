jQuery.noConflict();
jQuery(document).ready(function() {
	
	init();
	deleteFileUpload();
	productOrder();
	sortGrid();
	function init(){
		jQuery( document ).ajaxError(function( event, jqxhr, settings, exception ) {
			outputMessage('error',exception);
		});
		jQuery('.ylink').on('click',function(e) {
			e.preventDefault();
			var cur = jQuery(this);
			xload(cur, this.href);
		});
		jQuery('#viewContent').on( 'click','.vlink',function(e) {
			e.preventDefault();
			var cur = jQuery(this);
			xload(cur, this.href);
		});
		jQuery('.viewDrop, .updateDrop').on( 'click',function(e) {
			e.preventDefault();
			var link = this.href+jQuery('.uid').text()+'/';
			var cur = jQuery(this);
			xload(cur,link);
		});
		
		jQuery('.exportSelected a').on('click',function(e) {
			e.preventDefault();
			var expt = jQuery('.grid-view').yiiGridView('getChecked', 'check');	
			var link = this.href+'?ids='+expt;
		
			jQuery('<form action="'+this.href+'" method="POST">' + 
		'<input type="hidden" name="ids" value="' + expt + '">' +
		'</form>').appendTo(jQuery(document.body)).submit();
		});
		jQuery('.delete').on('click',function(e) {
			e.preventDefault();
			if(jQuery('.uid').text() != null){
				var href = this.href+'id/'+jQuery('.uid').text()+'/';
				//var del = jQuery('.uid').text();
				jQuery.post(href,function(data){
					if(data.success != null){
						jQuery('#viewContent').empty();
						outputMessage('success',data.success);						
					}
					else{
						outputMessage('error',data.error);
					}
					//jQuery('.manage').click();;
				},'json');
			}else{
				outputMessage('error',jQuery('#errorText').html());
			}
		});
		
		jQuery('.deleteSelected').on('click',function(e) {
			e.preventDefault();
			var del = null;
			var link = this.href;
			
			if(jQuery('.grid-view').get(0) != null){
				del = jQuery('.grid-view').yiiGridView('getChecked', 'check');
			}
			if (del != null && jQuery.trim(del)){
				jQuery.ajax({
					type:'POST',
					dataType: 'json',
					url: link,
					data:{"ids": del},
					beforeSend:function () {
						//jQuery('#viewContent').spin("large", "white");
					},
					complete:function () {
						//jQuery('#viewContent').spin(false);
					},
					success:function (data){
						jQuery('.ylink').removeClass('active');	
						jQuery('.grid-view').yiiGridView('update', {data: {}});
						if(data.success != null){
							outputMessage('success',data.success);
						}
						else{
							outputMessage('error',data.error);
						}
					}
				});	
			}else{
				outputMessage('error','Please select an item');
			}
		});
		jQuery('#viewContent').on('submit','#multiple-form', function(e){
			e.preventDefault();
			//var form = jQuery(this);
			
			jQuery.post( this.action,jQuery('form').serialize(),function(data){
				jQuery('#viewContent').html(data);
				jQuery('.viewDrop').hide();
				jQuery('.updateDrop').css( "display", "inline-block");
				jQuery('.ylink').removeClass('active');	
				jQuery('.deleteSelected').hide();
				jQuery('.delete').css( "display", "inline-block");
				//if(data){
					//form.parent().parent().html(data);
				//}
				//jQuery('#viewContent').html(data);
			});
		});
		jQuery('#viewContent').on('submit','.aform form', function(e){
			e.preventDefault();
			var form = jQuery(this);
			jQuery('#XUploadForm_file').unbind();

			jQuery.post( this.action,jQuery(this).serialize(),function(data){
				jQuery('.viewDrop').hide();
				jQuery('.updateDrop').css( "display", "inline-block");
				jQuery('.ylink').removeClass('active');	
				jQuery('.deleteSelected').hide();
				jQuery('.delete').css( "display", "inline-block");
				
				//if(data){
					form.parent().parent().html(data);
				//}
				setSwitch();
				//jQuery('#viewContent').html(data);
			});
		});
		jQuery('#viewContent').on('click','.caddress .icon-minus-sign', function(e){
			var href = jQuery(this).parent().attr('href');
			var id = href.substring(href.indexOf('#'));
			jQuery(id).remove();
			tabActivate(jQuery(this).parent().parent().siblings().eq(0),jQuery('#tab_1'));
			jQuery(this).parent().parent().remove();
			return false;
		});
		jQuery('#viewContent').on('click','.add-ress', function(e){
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
	function productOrder(){		
		//jQuery("#productSelect").change(function(){
			jQuery('#viewContent').on('change','#productSelect',function(){
			var product_id = jQuery(this).select2("val");
			jQuery.post( jQuery(".get-product-option-link").attr("href"), {"id": product_id}, function(data){
				if(jQuery(".options-order").get(0) != null)
					jQuery(".options-order").html(data);
				else
					jQuery(".select-product").after(data);
			});
			
		});
		/*jQuery('#viewContent').on('submit','.order-product-page form',function(e){
			e.preventDefault();
			jQuery.post( jQuery(".add-product-link").attr("href"), jQuery(this).serialize(), function(data){
				jQuery(".order-product-page").html(data);
			});
		});*/
		jQuery("#viewContent").on("click", ".add-product-order", function(e){
			e.preventDefault();
			//alert("here");
			//jQuery(".order-product-page form").trigger("submit");
			jQuery.post( jQuery(".add-product-link").attr("href"), jQuery('.order-product-page form').serialize(), function(data){
				jQuery(".order-product-page").html(data);
			});
			refreshOrderDetails();
		});
		
	}
	function refreshOrderDetails(){
		setTimeout(function(){jQuery.post( jQuery(".refresh-details-link").attr("href"), jQuery(".order-details-page form").serialize(), function(data){
			jQuery(".order-details-page").html(data);
		})}, 500);
	}		
	function xload(cur, href){
		jQuery('#viewContent').load(href, function(response, status, xhr){
				if(cur.hasClass('view') || cur.hasClass('viewDrop')){
					cur.hide();
					jQuery('.updateDrop').css( "display", "inline-block");
					jQuery('.ylink').removeClass('active');	
					jQuery('.exportDrop').hide();
					jQuery('.deleteSelected').hide();
					jQuery('.delete').css( "display", "inline-block");
				}else if(cur.hasClass('update') || cur.hasClass('updateDrop')){
					cur.hide();
					jQuery('.viewDrop').css( "display", "inline-block");
					jQuery('.ylink').removeClass('active');	
					jQuery('.exportDrop').hide();
					jQuery('.deleteSelected').hide();
					jQuery('.delete').css( "display", "inline-block");
				}else{
					jQuery('.ylink').removeClass('active');			
					cur.addClass('active');
					jQuery('.updateDrop, .viewDrop').hide();
					jQuery('.exportDrop').show();
					jQuery('.deleteSelected').show();
					jQuery('.delete').hide();
					
				}
				setSwitch();
		});
		return false;
	}
	function tabActivate(li,ntabC){
		li.siblings().removeClass('active');
		li.addClass('active');
		ntabC.siblings().removeClass('active');
		ntabC.removeClass('fade');
		ntabC.addClass('active');
	}
	function outputMessage(type,msg){
		var head ='';
		var alert = '';
		var lmsg = type.toLowerCase();
		if(lmsg == 'warning' || lmsg == 'error'){
			head = '<h4>'+type.toUpperCase()+'!</h4>';
		}
		if(lmsg != 'warning'){
			alert = ' alert-'+lmsg;
		}
		jQuery('#aMessage').append('<div class="alert'+alert+' alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>'+head+msg+'</div>');
	}
	//TODO remove the code below and streamline it
	function deleteFileUpload(){
		jQuery('#viewContent').on('click','#bfiles .deleteupload, #bfiles3 .deleteupload', function(e){
			e.preventDefault();
			var link = this.href;
			var cur = jQuery(this);
			jQuery.ajax({
				type:'GET',
				dataType: 'json',
				url: link,
				success:function (data){
					if(data.success){
						cur.parent().parent().remove();
					}
				}
			});
		});
		/*
		jQuery('#viewContent').on('click','#bfiles3 .deleteupload', function(e){
			e.preventDefault();
			var link = this.href;
			var cur = jQuery(this);
			jQuery.ajax({
				type:'GET',
				dataType: 'json',
				url: link,
				success:function (data){
					if(data.success){
						cur.parent().parent().remove();
					}
				}
			});
		});*/
	}
	
	function setSwitch(){
		if(jQuery('.make-switch').get(0) != null && jQuery('.has-switch').get(0) == null){
			//jQuery('.has-switch').bootstrapSwitch('destroy');
			//jQuery('.make-switch').unbind();
			jQuery('.make-switch').bootstrapSwitch();
		}
	}
	
	window.reSortGrid = function(){
		if(jQuery('.grid-view table.items tbody').get(0) != null){
			jQuery('.grid-view table.items tbody').unbind();
			sortGrid();
		}
	}
	
	function sortGrid(){
		if(jQuery('.grid-view table.items tbody').get(0) != null){
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					jQuery(this).width(jQuery(this).width());
				});
				return ui;
			};
	 
			jQuery('.grid-view table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = jQuery('.grid-view table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
					jQuery.ajax({
						'url': jQuery('.sortLink').text(),
						'type': 'post',
						'data': serial,
						'success': function(data){
							jQuery('.grid-view').yiiGridView('update');
						},
						'error': function(request, status, error){
							alert(jQuery('.errorTextSort').text());
						}
					});
				},
				helper: fixHelper
			}).disableSelection();
		}
    }
	window.bindEditable = function(td, type, title, etext, validate, model, attr, target, parent_model, source){
		jQuery("<a href=\'#\'></a>").editable({
			type: type,
			send: "never",
			title: title,
			mode: "inline",
			emptytext: etext,
			source: typeof source !== 'undefined' ? source : null,
			success: function(response, newValue) {
				if(parent_model != null && typeof parent_model !== 'undefined')
					updateInput(model, attr, td, newValue, parent_model);
				else
					updateInput(model, attr, td, newValue);
			},
			viewformat: 'dd/mm/yyyy',
			validate: validate
		}).appendTo(td);
		if(parent_model != null && typeof parent_model !== 'undefined')
			addTD(model, td, attr, target, parent_model);
		else
			addTD(model, td, attr, target);
	}
	window.validateN = function(value) {
		if(!value) return "Field is required";
	}
	
	window.validateNum = function(value) {
		if(isNaN(parseInt(value)) || !isFinite(value) ) return "Enter a valid number";
	}
	
	window.validateD = function(value) {
		if(isNaN(parseFloat(value)) || !isFinite(value) ) return "Enter a valid decimal number";
	}
	window.updateInput = function(model, name, td, nvalue, parent_model){
		//var testo = ;
		var reg =  new RegExp(model+"\\\[(\\\d+)\\\]\\\["+name+"\\\]");
	
		if(typeof parent_model !== 'undefined')
			reg =  new RegExp(parent_model[1]+"\\\["+parent_model[0]+"\\\]\\\["+model+"\\\]\\\[(\\\d+)\\\]\\\["+name+"\\\]");
		
		var td_id = td.find("input.optvalinput"+name);
		var match = null;
		if(td_id.get(0) != null){
			match = td_id.attr("name").match(reg);
		}
		
		if(match != null){
			if(typeof parent_model !== 'undefined')
				jQuery("#"+parent_model[1]+'_'+parent_model[0]+'_'+model+"_"+match[1]+"_"+name).val(nvalue);
			else{
				jQuery("#"+model+"_"+match[1]+"_"+name).val(nvalue);
			}
		}
			
	}
	function addTD(model, td, name, target, parent_model){				
		var res = target.find("input.optvalinput"+name);
		var match = null;
		var reg =  new RegExp(model+"\\\[(\\\d+)\\\]\\\["+name+"\\\]");
		if(typeof parent_model !== 'undefined')
			reg =  new RegExp(parent_model[1]+"\\\["+parent_model[0]+"\\\]\\\["+model+"\\\]\\\[(\\\d+)\\\]\\\["+name+"\\\]");
			
		if(res.get(0) != null){
			match = res.last().attr("name").match(reg);
		}
		var val = 0;
		if(match != null){
			val = parseInt(match[1])+1;
		}
		if(typeof parent_model !== 'undefined')
			td.append('<input class="optvalinput'+name+'" type="hidden" id="'+parent_model[1]+'_'+parent_model[0]+'_'+model+'_'+val+'_'+name+'" value="" name="'+parent_model[1]+'['+parent_model[0]+']['+model+']['+val+']['+name+']"/>');
		else{
			if(name == 'required' || name == 'option_value'){
				var c_val = 0;
				if(jQuery("#OptionValue .accordion-group").get(0) != null){
					var c_id = jQuery("#OptionValue .accordion-group").last().find(".collapse").attr("id");
					c_val = parseInt(c_id.replace("collapse", ""));
				}
				td.append('<input class="optvalinput'+name+'" type="hidden" id="'+model+'_'+c_val+'_'+name+'" value="" name="'+model+'['+c_val+']['+name+']"/>');
			}
			else
				td.append('<input class="optvalinput'+name+'" type="hidden" id="'+model+'_'+val+'_'+name+'" value="" name="'+model+'['+val+']['+name+']"/>');
			}
	}
});
