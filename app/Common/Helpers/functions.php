<?php
if (!function_exists('is_positive_integer')) {
    function is_positive_integer($num)
    {
        if($num>0 && floor($num)==$num){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('is_email')){
    function is_email($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}