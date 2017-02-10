<?php
/*
* File    : article.php
* Purpose : Contains all html data and Php data for showing the full article
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/
    session_start();
    $PageTitle = "Home";
    include_once 'header.php';
    //Connecting to Filemaker database
    require_once "./config/config.php";
    $rid = $_GET['id'];
    $_SESSION["rid"] = $rid;
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
    //connecting to Filemaker database
    require_once "./config/config.php";
    $error = false;
       
    ?>
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
                <div class="col-sm-12"><b>Content  : </b>
                    <?php if (isset($blog)) { echo $blog;}?>
                </div>
            </div>
        </div>
    </div>
</div>
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
<?php
    $records = $blogobj->find("blogComment", $rid);
    foreach($records as $record){
        $commentRecords= $record->getRelatedSet('comment');
        if (FileMaker::isError($commentRecords)) {
        } else {
            ?>
            <div class="container">
                <b><h3>COMMENTS  :</h3></b>
            </div>
            <?php
                foreach($commentRecords as $commentRecord){
            ?>
            <div class="container">
                <div class="well  col-xs-8">
                        <div class="row">
                            <div class="col-sm-4"><b>Name  :
                                </b><?php echo  $commentRecord->getField('comment::name');?></div>
                            <div class="col-sm-4"><b>Date  :
                                </b><?php echo  $commentRecord->getField('comment::date');?></div>
                            <div class="col-sm-4"><b>Time  :
                                </b><?php echo  $commentRecord->getField('comment::time');?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8"><b>Comment  : </b>
                            <?php
                                $commentData = htmlspecialchars_decode($commentRecord->getField('comment::commentData'));
                                echo $commentData
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
        }
    }
?>
<div id="output"></div>
<?php
include_once 'footer.php';
?>