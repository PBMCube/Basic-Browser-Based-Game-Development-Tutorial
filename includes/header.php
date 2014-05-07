<?php
// File: header.php
// Author: makingbrowsergames.com
// Basic Tutorial

require('includes/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('layout/templates');
$smarty->setCompileDir('includes/smarty/templates_c');
$smarty->setCacheDir('includes/smarty/cache');
$smarty->setConfigDir('includes/smarty/configs');
 
require_once('db_config.php');
require_once('MysqliDb.php');
$db = new Mysqlidb($host, $user, $password, $dbname);
 
session_start();
 
$logged = false;
 
if (isset($_SESSION["player_id"]))
{
  $player = $db->where("player_id", $_SESSION["player_id"])
               ->getOne("players", "level, exp, expNext, username, player_id");
  $logged = true;
} // if logged in

$templateVariables["logged"] = $logged;

require_once("functions.php");