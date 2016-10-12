function isNumber(Digit) {
		return /^\d+[\.\d*]?$/.test(Digit);
	}
	function checkForm(frm)
	{
		if(frm.username.value===""){
			frm.username.focus();
			alert("Chưa nhập nickname!");
			return false;
		}
		if(frm.username.value.length < 4){
			frm.username.focus();
			alert("Nickname không dưới 4 ký tự!");
			return false;
		}
		if(frm.password.value===""){
			frm.password.focus();
			alert("Chưa nhập mật khẩu!");
			return false;
		}
		if(frm.password.value.length < 5){
			frm.password.focus();
			alert("Mật khẩu không dưới 5 ký tự!");
			return false;
		}
		if(frm.fullname.value===""){
			frm.fullname.focus();
			alert("Chưa nhập họ tên!");
			return false;
		}
		return true;
	}