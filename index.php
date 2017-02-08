<?php
/*
* File    : index.php
* Purpose : Contains all html data and Php data for the blog display and create. 
* Created : 06-Feb-2017
* Author  : Satyapriya Baral
*/
	session_start();
	//connecting to Filemaker database
	require_once "./config/config.php";
	$error = false;
	
	//If login button clicked
    if (isset($_POST['blog-btn']))
    {	
		$title = mysql_real_escape_string($_POST['title']);
        $author = mysql_real_escape_string($_POST['author']);
        $content = ($_POST['content']);
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");

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
			$record->setField('comment', 0);
			$result = $record->commit();
			
		}
	}
	$PageTitle = "Login";
	include_once 'header.php';
?>
<body>
	<div class="container">
	<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal"
		data-target="#myModal">Add Post</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">
 
		<!-- Modal content-->
				<div class="modal-content">
					<form id="blog-form" action="#" method="post" role="form">
					<div><span class="spancolor" id="name-error">
					<?php if(isset($message)) echo $message; ?></span></div>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Blog</h4>
						<div class="form-group">
							<input type="text" class="form-control" id="title"
							name="title" placeholder="Title">
							<span class="spancolor" id="title-error">
							<?php if(isset($titleError)) {
							echo $titleError; } ?> </span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="author"
							name="author" placeholder="Author">
							<span class="spancolor" id="author-error">
							<?php if(isset($authorError)) {
							echo $authorError;}?></span>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="Blog"></label>
							<textarea class="form-control col-xs-12 ckeditor" name="content"rows="10"
								name="content" id="content"
								placeholder="Content"></textarea>
								<span class="spancolor" id="content-error">
								<?php if(isset($contentError)) {
								echo $contentError; } ?> </span>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" name="blog-btn" id="blog-submit"
							class="btn btn-success" value="Publish">
						</div>
					</div>
				</form>
			</div>  
		</div>
	</div>
</div>

<?php

	if (isset($_GET['pageId'])) {
		$pid = $_GET['pageId'];
		$result = $blogobj->findData("blogComment", "recordId", $pid);
	} else {
		$result = $blogobj->findData("blogComment", "recordId", 0);
	}
    $records = $result->getRecords();
	$maxRecords = $result->getFoundSetCount();
    $recordsCount = 0;
	foreach($records as $record) {
?>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center><h2><?php
				$sub = $record->getField('subject');
				echo "<a href=\"http://localhost/fm/article.php?id=
				".$record->getrecordid()."\">$sub</a>";?></h2></center>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-4"><b>Author  :
						</b><?php echo  $record->getField('author');?>
					</div>
					<div class="col-sm-4"><b>Date  :
						</b><?php echo  $record->getField('date');?>
					</div>
					<div class="col-sm-4"><b>Time  :
						</b><?php echo  $record->getField('time');?>
					</div>
					<hr>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?php
							$contentBlog = htmlspecialchars_decode($record->getField('blog'));						
							if(strlen($contentBlog) <= 300) {
								echo $contentBlog;
							} else {
								$partContent=substr($contentBlog,0,300) . '...';
								echo $partContent;
							}
						?>
					</div>
				<div class="row">
					<div class="col-sm-4">
						<b><?php 
						?><a style="color:blue;" href="http://localhost/fm/article.php?id=
						<?php echo  $record->getrecordid(); ?>">Readmore....</a></b>
					</div>
				</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4"><button class="btn btn-danger">
						<?php echo "<a href=\"http://localhost/fm/delete.php?id=
						".$record->getrecordid()."\">Delete</a>";?></button>
					</div>
					<div class="col-sm-4"><b>No of Comments  : </b>
						<?php echo  $record->getField('comment');?>
					</div>
					<div class="col-sm-4"><button class="btn btn-warning">
						<?php echo "<a href=\"http://localhost/fm/edit.php?id=
						".$record->getrecordid()."\">Edit</a>";?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	$test=ceil($maxRecords/2);
	$test1=floor($maxRecords/2);
?>
<div class="container">
	<ul class="pagination pagination-lg">
		<?php for($i=0 ;$i< $test ;$i++) { $sendId = $i * 2 ; $k = $i+1 ; ?>
		<li><?php echo "<a href=\"http://localhost/fm/index.php?pageId=".$sendId."\">$k</a>";?></li>
		<?php } ?>
	</ul>
</div>
<?php
	include_once 'footer.php';
?>