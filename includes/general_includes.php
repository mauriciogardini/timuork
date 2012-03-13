<?php
function redirect($url, $secondsToRedirect) {
    $url = str_replace('&amp;', '&', $url); 
             
    if($secondsToRedirect > 0) { 
        header("Refresh: $secondsToRedirect; URL=$url"); 
    } 
    else {
        header("Location: $url"); 
        exit; 
    } 
}
