function setCheckboxes(the_form, do_check)
{
    var elts      = (typeof(document.forms[the_form].elements['newid[]']) != 'undefined')
                  ? document.forms[the_form].elements['newid[]']
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
function verify_del(){
	return window.confirm("Bạn có muốn xóa mục này ko?\nVui lòng xác nhận!");
}