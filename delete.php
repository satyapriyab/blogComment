<?php
/*
* File    : delete.php
* Purpose : Contains all php codes to delete a record.
* Created : 25-jan-2017
* Author  : Satyapriya Baral
*/
	//connecting to the database
	require_once "./config/config.php";
	
	//Record id of the blog is initialized from the URL.
    $id = $_GET['id']; 
	
	//command to delete the record.
	$blogobj->deleteRecord("blogComment", $id);
	
	//After deletion redirect to the index page.
    header("Location: index.php");
?> 