<?php
// File: shop.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once("includes/header.php");
 
// redirect if not logged in
if (!$logged)
  header("Location: login.php");

require_once("includes/constants/items.php");

if ($_POST["buy"] && isset($items[$_POST["buy"]]["price"]))
{
  // fetch player curency balance
  $playerMoney = getPlayerStat($player["player_id"], 8);
  
  // and check if he has enough to purchase item
  if ($items[$_POST["buy"]]["price"] <= $playerMoney)
  {
    $playerMoney -= $items[$_POST["buy"]]["price"];
    updatePlayerStat($player["player_id"], 8, $playerMoney);
    
    addItemToPlayerWarehouse($player["player_id"], $_POST["buy"]);
    
    $success = "Item bought";
  } // if player has enough money
  else 
    $error = "Not enough currency";
} // if buy request received and item can be bought

$templateVariables["error"]    = $error;
$templateVariables["success"]  = $success;
$templateVariables["items"]    = $items;
$templateVariables["player"]   = $player;

$smarty->assign($templateVariables);
$smarty->display("shop.tpl");