var Login = function(url){
	this.baseUrl=url;
	this.msg1 = "";
	this.msg2 = "";
	this.go=function(){
		var _this=this;
		$("#login-username").attr("disabled","disabled");
		$("#login-password").attr("disabled","disabled");
		$("#login-btn").attr("disabled","disabled");
		
		if($("#login-username").val()=="" || $("#login-password").val()==""){
			new $.Zebra_Dialog({
				title: 'China In App',
				message: _this.msg1,
				custom_class:"zebra-warning"
			});
			$("#login-username").removeAttr("disabled");
			$("#login-password").removeAttr("disabled");
			$("#login-btn").removeAttr("disabled");
			if($("#login-username").val()==""){
				$("#login-username").focus();				
			}else{
				$("#login-password").focus();		
			}
		}else{
			 $.post(this.baseUrl+"login/check",{username:$.trim($("#login-username").val()),password:$.trim($("#login-password").val())}, function(response){
				if(response=="true"){
					$("#login-username").removeAttr("disabled");
					$("#login-password").removeAttr("disabled");
					$("#login-form").submit();
				}else if(response=="inactivo"){
					new $.Zebra_Dialog({
						title: 'China In App',
						message: _this.msg3,
						custom_class:"zebra-warning"
					});
					$("#login-username").removeAttr("disabled");
					$("#login-password").removeAttr("disabled");
					$("#login-password").val("");
					$("#login-btn").removeAttr("disabled");
					$("#login-username").select();
				}else{
					new $.Zebra_Dialog({
						title: 'China In App',
						message: _this.msg2,
						custom_class:"zebra-warning"
					});
					$("#login-username").removeAttr("disabled");
					$("#login-password").removeAttr("disabled");
					$("#login-password").val("");
					$("#login-btn").removeAttr("disabled");
					$("#login-username").select();
				}
			 },"text")
		}
	}
}