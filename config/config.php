<?php
    require_once "blogComment.php";
    $database = 'blogComment';
    $host = '172.16.9.62';
    $username = 'admin';
    $password = 'Baral@9439';
    $blogobj = new BlogComment();
    $blogobj->initDB($database, $host, $username, $password);