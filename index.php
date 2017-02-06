<?php
/*
* File    : index.php
* Purpose : Contains all html data and Php data for the 
* Created : 18-jan-2017
* Author  : Satyapriya Baral
*/
	session_start();
	//connecting to Filemaker database
	require_once "./config/config.php";
	$error = false;
	//If login button clicked
    if (isset($_POST['blog-btn']))
    {	
		$subject = mysql_real_escape_string($_POST['subject']);
        $author = mysql_real_escape_string($_POST['author']);
        $blogData = mysql_real_escape_string($_POST['blogData']);
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y/m/d");
		$time = date("h:i:sa");
		
		
		//check if the fields are entered
		if(strlen($subject) < 1)
		{
			$subjectError = 'Enter Subject of the Blog';
			$error = true;
		}
		if(strlen($author) < 1)
		{
			$authorError = 'Enter Author of the Blog';
			$error = true;
		}
		if(strlen($blogData) < 1)
		{
			$blogDataError = 'Enter data in the Blog';
			$error = true;
		}
	}
		if(!$error)
		{
			if (isset($_POST['blog-btn']))
			{
				$subject = mysql_real_escape_string($_POST['subject']);
				$author = mysql_real_escape_string($_POST['author']);
				$blogData = mysql_real_escape_string($_POST['blogData']);
				$record = $blogobj->create("blogComment");
				$record->setField('subject', $subject);
				$record->setField('author', $author);
				$record->setField('blog', $blogData);
				$record->setField('date', $date);
				$record->setField('time', $time);
				$result = $record->commit();
				if(!empty($result)) {
					$message = "You have registered successfully!";	
					unset($_POST);
				} else {
					$message = "Problem in registration. Try Again!";	
				}
			}
		}
	$PageTitle = "Login";
	include_once 'header.php';
?>
<body>

<div class="container">
	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal"
			data-target="#myModal">Add Blog</button>

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
							<input type="text" class="form-control" id="subject"
								   name="subject" placeholder="Subject">
							 <span class="spancolor" id="subject-error">
								<?php if(isset($subjectError)) {
									echo $subjectError; } ?> </span>
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
								<textarea class="form-control col-xs-12" rows="10"
										  name="blogData" id="blogData"
										  placeholder="Enter Data"></textarea>
								</br></br></br></br></br></br></br></br></br></br>
								 <span class="spancolor" id="blogData-error">
									<?php if(isset($blogDataError)) {
										echo $blogDataError; } ?> </span>
							</div>
					</div>
				<div class="modal-footer">
					<div class="form-group">
					<input type="submit" name="blog-btn" id="blog-submit"
						class="btn btn-default" value="Submit">
					</div>
				</div>
				</form>
			</div>  
		</div>
	</div>
</div>
<?php
	
	$records = $blogobj->findData("blogComment", "date");
    $recordsCount = 0;
		foreach($records as $record){
		?>
			<div class="container">
				<div class="jumbotron">
				<form id="details-form" action="" method="post">
					<div class="form-group">
					<label class="control-label col-sm-2" for="Subject" >Subject :</label>
						<div>
							<span class="spanPersonalInfo" id="user">
								<?php echo  $record->getField('subject');?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="Author" >Author :</label>
					<div>
						<span class="spanPersonalInfo" id="user">
							<?php echo  $record->getField('author');?>
					</div>
			</div>
			<div class="form-group">
			<label class="control-label col-sm-2" for="Date" >Date :</label>
				<div>
					<span class="spanPersonalInfo" id="user">
						<?php echo  $record->getField('date');?>
				</div>
			</div>
			<div class="form-group">
			<label class="control-label col-sm-2" for="time" >Time :</label>
				<div>
					<span class="spanPersonalInfo" id="user">
						<?php echo  $record->getField('time');?>
				</div>
			</div>
			<hr>
			<div class="form-group">
			<label class="control-label col-sm-2" for="Blog" >Blog :</label>
				<div>
					<span class="spanPersonalInfo" id="user">
						<?php echo  $record->getField('blog');?>
				</div>
			</div>
			<div class="form-group">
				<div>
					<a href=\"http://localhost/fm/delete.php?id=".$record->getrecordid()."\">Delete</a></td>
					<input type="submit" name="delete" id="delete"
					class="btn btn-danger" value="Delete">
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
<?php
include_once 'footer.php';
?>