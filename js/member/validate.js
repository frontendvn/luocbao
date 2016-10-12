$(document).ready(function(){
	var url = "http://localhost/askvietpr/index.php/member/";
	var img = "http://localhost/askvietpr/resources/std_imgs/";
	var check_img = '<img src="' + img+ 'accept.gif" alt="" style="vertical-align:middle" />';
	var warning_img = '<img src="' + img+ 'exclamation.gif" alt="" style="vertical-align:middle" />';
		$('#swap').click(function(){
			$.get(url + '/swapcaptcha', function(mess){
					$("#captcha").html(mess).show("fast");
			});
		});
		$('#username').keyup(function(){
			if(this.value.length<4) 
				$('#chkus').html(warning_img + ' độ dài từ 4 ký tự trở lên').show();
			else $('#chkus').html(check_img).show();
		});
		$('#username').blur(function(){
			if(this.value.length<4) 
				$('#chkus').html(warning_img + ' độ dài từ 4 ký tự trở lên').show();
			else $('#chkus').html(check_img).show();
		});
		$('#password').keyup(function(){
			if(this.value.length<5) 
				$('#chkpass').html(warning_img + ' độ dài từ 5 ký tự trở lên').show();
			else $('#chkpass').html(check_img).show();
		});
		$('#passconf').keyup(function(){
			if(this.value.length<5) 
				$('#chkpassconf').html(warning_img + ' độ dài từ 5 ký tự trở lên').show();
			else
				if($('input#password').val()!==$('input#passconf').val()) 
					$('#chkpassconf').html(warning_img + ' Xác nhận mật khẩu chưa đúng').show();
				else 
					$('#chkpassconf').html(check_img).show();
		});
		$('#password').blur(function(){
			if(this.value.length<5) 
				$('#chkpass').html(warning_img + ' độ dài từ 5 ký tự trở lên').show();
			else $('#chkpass').html(check_img).show();
		});
		$('#passconf').blur(function(){
			if(this.value.length<5) 
				$('#chkpassconf').html(warning_img + ' độ dài từ 5 ký tự trở lên').show();
			else
				if($('input#password').val()!==$('input#passconf').val()) 
					$('#chkpassconf').html(warning_img + ' Xác nhận mật khẩu chưa đúng').show();
				else 
					$('#chkpassconf').html(check_img).show();
		});
		$('#email').keyup(function(){
			if(!	isEmail($(this).val())) 
				$('#chkemail').html(warning_img + ' Email chưa đúng!').show();
			else $('#chkemail').html(check_img).show();
		});
		$('#emailconf').keyup(function(){
			if(!	isEmail($(this).val())) 
				$('#chkemailconf').html(warning_img + ' Email chưa đúng!').show();
			else 
				if($('input#email').val()!==$('input#emailconf').val())
						$('#chkemailconf').html(warning_img + ' Xác Nhận Email chưa đúng').show();
				else
					$('#chkemailconf').html(check_img).show();
		});
		$('#email').blur(function(){
			if(!	isEmail($(this).val())) 
				$('#chkemail').html(warning_img + ' Email chưa đúng!').show();
			else $('#chkemail').html(check_img).show();
		});
		$('#emailconf').blur(function(){
			if(!	isEmail($(this).val())) 
				$('#chkemailconf').html(warning_img + ' Email chưa đúng!').show();
			else 
				if($('input#email').val()!==$('input#emailconf').val())
						$('#chkemailconf').html(warning_img + ' Xác Nhận Email chưa đúng').show();
				else
					$('#chkemailconf').html(check_img).show();
		});
		
		$(function() {
			$("#birthday").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd/mm/yy"
			});
		});
		function isEmail (emailStr) {
			/* The pattern for matching fits the user@domain format. */
			//var re = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
			var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
			if (!emailStr.match(re))
					return false;
			return true;
		}
})