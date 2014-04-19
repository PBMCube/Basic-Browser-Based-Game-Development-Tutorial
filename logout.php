<?php
 
// File: logout.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
session_start();
session_destroy();
header("Location: login.php");
 
?>