<?php
    class LoginForm {
        //-------- Functions for regular actions ---------
        function redirectToURL($url){
            header("Location: $url");
            exit;
        }
        function selfScriptCall () {
            return htmlentities($_SERVER['PHP_SELF']);
        }
    }
    $logobj = new loginForm();
 ?>