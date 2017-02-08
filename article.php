<?php
/*
* File    : personal.php
* Purpose : Contains all html data and Php data for showing personal info
* Created : 20-jan-2017
* Author  : Satyapriya Baral
*/

    $PageTitle = "Home";
    include_once 'header.php';
    //require_once "./config/config.php";
    //Connecting to Filemaker database
    require_once ('filemakerapi/Filemaker.php');
    $fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
    //$records = $blogobj->find("blogComment", $id);
    $rid = $_GET['id'];
    $request = $fm->newFindCommand('blogComment');
    $request->addFindCriterion('recordId', $rid);
    $result = $request->execute();
       
    if (FileMaker::isError($result)) {
        $message = 'No Records Found'; 
    } else {
        $records = $result->getRecords();
        foreach($records as $record){
            $title = $record->getField('subject');
            $author = $record->getField('author');
            $blog = htmlspecialchars_decode($record->getField('blog'));
            $date = $record->getField('date');
            $time = $record->getField('time');
            $comment = $record->getField('comment');
            $id = $record->getField('id');
        }
    }
    //connecting to Filemaker database
    require_once "./config/config.php";
    $error = false;
       
    //If login button clicked
    if (isset($_POST['comment-btn']))
    {       
        $name = mysql_real_escape_string($_POST['name']);
        $commentTab = htmlspecialchars_decode($_POST['commentData']);
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y/m/d");
        $time = date("h:i:sa");

        //check if the fields are entered
        if(strlen($name) < 1)
        {
               $error = true;
        }
        if(strlen($commentTab) < 1)
        {
               $error = true;
        }
       }
        if(! $error)
        {
            if (isset($_POST['comment-btn']))
            {
                $editRecord = $fm->newEditCommand('blogComment', $rid);
                $comment = $comment + 1;
                $editRecord->setField('comment', $comment);
                $result = $editRecord->execute();
                $name = mysql_real_escape_string($_POST['name']);
                $commentTab = $_POST['commentData'];
                $record = $blogobj->create("comment");
                $record->setField('name', $name);
                $record->setField('commentData', $commentTab);
                $record->setField('date', $date);
                $record->setField('time', $time);
                $record->setField('fkId',$id);
                $result = $record->commit();
            }
        }  
    ?>
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
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                    data-target="#myModal">Add Comment</button>
                </div>
                <div class="col-sm-4"><b>No of Comments  : </b>
                    <?php if (isset($comment)) { echo $comment;}?></div>
            </div>
        </div>
    </div>
</div>
<?php
    $request = $fm->newFindCommand('blogComment');
    $request->addFindCriterion('recordId', $rid);
    $result = $request->execute();
       
    //Display Personal info
    if (FileMaker::isError($result)) {
        $message = 'No Records Found'; 
    } else {
        $records = $result->getRecords();
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
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-4"><b>Name  :
                                    </b><?php echo  $commentRecord->getField('comment::name');?></div>
                                <div class="col-sm-4"><b>Date  :
                                    </b><?php echo  $commentRecord->getField('comment::date');?></div>
                                <div class="col-sm-4"><b>Time  :
                                    </b><?php echo  $commentRecord->getField('comment::time');?></div>
                            </div>
                         </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12"><b>Comment  : </b>
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
    }
?>

    <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
 
    <!-- Modal content-->
        <div class="modal-content">
            <form id="comment-form" action="#" method="post" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Comment</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name"
                        name="name" placeholder="Name">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Comment"></label>
                        <textarea class="form-control col-xs-12 ckeditor" rows="5"
                            name="commentData" id="commentData"
                            placeholder="Comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" name="comment-btn" id="comment-submit"
                        class="btn btn-success" value="Comment">
                    </div>
                </div>
            </form>
        </div>  
    </div>
</div>
<?php
include_once 'footer.php';
?>