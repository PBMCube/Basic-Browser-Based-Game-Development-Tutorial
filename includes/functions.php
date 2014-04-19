<?php

function levelExperience($level)
{
  return $level * 50;
} // levelExperience

function addExperience($experience)
{
  // use the global $player and $db variables
  global $player, $db;
  
  $player["exp"] += $experience;

  // who knows how much experience you've tried to add
  // maybe multiple lvl-ups are in order
  // so we will keep checking if we need to level up
  // until current exp is lower than the exp required
  // for the next level

  while ($player["exp"] >= $player["expNext"])
  {
    // pre-increment level | faster than post-incrementation
    // just a small tip & trick ;)

    ++$player["level"];
    
    $player["exp"] -= $player["expNext"];  
 
    $player["expNext"] = levelExperience($player["level"] + 1);
  
    
  } // if level up

  $updateData = array(
    "exp" => $player["exp"],
    "expNext" => $player["expNext"],
    "level" => $player["level"],
  );

  $db->where("player_id", $player["player_id"])->update("players", $updateData);
}

function getPlayerStat($player_id, $stat_id)
{
  global $db;
  $stat = $db->where("player_id", $player_id)
             ->where("stat_id", $stat_id)
             ->getOne("player_stats", "value");
             
  if (isset($stat["value"]))
    return $stat["value"];

  // this part is executed only if the return statement above
  // is never reached
  $insertData = array(
    "player_id" => $player_id,
    "stat_id" => $stat_id
  );
  $db->insert("player_stats", $insertData);
  
  return 0;
} // getPlayerStat

function updatePlayerStat($player_id, $stat_id, $value)
{
  global $db;
  
  // use getPlayerStat to create the row if it doesn't exist
  getPlayerStat($player_id, $stat_id);
  
  $updateData = array("value" => $value);

  // update the one row matching player_id, stat_id
  // with the given value
  $db->where("player_id", $player_id)
     ->where("stat_id", $stat_id)
     ->update("player_stats", $updateData, 1);
  
} // updatePlayerStat

// return data from warehouse given player_id
// and item_id
function getPlayerWarehouseItem($player_id, $item_id)
{
  global $db;
  return $db->where("player_id", $player_id)
            ->where("item_id", $item_id)
            ->getOne("warehouse", "quantity");
} // getPlayerWarehouseItem

// Can receive 2 or 3 parameters
// player_id, item_id and optional quantity
// if quantity not give it defaults to 1
function addItemToPlayerWarehouse($player_id, $item_id, $quantity = 1)
{
  global $db;
  
  $item = getPlayerWarehouseItem($player_id, $item_id);
  
  if (isset($item["quantity"]))
  {
    $updateData = array("quantity" => $item["quantity"] + $quantity);

    $db->where("player_id", $player_id)
       ->where("item_id", $item_id)
       ->update("warehouse", $updateData);

    // terminate function execution
    return;
  } // if player already owns one or more items of type item_id

  // if we reached this line, it means user does not own
  // current type of item_id
  $dataInsert = array(
    "item_id" => $item_id,
    "player_id" => $player_id,
    "quantity" => $quantity
  );

  $db->insert("warehouse", $dataInsert);
} // addItemToPlayerWarehouse

function removeItemFromPlayerWarehouse($player_id, $item_id, $quantity = 1)
{
  global $db;
  // use a trick and give negative quantity to the adding function
  // this will decrease since it will be quantity + (-another_quantity)
  addItemToPlayerWarehouse($player_id, $item_id, -$quantity);
 
  // now simply check if new quantity is <= 0
  $item = getPlayerWarehouseItem($player_id, $item_id);
  
  // if it is <= 0, remove the row from database, since the user no longer
  // has this item
  if ($item["quantity"] <= 0)
    $db->where("player_id", $player_id)->where("item_id", $item_id)
       ->delete("warehouse", 1);
} //  removeItemFromPlayerWarehouse


function computeStatsForBattle($player_id)
{
  $thePlayer["strength"] = getPlayerStat($player_id, 5);
  $INT                   = getPlayerStat($player_id, 6);
  $DEX                   = getPlayerStat($player_id, 7);
  $health                = getPlayerStat($player_id, 1);
  
  // stat_id's for all equipment components
  $equipment = array(9, 10, 11, 12, 13, 14);
  require_once("includes/constants/items.php");
  
  // go through each type of equipment, check if user is wearing
  // and add stats that matter
  foreach ($equipment as $piece)
  {
    $item = getPlayerStat($player_id, $piece);
    if ($item)
    {
      $thePlayer["strength"] += $items[$item]["stats"][5];
      $INT                   += $items[$item]["stats"][6];
      $DEX                   += $items[$item]["stats"][7];
      $health                += $items[$item]["stats"][1];
    } // if is wearing something in slot $stat
  } // foreach $equipment


  /* Get player strength and health and compute defense as dex + int / 2 */
  
  $thePlayer["defense"] = $DEX + intval($INT / 2);
  $thePlayer["health"] = $health;

  return $thePlayer;
} // computeStatsForBattle