<?php
    /*
     * File Name: blogComment.php
     * Created By: Satyapriya Baral
     * Used For: Blog Comment creation and functionality addition.
     * Description: Creation of blogComment object for the application.
     */
    require_once ('filemakerapi/Filemaker.php');
    
    class BlogComment
    {
        public $connection;
        public $databaseName;
        public $hostName;
        public $userName;
        public $password;
        public $errorFile;
        public $logFile;
        public $timeZone;
        function __construct()
        {
            $this->connection = null;
            $this->errorFile = __DIR__."\..\log\logError.log";
            $this->logFile = __DIR__."\..\log\logResult.log";
            $this->timeZone = "Asia/Kolkata";
        }
        
        /**
        * Function to get database criteria.
        *
        * @param 1. $db - contains the database name.
        *        2. $host - contains the host name to be connected.
        *        3. $user - contains the username of the host.
        *        4. $pass - contains the password of the user.
        * @return null.
        */
        public function initDB($db, $host, $user, $pass)
        {
            $this->databaseName = $db;
            $this->hostName = $host;
            $this->userName = $user;
            $this->password = $pass;
        }
        
        /**
        * Function to connect to the Filemaker Database.
        *
        * @param null.
        * @return - boolian value of the connection made or not.
        */
        public function DBLogin()
        {
            $this->connection = new FileMaker($this->databaseName, $this->hostName, $this->userName, $this->password);
            if (FileMaker::isError($this->connection)) {
                $this->writeLog("Can't connect to database",$this->errorFile);
                return false;
            }
            $this->writeLog("Connection Successful!", $this->logFile);
            return true;
        }
        
        //----- CRUD Operations -----
        /**
        * Function to search the data by its soring order.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $sortR - contains the sorting order of data.
        *        3. $page - contains the index of the page to be displayed.
        *        4. $category - contains the category details according to which to be searched.
        * @return - Filemaker results of data found.
        */
        public function findData($layout, $sortR, $page ,$category)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            if($category === 'Sports') { $categoryIndex = 2; }
            elseif($category === 'Education') { $categoryIndex = 3; }
            elseif($category === 'Politics') { $categoryIndex = 4; }
            $request = $this->connection->newFindCommand($layout);
            $request->addSortRule($sortR, 1, FILEMAKER_SORT_DESCEND);
            if($category != 'All')
            {
                $request->addFindCriterion('category',$categoryIndex);
            }
            $request->setRange($page,2);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            $this->writeLog("Data Fetch Successful!", $this->logFile);
            return $result;
        }
        
        /**
        * Function to find the data by its record.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $id - contains the record id of which to be found.
        * @return - Filemaker results of data found.
        */
        public function find($layout, $id)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $request = $this->connection->newFindCommand($layout);
            $request->addFindCriterion('recordId', $id);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            $this->writeLog("Data Fetch Successful!", $this->logFile);
            return $result->getRecords();;
        }
        
        /**
        * Function to search the data by its article name.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $articleName - contains the name of article to be searched.
        * @return - Filemaker results of data found.
        */
        public function findArticle($layout, $articleData)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $request = $this->connection->newFindCommand($layout);
            $request->addFindCriterion('author', $articleData);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            else {
                $this->writeLog("Data Fetch Successful!", $this->logFile);
                return $result->getRecords();
            }
        }
        
        public function findArticleContent($layout, $articleData)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $request = $this->connection->newFindCommand($layout);
            $request->addFindCriterion('subject', $articleData);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            else {
                $this->writeLog("Data Fetch Successful!", $this->logFile);
                return $result->getRecords();
            }
        }
        
        /**
        * Function to comment that to be displayed.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $id - contains the primary key of blogComment layout.
        * @return - Filemaker results of data found.
        */
        public function findComment($layout, $id)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $request = $this->connection->newFindCommand($layout);
            $request->addFindCriterion('fkId', $id);
            $request->addSortRule('commentRecordId', 1, FILEMAKER_SORT_DESCEND);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            $this->writeLog("Data Fetch Successful!", $this->logFile);
            return $result->getRecords();;
        }
        /**
        * Function to create a record.
        *
        * @param 1. $layout - data required to get the layout name.
        * @return - Filemaker results for record creation.
        */
        public function create($layout)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            return $this->connection->createRecord($layout);
        }
        
        /**
        * Function to delete a record by its record id.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $id - contains record id of the record to be deleted.
        * @return - Filemaker results of deleted record.
        */
        public function deleteRecord($layout, $id)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $delcmd = $this->connection->newDeleteCommand($layout, $id);
            $retvar = $delcmd->execute();
            if (FileMaker::isError($retvar)) {
                $this->writeLog("Error in deleting the file", $this->errorFile);
                return false;
            }
            $this->writeLog("Deletion Successful!", $this->logFile);
            return $retvar;
        }
        
        /**
        * Function to edit a record by its record id.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $id - contains record id of the record to be deleted.
        *        3. $comment - contains the data of no of comments in the record.
        * @return - Null.
        */
        public function editRecord($layout, $id, $comment)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $editcmd = $this->connection->newEditCommand($layout, $id);
            $comment = $comment + 1;
            $editcmd->setField('comment', $comment);
            $retvar = $editcmd->execute();
            if (FileMaker::isError($retvar)) {
                $this->writeLog("Error in editing the file", $this->errorFile);
                return false;
            }
            $this->writeLog("Edit Successful!", $this->logFile);
        }
        
        /**
        * Function to edit a Article by its record id.
        *
        * @param 1. $layout - data required to get the layout name.
        *        2. $id - contains record id of the record to be deleted.
        *        3. $title - contains data of the title of the blog.
        *        4. $author - contains name of the author.
        *        5. $content - contains the blog data.
        *        6. $date - contains the date when the blog is posted.
        *        7. $time - contains the time when the blog is posted.
        * @return - Null.
        */
        public function editArticle($layout, $id, $title, $author, $content, $date, $time)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $editRecord = $this->connection->newEditCommand($layout, $id);
            $editRecord->setField('subject', $title);
			$editRecord->setField('author', $author);
			$editRecord->setField('blog', $content);
			$editRecord->setField('date', $date);
			$editRecord->setField('time', $time);
			$result = $editRecord->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in editing the file", $this->errorFile);
                return false;
            }
            $this->writeLog("Edit Successful!", $this->logFile);
        }
        //----- Helper Methods -----
        /**
        * Function to log the errors and success in a text document.
        *
        * @param 1. $str - data that to be written in text document.
        *        2. $filename - contains filename where the data will be written.
        * @return null.
        */
        public function writeLog($str, $fileName)
        {
            date_default_timezone_set($this->timeZone);
            $dateTime = date("Y-m-d h:i:sa");
            error_log("[".$dateTime."]-".$str."\n", 3, $fileName);
        }
        
        /**
        * Function to sanitize the value that will be stored in the database.
        *
        * @param 1. $value - contains the value to be sanitized.
        * @return - Returns the value after sanitizing.
        */
        public function Sanitize($value)
        {
            $retvar = trim($value);
            $retvar = strip_tags($retvar);
            $retvar = htmlspecialchars($retvar);
            return $retvar;
        }
    }
 ?>