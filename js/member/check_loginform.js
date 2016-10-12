	function checkLoginForm(frm)
	{
		if(frm.email.value===""){
			frm.email.focus();
			alert("Chưa nhập Tài khoản!");
			return false;
		}
		if(frm.password.value===""){
			frm.password.focus();
			alert("Chưa nhập mật khẩu!");
			return false;
		}
		return true;
	}