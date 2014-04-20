<?php

// File: warehouse.php
// Author: makingBrowserGames.com
// Basic Tutorial

require_once("includes/header.php");
 
// redirect if not logged in
if (!$logged)
  header("Location: login.php");
  
// include our items data
require_once("includes/constants/items.php");
// and make it available in the template
$templateVariables["items"] = $items;

// if user sent a valid item_id (anti-hack)
// and the requested item is of type usable in our constants
if (ctype_digit($_POST["use"]) && $items[$_POST["use"]]["usable"])
{
  // fetch user warehouse data for item $_POST["use"]
  $item = getPlayerWarehouseItem($player["player_id"], $_POST["use"]);

  if ($item["quantity"] > 0)
  {
    // this is where the magic happens
    // lets use the item
    // we need to increase user stats according to 
    // $items[$_POST["use"]]["stats"]

    foreach ($items[$_POST["use"]]["stats"] as $stat_id => $value)
    {
      $statValue = getPlayerStat($player["player_id"], $stat_id);
      updatePlayerStat($player["player_id"], $stat_id, $statValue + $value);
    } // foreach
    
    // now we need to remove 1 piece of this item from warehouse
    removeItemFromPlayerWarehouse($player["player_id"], $_POST["use"]);
    
    $success = "Used ".$items[$_POST["use"]]["name"];

  } // if use has at least one item of type $_POST["use"]
} // if use request
elseif (ctype_digit($_POST["wear"]) && $items[$_POST["wear"]]["wearable"])
{
  // fetch user warehouse data for item $_POST["use"]
  $item = getPlayerWarehouseItem($player["player_id"], $_POST["wear"]);

  if ($item["quantity"] > 0)
  {
    $stat = getPlayerStat($player["player_id"], $items[$_POST["wear"]]["wearable"]);
    
    // is player wearing something in slot $items[$_POST["wear"]]["wearable"] ?
    // if yes then add the item back to warehouse, it will be replaced by the new item
    if ($stat != 0)
      addItemToPlayerWarehouse($player["player_id"], $stat);
    
    // equip item
    updatePlayerStat($player["player_id"], $items[$_POST["wear"]]["wearable"], $_POST["wear"]);
    
    // now we need to remove 1 piece of this item from warehouse
    removeItemFromPlayerWarehouse($player["player_id"], $_POST["wear"]);
    
    $success = "Equipped ".$items[$_POST["wear"]]["name"];
    
  } // if use has at least one item of type $_POST["use"]
} // if wear request


// Get all items from warehouse
$warehouse = $db->where("player_id", $player["player_id"])->get("warehouse");



$firstWeapon  = getPlayerStat($player["player_id"], 9);
$secondWeapon = getPlayerStat($player["player_id"], 10);
$helmet       = getPlayerStat($player["player_id"], 11);
$armour       = getPlayerStat($player["player_id"], 12);
$gloves       = getPlayerStat($player["player_id"], 13);
$boots        = getPlayerStat($player["player_id"], 14);

$player["firstWeapon"]  = $firstWeapon   ? $items[$firstWeapon]   : null;
$player["secondWeapon"] = $secondWeapon  ? $items[$secondWeapon]  : null;
$player["helmet"]       = $helmet        ? $items[$helmet]        : null;
$player["armour"]       = $armour        ? $items[$armour]        : null;
$player["gloves"]       = $gloves        ? $items[$gloves]        : null;
$player["boots"]        = $boots         ? $items[$boots]         : null;



$templateVariables["warehouse"] = $warehouse;
$templateVariables["player"]    = $player;
$templateVariables["error"]     = $error;
$templateVariables["success"]   = $success;

$smarty->assign($templateVariables);
$smarty->display("warehouse.tpl");
?>