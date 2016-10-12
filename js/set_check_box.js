function setCheckboxes(the_form, id, do_check)
{
    var elts      = (typeof(document.forms[the_form].elements[id]) != 'undefined')
                  ? document.forms[the_form].elements[id]
                  : 0;
    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        }
    } else {
        elts.checked        = do_check;
    }
return true; 
}

function check_chose(id, arid, the_form)
{
	var n = $('#'+id+':checked').val();
	if(n)
		setCheckboxes(the_form, arid, true);
	else
		setCheckboxes(the_form, arid, false);
}

function verify_del()
{
	return window.confirm("Bạn có muốn xóa các mục này không?\nVui lòng xác nhận.");
}

function verify_delpage()
{
	return window.confirm("Bạn muốn xóa trang này?\nVui lòng xác nhận.");
}
