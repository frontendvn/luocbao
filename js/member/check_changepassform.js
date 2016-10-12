	function checkChangePassForm(frm)
	{
		if(frm.oldpass.value===""){
			frm.oldpass.focus();
			alert("Chưa nhập mật khẩu cũ!");
			return false;
		}
		if(frm.newpass.value===""){
			frm.newpass.focus();
			alert("Chưa nhập mật khẩu mới!");
			return false;
		}
		if(frm.newpass.value.length < 5){
			frm.newpass.focus();
			alert("Mật khẩu mới không dưới 5 ký tự!");
			return false;
		}
		if(frm.newpass_repeat.value===""){
			frm.newpass_repeat.focus();
			alert("Chưa nhập xác nhận lại mật khẩu mới!");
			return false;
		}
		if(frm.newpass_repeat.value!==frm.newpass.value){
			frm.newpass_repeat.focus();
			alert("Mật khẩu mới và Xác nhận mật khẩu mới phải giống nhau!");
			return false;
		}
		return true;
	}