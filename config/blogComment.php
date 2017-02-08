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
        //----- Initialize function -----
        public function initDB($db, $host, $user, $pass)
        {
            $this->databaseName = $db;
            $this->hostName = $host;
            $this->userName = $user;
            $this->password = $pass;
        }
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
        public function findData($layout, $sortR, $page)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            $request = $this->connection->newFindAllCommand($layout);
            $request->addSortRule($sortR, 1, FILEMAKER_SORT_DESCEND);
            $request->setRange($page,2);
            $result = $request->execute();
            if (FileMaker::isError($result)) {
                $this->writeLog("Error in executing findData method", $this->errorFile);
                return false;
            }
            $this->writeLog("Data Fetch Successful!", $this->logFile);
            return $result;
        }
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
        public function create($layout)
        {
            if (!$this->DBLogin()) {
                $this->writeLog("Error in database connection", $this->errorFile);
                return false;
            }
            return $this->connection->createRecord($layout);
        }
        
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
        //----- Helper Methods -----
        public function writeLog($str, $fileName)
        {
            date_default_timezone_set($this->timeZone);
            $dateTime = date("Y-m-d h:i:sa");
            error_log("[".$dateTime."]-".$str."\n", 3, $fileName);
        }
    }
 ?>