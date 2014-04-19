<?php
// File: index.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once('includes/header.php');
 
// redirect if not logged in
if (!$logged)
  header('Location: login.php');


$player['health']    = getPlayerStat($player['player_id'], 1);
$player['maxHealth'] = getPlayerStat($player['player_id'], 2);
$player['energy']    = getPlayerStat($player['player_id'], 3);
$player['maxEnergy'] = getPlayerStat($player['player_id'], 4);
$player['str']       = getPlayerStat($player['player_id'], 5);
$player['dex']       = getPlayerStat($player['player_id'], 6);
$player['int']       = getPlayerStat($player['player_id'], 7);
$player['money']     = getPlayerStat($player['player_id'], 8);

$player['pet']       = getPlayerStat($player['player_id'], 15);
if ($player['pet'])
{
  require_once('includes/constants/items.php');
  $player['pet'] = $items[$player['pet']];
} // if pet

$templateVariables['player'] = $player;

$smarty->assign($templateVariables);
$smarty->display('index.tpl');