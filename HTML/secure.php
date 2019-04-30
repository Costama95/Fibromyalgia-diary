<?php 
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Move Permanently');
    header('Location: ' . $redirect);
    exit();
  }