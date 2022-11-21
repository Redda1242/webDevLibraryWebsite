<?php
//if session is not set , start session
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

//if account is not set, means user did not login and is redirected to LOGIN page
if(!isset($_SESSION["account"]))
{
	header('Location:Login.php');
}
?>