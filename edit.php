<?php
/*
* File    : edit.php
* Purpose : Contains all Php code to update the database
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

	session_start();
	
	//Connecting to Filemaker Database
	require_once "./config/config.php";
	
	$id = $_GET['id'];
	$records = $blogobj->find("blogComment", $id);
	foreach($records as $record){
		$subject = $record->getField('subject');
		$author = $record->getField('author');
		$blog = $record->getField('blog');
	}
	$error = false;
	//If login button clicked
    if (isset($_POST['blog-btn']))
    {
		$title = $blogobj->Sanitize($_POST['title']);
        $author = $blogobj->Sanitize($_POST['author']);
        $content = $blogobj->Sanitize($_POST['content']);
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");
				
		//check if the fields are entered
		if(strlen($title) < 1)
		{
			$titleError = 'Enter Title of the Blog';
			$error = true;
		}
		if(strlen($author) < 1)
		{
			$authorError = 'Enter Author of the Blog';
			$error = true;
		}
		if(strlen($content) < 1)
		{
			$contentError = 'Enter data in the Blog';
			$error = true;
		}
	}
		if(!$error)
		{
			if (isset($_POST['blog-btn']))
			{
				require_once ('config/filemakerapi/Filemaker.php');
				$fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
				$title = $blogobj->Sanitize($_POST['title']);
				$author = $blogobj->Sanitize($_POST['author']);
				$content = $blogobj->Sanitize($_POST['content']);
				$editRecord = $fm->newEditCommand('blogComment', $id);
				$editRecord->setField('subject', $title);
				$editRecord->setField('author', $author);
				$editRecord->setField('blog', $content);
				$editRecord->setField('date', $date);
				$editRecord->setField('time', $time);
				$result = $editRecord->execute();
				header("Location: index.php");
			}
		}

	$PageTitle = "Update";
	include_once 'header.php';
?>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
			</div>
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li></li>
				<li></li>
			</ul>
		</div>
</nav>
	<div class= "container">
	<form id="blog-form" action="#" method="post" role="form">
					<div><span class="spancolor" id="name-error">
					<?php if(isset($message)) echo $message; ?></span></div>
						<div class="form-group">
							<b>Title : </b></br>
							<input type="text" class="form-control" id="title"
								   name="title" value="<?php if(isset($subject))
						{ echo $subject; } ?>">
							 <span class="spancolor" id="title-error">
								<?php if(isset($titleError)) {
									echo $titleError; } ?> </span>
						</div>
						<div class="form-group">
							<b>Author : </b></br>
							<input type="text" class="form-control" id="author"
								   name="author" value="<?php if(isset($author))
						{ echo $author; } ?>">
							 <span class="spancolor" id="author-error">
								<?php if(isset($authorError)) {
									echo $authorError;}?></span>
						</div>
							<div class="form-group">
								<label for="Blog"></label>
								<b>Content : </b></br>
								<textarea class="form-control col-xs-12" rows="18"
										  name="content" id="content"
										><?php if(isset($blog))
						{ echo $blog; } ?></textarea>
								 <span class="spancolor" id="content-error">
									<?php if(isset($contentError)) {
										echo $contentError; } ?> </span>
					</div>
					<div class="form-group">
					<input type="submit" name="blog-btn" id="blog-submit"
						class="btn btn-success" value="Save">
					</div>
				</form>
	</div>
<?php
include_once 'footer.php';
?>