<?php
// File: rankings.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once("includes/header.php");
 
// redirect if not logged in
if (!$logged)
  header("Location: login.php");

// we are giving null as the second parameter for the get method
// because we want to fetch all rows. If you set it to 2 it will fetch
// just the first two rows
$rankings = $db->orderBy("level", "desc")
               ->get("players", null, "player_id, username, level");

$templateVariables["player"]   = $player;
$templateVariables["rankings"] = $rankings;

$smarty->assign($templateVariables);
$smarty->display("rankings.tpl");