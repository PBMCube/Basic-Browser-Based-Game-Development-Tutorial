<?php
// File: index.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once('includes/header.php');
 
must_login();

$player['health']    = getPlayerStat('health');
$player['maxHealth'] = getPlayerStat('health_max');
$player['energy']    = getPlayerStat('energy');
$player['maxEnergy'] = getPlayerStat('energy_max');
$player['str']       = getPlayerStat('str');
$player['dex']       = getPlayerStat('dex');
$player['int']       = getPlayerStat('int');
$player['money']     = getPlayerStat('money');

$player['pet']       = getPlayerStat('pet');
if ($player['pet'])
{
  require_once('includes/constants/items.php');
  $player['pet'] = $items[$player['pet']];
} // if pet

$templateVariables["display"] = "index.tpl";
require_once("includes/footer.php");