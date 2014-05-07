<?php
// File: warehouse.php
// Author: makingBrowserGames.com
// Basic Tutorial

require_once("includes/header.php");
 
must_login();
  
// include our items data
require_once("includes/constants/items.php");
// and make it available in the template
$templateVariables["items"] = $items;

// if user sent a valid item_id (anti-hack)
// and the requested item is of type usable in our constants
if (ctype_digit($_POST["use"]) && $items[$_POST["use"]]["usable"])
{
  // fetch user warehouse data for item $_POST["use"]
  $item = getPlayerWarehouseItem($_POST["use"]);

  if ($item["quantity"] > 0)
  {
    // this is where the magic happens
    // lets use the item
    // we need to increase user stats according to 
    // $items[$_POST["use"]]["stats"]

    foreach ($items[$_POST["use"]]["stats"] as $stat_id => $value)
    {
      $statValue = getPlayerStat($stat_id);
      updatePlayerStat($stat_id, $statValue + $value);
    } // foreach
    
    // now we need to remove 1 piece of this item from warehouse
    removeItemFromPlayerWarehouse($_POST["use"]);
    
    $success = "Used ".$items[$_POST["use"]]["name"];

  } // if use has at least one item of type $_POST["use"]
} // if use request
elseif (ctype_digit($_POST["wear"]) && $items[$_POST["wear"]]["wearable"])
{
  // fetch user warehouse data for item $_POST["use"]
  $item = getPlayerWarehouseItem($_POST["wear"]);

  if ($item["quantity"] > 0)
  {
    $stat = getPlayerStat($items[$_POST["wear"]]["wearable"]);
    
    // is player wearing something in slot $items[$_POST["wear"]]["wearable"] ?
    // if yes then add the item back to warehouse, it will be replaced by the new item
    if ($stat != 0)
      addItemToPlayerWarehouse($stat);
    
    // equip item
    updatePlayerStat($items[$_POST["wear"]]["wearable"], $_POST["wear"]);
    
    // now we need to remove 1 piece of this item from warehouse
    removeItemFromPlayerWarehouse($_POST["wear"]);
    
    $success = "Equipped ".$items[$_POST["wear"]]["name"];
    
  } // if use has at least one item of type $_POST["use"]
} // if wear request


// Get all items from warehouse
$warehouse = $db->where("player_id", $player["player_id"])->get("warehouse");

$firstWeapon  = getPlayerStat('f_weap');
$secondWeapon = getPlayerStat('s_weap');
$helmet       = getPlayerStat('helmet');
$armour       = getPlayerStat('armour');
$gloves       = getPlayerStat('gloves');
$boots        = getPlayerStat('boots');

$player["firstWeapon"]  = $firstWeapon   ? $items[$firstWeapon]   : null;
$player["secondWeapon"] = $secondWeapon  ? $items[$secondWeapon]  : null;
$player["helmet"]       = $helmet        ? $items[$helmet]        : null;
$player["armour"]       = $armour        ? $items[$armour]        : null;
$player["gloves"]       = $gloves        ? $items[$gloves]        : null;
$player["boots"]        = $boots         ? $items[$boots]         : null;

$templateVariables["warehouse"] = $warehouse;

$templateVariables["display"]   = "warehouse.tpl";
require_once("includes/footer.php");