<?php

function getGet($key)
{
    $value = '';
    if (issue($_GET[$key])) {
        $value = $_GET[$key];
    }
    return $value;
}

function getPost($key)
{
    $value = '';
    if (issue($_POST[$key])) {
        $value = $_POST[$key];
    }
    return $value;
}

function getCookie($key)
{
    $value = '';
    if (issue($_COOKIE[$key])) {
        $value = $_COOKIE[$key];
    }
    return $value;
}

function getPwdSecurity($pwd)
{
    return md5($pwd);
}
