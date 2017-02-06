<?php
/*
* File    : index.php
* Purpose : Contains all html data and Php data for the 
* Created : 18-jan-2017
* Author  : Satyapriya Baral
*/
	session_start();
	//connecting to Filemaker database
    require_once ('filemakerapi/Filemaker.php');
	$fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
   $error = false;
	//If login button clicked
    if (isset($_POST['blog-btn']))
    {
		$subject = mysql_real_escape_string($_POST['subject']);
        $author = mysql_real_escape_string($_POST['author']);
        $blogData = mysql_real_escape_string($_POST['blogData']);
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
			$record = $fm->createRecord('blogComment');
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
			}}
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
							<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
							 <span class="spancolor" id="subject-error">
													<?php
													if(isset($subjectError)) {
														echo $subjectError;
													}
													?>
													</span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="author" name="author" placeholder="Author">
							 <span class="spancolor" id="author-error">
													<?php
													if(isset($authorError)) {
														echo $authorError;
													}
													?>
													</span>
						</div>
					</div>
					<div class="modal-body">
							<div class="form-group">
								<label for="Blog"></label>
								<textarea class="form-control col-xs-12" rows="10" name="blogData" id="blogData"
										  placeholder="Enter Data"></textarea>
								</br></br></br></br></br></br></br></br></br></br>
								 <span class="spancolor" id="blogData-error">
													<?php
													if(isset($blogDataError)) {
														echo $blogDataError;
													}
													?>
													</span>
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
<!--<div class="container">
		<div><span class="spancolor" id="name-error">
			<?php //if(isset($message)) echo $message; ?></span></div>
		<div class="table-responsive">
    <table  class="table table-striped table-bordered">
      <tr>
				<th>Added</th>
        <th>User</th>
        <th>Name</th>
        <th>Email</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th><span class="glyphicon glyphicon-remove"></span></th>
				<th><span class="glyphicon glyphicon-edit"></span></th>
      </tr>
		-->	
<?php
	
	//Connecting to Filemaker database
	require_once ('filemakerapi/Filemaker.php');
	$fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
     
	$request = $fm->newFindAllCommand('blogComment');
	$result = $request->execute();
	
	if (FileMaker::isError($result)) {
				$message = 'No Records Found'; 
			} else {
				$records = $result->getRecords();
				foreach($records as $record){
						echo  $record->getField('subject');
						echo  $record->getField('author');
						echo  $record->getField('date');
						echo  $record->getField('time');
						echo  $record->getField('blog');
					
					}
				}
?>
<?php
include_once 'footer.php';
?>