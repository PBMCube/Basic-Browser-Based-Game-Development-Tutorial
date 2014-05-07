<?php

// redirect user to a certain URL
function do_redirect($location)
{
	header('Location: '.$location);
} // do_redirect

// check if user is logged in
function must_login()
{
	global $logged;
	// redirect if not logged in
	if (!$logged)
		do_redirect("login.php");
} // must_login

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

function getPlayerStat($stat_id, $player_id = null)
{
  global $db, $player;
  
  if (!$player_id) $player_id = $player["player_id"];
  
  // shortname provided?
  if (!ctype_digit((string)$stat_id))
  {
  	$stat = $db->where("short", $stat_id)->getOne("stats", "stat_id");
  	$stat_id = $stat["stat_id"];
  }
  
  $stat = $db->where("player_id", $player_id)
             ->where("stat_id", $stat_id)
             ->getOne("player_stats", "value");
             
  if (isset($stat["value"]))
    return $stat["value"];

  // this part is executed only if the return statement above is not
  $insertData = array(
    "player_id" => $player_id,
    "stat_id" => $stat_id
  );
  $db->insert("player_stats", $insertData);
  
  return 0;
} // getPlayerStat

function updatePlayerStat($stat_id, $value, $player_id = false)
{
  global $db, $player;
  
  if (!$player_id) $player_id = $player["player_id"];
  
  // shortname provided?
  if (!ctype_digit((string)$stat_id))
  {
  	$stat = $db->where("short", $stat_id)->getOne("stats", "stat_id");
  	$stat_id = $stat["stat_id"];
  }

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
function getPlayerWarehouseItem($item_id, $player_id = false)
{
  global $db, $player;
  if (!$player_id) $player_id = $player["player_id"];

  return $db->where("player_id", $player_id)
            ->where("item_id", $item_id)
            ->getOne("warehouse", "quantity");
} // getPlayerWarehouseItem

// Can receive 1 to 3 parameters
// item_id, optional quantity, optional player_id
// if quantity not given it defaults to 1, player_id defaults to false
function addItemToPlayerWarehouse($item_id, $quantity = 1, $player_id = false)
{
  global $db, $player;
  
  if (!$player_id)
  	$player_id = $player["player_id"];
  
  $item = getPlayerWarehouseItem($item_id, $player_id);
  
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

function removeItemFromPlayerWarehouse($item_id, $quantity = 1, $player_id = false)
{
  global $db, $player;
  
  if (!$player_id) $player_id = $player["player_id"];
  
  // use a trick and give negative quantity to the adding function
  // this will decrease since it will be quantity + (-another_quantity)
  addItemToPlayerWarehouse($item_id, -$quantity, $player_id);
 
  // now simply check if new quantity is <= 0
  $item = getPlayerWarehouseItem($item_id, $player_id);
  
  // if it is <= 0, remove the row from database, since the user no longer
  // has this item
  if ($item["quantity"] <= 0)
    $db->where("player_id", $player_id)->where("item_id", $item_id)
       ->delete("warehouse", 1);
} //  removeItemFromPlayerWarehouse


function computeStatsForBattle($player_id = false)
{
  global $player;
  if (!$player_id) $player_id = $player["player_id"];
  
  $thePlayer["strength"] = getPlayerStat('str', $player_id);
  $INT                   = getPlayerStat('dex', $player_id);
  $DEX                   = getPlayerStat('int', $player_id);
  $health                = getPlayerStat('health', $player_id);
  
  // stat_id's for all equipment components
  $equipment = array(9, 10, 11, 12, 13, 14);
  require_once("includes/constants/items.php");
  
  // go through each type of equipment, check if user is wearing
  // and add stats that matter
  foreach ($equipment as $piece)
  {
    $item = getPlayerStat($piece, $player_id);
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