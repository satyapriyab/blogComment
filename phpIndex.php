<?php
/*
* File    : phpIndex.php
* Purpose : Contains all Php code to create record in database and display it
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

if (isset($_POST['blog-btn']))
    {
		$title = $blogobj->Sanitize($_POST['title']);
        $author = $blogobj->Sanitize($_POST['author']);
        $content = $blogobj->Sanitize($_POST['content']);
		$category = $blogobj->Sanitize($_POST['category']);
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");
		
		if($category === 'All') { $categoryNumber = 1; }
		elseif($category === 'Sports') { $categoryNumber = 2; }
		elseif($category === 'Education') { $categoryNumber = 3; }
		elseif($category === 'Politics') { $categoryNumber = 4; }
		//check if the fields are entered
		if((strlen($title) < 1) || (strlen($author) < 1) || (strlen($content) < 1))
		{
			$error = true;
		}
		
		if(! $error)
		{
			$record = $blogobj->create("blogComment");
			$record->setField('subject', $title);
			$record->setField('author', $author);
			$record->setField('blog', $content);
			$record->setField('date', $date);
			$record->setField('time', $time);
			$record->setField('category', $categoryNumber);
			$record->setField('comment', 0);
			$result = $record->commit();	
		}
	}

		if (isset($_GET['category'])) {
			$category = $_GET['category'];
		}
		else {
			$category = 'All';
		}
		if (isset($_GET['pageId'])) {
			$pid = $_GET['pageId'];
		$result = $blogobj->findData("blogComment", "recordId", $pid, $category);
	} else {
		$result = $blogobj->findData("blogComment", "recordId", 0, 'All');
	}
    $records = $result->getRecords();
	$maxRecords = $result->getFoundSetCount();
    $recordsCount = 0;
?>