<?php
// File: shop.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once("includes/header.php");
 
must_login();

require_once("includes/constants/items.php");

if ($_POST["buy"] && isset($items[$_POST["buy"]]["price"]))
{
  // fetch player curency balance
  $playerMoney = getPlayerStat($player["player_id"], 8);
  
  // and check if he has enough to purchase item
  if ($items[$_POST["buy"]]["price"] <= $playerMoney)
  {
    $playerMoney -= $items[$_POST["buy"]]["price"];
    updatePlayerStat(8, $playerMoney);
    
    addItemToPlayerWarehouse($_POST["buy"]);
    
    $success = "Item bought";
  } // if player has enough money
  else 
    $error = "Not enough currency";
} // if buy request received and item can be bought

$templateVariables["items"]    = $items;

$templateVariables["display"] = "shop.tpl";
require_once("includes/footer.php");