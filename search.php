<?php
/*
* File    : search.php
* Purpose : Contains all Php and html code to get the searched result
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

    require_once "./config/config.php";
	$error = false;
    $articleName = htmlspecialchars_decode($_POST['articleName']);
	$records = $blogobj->findArticle("blogComment",$articleName);
	$PageTitle = "Blog";
	include_once 'header.php';
    if (FileMaker::isError($records)) {
        echo "Sorry No Records Found";
    }
    else {
    foreach($records as $record){
    ?>
    <div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center><h2><?php
				$sub = htmlspecialchars_decode($record->getField('subject'));
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
    }}
	include_once 'footer.php';
?>