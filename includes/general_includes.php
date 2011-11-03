<?php
function redirect($url, $seconds_to_redirect)
{
    $url = str_replace('&amp;', '&', $url); 
             
    if($seconds_to_redirect > 0) 
    { 
        header("Refresh: $seconds_to_redirect; URL=$url"); 
    } 
    else 
    {   //Como funciona isso? 
        //@ob_flush();
        //@ob_end_clean();
        header("Location: $url"); 
        exit; 
    } 
}
