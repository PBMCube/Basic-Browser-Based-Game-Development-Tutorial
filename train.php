<?php
// File: train.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once("includes/header.php");
 
// redirect if not logged in
if (!$logged)
  header("Location: login.php");

// I want to give players STR, INT and DEX when they train
// the stat_id's for them are: 5, 6 and 7.
// the array contains them in this format: stat_id => default_value
$statsToGive = array(5 => 4, 6 => 3, 7 => 2);

// we're going to multiple all the values with level/2 and take the int value of the result
// NOTICE the & means take by reference.
// when we edit $defaultValue we actually edit the value from $statsToGive
$levelFactor = intval($player["level"] / 2);

// make sure levelFactor is at least 1
$levelFactor = $levelFactor >= 1 ? $levelFactor : 1;

foreach ($statsToGive as $stat_id => &$defaultValue)
  $defaultValue = $defaultValue * $levelFactor;

// check if player has trained in the last 24 hours
// fetch (if exists) a train log of current player that was created
// within the last 24 hours
$check = $db->where("player_id", $player["player_id"])
            ->where("created", array(">" => time() - 24*60*60))
            ->getOne("player_train_logs", "created");

if (!isset($check["created"]))   
  $whenCanTrain = "now";
else
  $whenCanTrain = date("d/F/Y H:m:s", $check["created"] + 24*60*60);      

if ($_POST["train"] && $whenCanTrain == "now")
{
  foreach ($statsToGive as $stat_id => $value)
  {
    $statValue = getPlayerStat($player["player_id"], $stat_id);
    updatePlayerStat($player["player_id"], $stat_id, $statValue + $value);
  } // foreach

  $dataInsert = array("player_id" => $player["player_id"], "created" => time());
  $db->insert("player_train_logs", $dataInsert);
  
  header("Location: train.php");
} // if player wants to train

$templateVariables["whenCanTrain"] = $whenCanTrain;
$templateVariables["player"]       = $player;

$smarty->assign($templateVariables);
$smarty->display("train.tpl");