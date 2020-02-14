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