<?php
/*
* File    : article.php
* Purpose : Contains all html data and Php data for showing the full article
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/
    session_start();
    $PageTitle = "Article";
	
	//contains all the HTML header codes.
    include_once './include/header.php';
	
    //Connecting to Filemaker database
    require_once "./config/config.php";
	
	//Record id is retrived from the URL
    $rid = $_GET['id'];
    $_SESSION["rid"] = $rid;
	
	//The record of the article is collected by its record id from the database
    $records = $blogobj->find("blogComment", $rid);
    foreach($records as $record){
        $title = $record->getField('subject');
        $author = $record->getField('author');
        $blog = htmlspecialchars_decode($record->getField('blog'));
        $date = $record->getField('date');
        $time = $record->getField('time');
        $comment = $record->getField('comment');
        $id = $record->getField('id');
        $_SESSION["id"] = $id;
    }
	
    $error = false;
       
    ?>
	
	<!--Navbar to get back to the home page-->
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
		</div>
		<ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		</ul>
	</div>
</nav>

<!--Data of the article are shown in the panel here-->
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <center><h2><?php if (isset($title)) { echo $title;}?></h2></center>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4"><b>Author  :
                    </b><?php if (isset($author)) { echo $author;}?></div>
                <div class="col-sm-4"><b>Date  :
                    </b><?php if (isset($date)) { echo $date;}?></div>
                <div class="col-sm-4"><b>Time  :
                    </b><?php if (isset($time)) { echo $time;}?></div>
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($blog)) { echo $blog;}?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Codes for making text area for comments and on click submit will make a Ajax call-->
<div class="container">
    <form id="comment-form" action="#" method="post" role="form">
        <div class="well  col-xs-8">
            <div class="row ">  
                <div class=" row col-xs-12">
                    <input class="form-control" id="name" type="text" placeholder="Comment As">
                </div>
            </div>
            <!--</div>-->
            <div class="row">
                <div class=" row col-xs-12">
                    <label for="Comment"></label>
                    <textarea class="form-control " rows="5"
                        name="commentData" id="commentData"
                        placeholder="Comment"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <input id="submit" type="button" value="Comment">
                </div>
            </div>
        </div>
    </form> 
</div>

<!--Codes for displaying the comments-->
<div id="commentSection">
<?php

    $records = $blogobj->findComment("comment", $id);
	
	if (! $records) {
    }
	else {
    ?>
    <div class="container">
        <b><h3>COMMENTS  :</h3></b>
    </div>
    <?php
    foreach($records as $record) {
        ?>
        <div class="container">
            <div class="well  col-xs-8">
                <div class="row">
                    <div class="col-sm-4"><b>Name  :
                        </b><?php echo  $record->getField('name');?></div>
                    <div class="col-sm-4"><b>Date  :
                        </b><?php echo  $record->getField('date');?></div>
                    <div class="col-sm-4"><b>Time  :
                        </b><?php echo  $record->getField('time');?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8"><b>Comment  : </b>
                        <?php
                            $commentData = htmlspecialchars_decode($record->getField('commentData'));
                            echo $commentData
                        ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
    }
}
?>
</div>

<!--Spinner implemented by ajax-->
<div class="preload">
	<img src="spinner.gif"/>
</div>

<!--After Ajax call the comments are displayed here-->
<div id="output"></div>
<?php
include_once './include/footer.php';
?>