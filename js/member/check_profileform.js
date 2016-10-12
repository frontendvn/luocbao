function isNumber(Digit) {
		return /^\d+[\.\d*]?$/.test(Digit);
	}
	function checkProfileForm(frm)
	{
		if(frm.fullname.value===""){
			frm.fullname.focus();
			alert("Chưa nhập họ tên!");
			return false;
		}
		if(frm.phone.value!=="" && !isNumber(frm.phone.value)){
			frm.phone.focus();
			alert("Số điện thoại có ký tự không phải là số!");
			return false;
		}
		if(frm.phone.value!=="" && frm.phone.value.length!==10){
			frm.phone.focus();
			alert("Số điện thoại không dưới 10 chữ số!");
			return false;
		}
		return true;
	}