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
	
	//Getting record id of the record to be edited from the URL.
	$id = $_GET['id'];
	
	//Getting all the details of the blog by record id.
	$records = $blogobj->find("blogComment", $id);
	foreach($records as $record){
		$subject = $record->getField('subject');
		$author = $record->getField('author');
		$blog = $record->getField('blog');
	}
	
	$error = false;
	
	//If the Save button is clicked data are retrived from the form.
    if (isset($_POST['blog-btn']))
    {
		$title = $blogobj->Sanitize($_POST['title']);
        $author = $blogobj->Sanitize($_POST['author']);
        $content = $_POST['content'];
		
		//codes to select the timezone to get the date and time.
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");
				
		//check if the fields are entered
		if((strlen($title) < 1) || (strlen($author) < 1) || (strlen($content) < 1))
		{
			$message ='Please fill all the fields';
			$error = true;
		}
	}
	
	//If all the fields are filled and no error is there
		if(!$error)
		{
			if (isset($_POST['blog-btn']))
			{
				
				//Edit command to store all the data in the database.
				$title = $blogobj->Sanitize($_POST['title']);
				$author = $blogobj->Sanitize($_POST['author']);
				$content = $_POST['content'];
				$blogobj->editArticle('blogComment', $id, $title, $author, $content, $date, $time);
				
				//After editing redirect to the Home page
				header("Location: index.php");
			}
		}

	$PageTitle = "Update";
	include_once 'header.php';
?>

<!--Navbar to go to the home page-->
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
	
	<!--Php and HTML codes to make the edit form-->
	<div class= "container">
		<form id="blog-form" action="#" method="post" role="form">
			<div><span class="spancolor" id="name-error">
				<?php if(isset($message)) echo $message; ?></span></div>
					<div class="form-group">
						<b>Title : </b></br>
						<input type="text" class="form-control" id="title"
							name="title" value="<?php if(isset($subject))
							{ echo $subject; } ?>">
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