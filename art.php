<?php
include_once 'header.php';
session_start();
    //Connecting to Filemaker database
    require_once "./config/config.php";
    $rid = $_SESSION["rid"];
    $records = $blogobj->find("blogComment", $rid);
    foreach($records as $record){
        $title = $record->getField('subject');
        $author = $record->getField('author');
        $blog = htmlspecialchars_decode($record->getField('blog'));
        $date = $record->getField('date');
        $time = $record->getField('time');
        $comment = $record->getField('comment');
        $id = $record->getField('id');
        }
        $name = mysql_real_escape_string($_POST['name1']);
        $commentTab = htmlspecialchars_decode($_POST['comment1']);
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y/m/d");
        $time = date("h:i:sa");
                require_once ('filemakerapi/Filemaker.php');
                $fm = new FileMaker('blogComment', '172.16.9.62', 'admin', 'Baral@9439');
                $editRecord = $fm->newEditCommand('blogComment', $rid);
                $comment = $comment + 1;
                $editRecord->setField('comment', $comment);
                $result = $editRecord->execute();
                $record = $blogobj->create("comment");
                $record->setField('name', $name);
                $record->setField('commentData', $commentTab);
                $record->setField('date', $date);
                $record->setField('time', $time);
                $record->setField('fkId', $id);
                $result = $record->commit();
   /*  $records = $blogobj->find("blogComment", $rid);
    foreach($records as $record){
        $commentRecords= $record->getRelatedSet('comment');
        if (FileMaker::isError($commentRecords)) {
        } else {
                foreach($commentRecords as $commentRecord){
            
            if(($commentTab === htmlspecialchars_decode($commentRecord->getField('comment::commentData'))) &&
                 ($name === $commentRecord->getField('comment::name')) &&
                 ($date === $commentRecord->getField('comment::date')) &&
                 ($time === $commentRecord->getField('comment::time'))) {?>
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
    }*/
    include_once 'footer.php';
?>