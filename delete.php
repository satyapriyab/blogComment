<?php
/*
* File    : delete.php
* Purpose : Contains all php codes to delete a record.
* Created : 25-jan-2017
* Author  : Satyapriya Baral
*/

	session_start();
	require_once ('filemakerapi/Filemaker.php');
	$fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
    $id = $_GET['id']; // $id is now defined
	$deleteRecord = $fm->newDeleteCommand('blogComment', $id);
	$result = $deleteRecord->execute();
    header("Location: index.php");
?> 