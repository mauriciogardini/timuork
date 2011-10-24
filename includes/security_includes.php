<?php
require_once(dirname(__DIR__) . "/lib/PasswordHash.php");
require_once(dirname(__DIR__) . "/config/config.php");

function crypt_word($word) {
    $hasher = new PasswordHash(STRETCHING_TIMES, PORTABLE_HASH);
    $hash = $hasher->HashPassword($word);
    if (strlen($hash) >= 20) {
        return $hash;
    } 
    else 
    {
        // Something went wrong - 20 is the minimum.
        return NULL; 
    }
}

function words_match($word, $word_hash) {
    $hasher = new PasswordHash(STRETCHING_TIMES, PORTABLE_HASH);
    return ($hasher->CheckPassword($word, $word_hash));
}
