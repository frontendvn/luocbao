<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function fix_quote($what = "") {
    $what = ereg_replace("'","''",$what);
    while (eregi("\\\\'", $what)) {
        $what = ereg_replace("\\\\'","'",$what);
    }
    return $what;
}
	


?>