<?php
if (isset($_POST['blog-btn']))
    {	
		$title = mysql_real_escape_string($_POST['title']);
        $author = mysql_real_escape_string($_POST['author']);
        $content = ($_POST['content']);
		$category = ($_POST['category']);
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");
		
		if($category === 'All') { $catNum = 1; }
		elseif($category === 'Sports') { $catNum = 2; }
		elseif($category === 'Education') { $catNum = 3; }
		elseif($category === 'Politics') { $catNum = 4; }
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
			$record->setField('category', $catNum);
			$record->setField('comment', 0);
			$result = $record->commit();
			
		}
	}

?>