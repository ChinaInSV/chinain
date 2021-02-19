var ChinaIn_tools=function(){
	this.scroll=true;
	
	this.showMsg=function(tipo, mensaje){
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-top-right"
		}
		toastr[tipo](mensaje);
	},
	
	this.initializeKeyboard=function(windowId){
		$("#"+windowId+" input[type='text']:not(.key-num):not([readonly]),#"+windowId+" input[type='password']").keyboard({
			layout: 'international',
			openOn: '',
			autoAccept : false,
			css: {
				input: 'form-control input-lg',
				container: 'center-block well',
				buttonDefault: 'btn btn-gray-dark btn-lg',
				buttonHover: 'btn-dark',
				buttonAction: 'active',
				buttonDisabled: 'disabled'
			},
			accepted: function(e, keyboard, el) {
				e.preventDefault();
				var attrTab = $(el).attr('data-tab');				
				if (typeof attrTab !== typeof undefined && attrTab !== false) {
					$($(el).data("tab")).trigger("dblclick");					
				}

				var attrKeyup = $(el).attr('data-keyup');
				if (typeof attrKeyup !== typeof undefined && attrKeyup !== false) {
					$(el).trigger("keyup");					
				}				
			},
			change: function(e, keyboard, el) {
				e.preventDefault();
				
			},
			canceled: function(e, keyboard, el) {
				e.preventDefault();
				var attrKeyup = $(el).attr('data-keyup');
				if (typeof attrKeyup !== typeof undefined && attrKeyup !== false) {
					$(el).trigger("keyup");					
				}
			},
		});
		
		$("#"+windowId+" input[type='text'].key-num").keyboard({
			layout: 'num',
			openOn: '',
			autoAccept : false,
			css: {
				input: 'form-control input-lg',
				container: 'center-block well',
				buttonDefault: 'btn btn-gray-dark btn-lg',
				buttonHover: 'btn-dark',
				buttonAction: 'active',
				buttonDisabled: 'disabled'
			},
			accepted: function(e, keyboard, el) {
				e.preventDefault();
				var attrTab = $(el).attr('data-tab');				
				if (typeof attrTab !== typeof undefined && attrTab !== false) {
					$($(el).data("tab")).trigger("dblclick");
				}

				var attrKeyup = $(el).attr('data-keyup');
				if (typeof attrKeyup !== typeof undefined && attrKeyup !== false) {
					$(el).trigger("keyup");					
				}				
			},
			change: function(e, keyboard, el) {
				e.preventDefault();
				
			},
			canceled: function(e, keyboard, el) {
				e.preventDefault();
				var attrKeyup = $(el).attr('data-keyup');
				if (typeof attrKeyup !== typeof undefined && attrKeyup !== false) {
					$(el).trigger("keyup");					
				}
			},
		});
		
		$("#"+windowId+" input[type='text'],#"+windowId+" input[type='password']").dblclick(function(){
			var kb = $(this).getkeyboard();
			if ( kb.isOpen ) {
				kb.close();
			} else {
				kb.reveal();
			}
		});
		
		$("#"+windowId+" .show-keyboard-text").click(function(){
			var kb = $(this).prev().getkeyboard();
			if ( kb.isOpen ) {
				kb.close();
			} else {
				kb.reveal();
			}
		});
		
		$("#"+windowId+" input[type='number']").dblclick(function(){
			var kb = $(this).getkeyboard();
			if ( kb.isOpen ) {
				kb.close();
			} else {
				kb.reveal();
			}
		});
	},
	this.initializeEnviroment=function(baseUrl){
		
	}
}

var ChinaInTools = new ChinaIn_tools();
