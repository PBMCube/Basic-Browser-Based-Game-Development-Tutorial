<?php
// File: forest.php
// Author: makingbrowsergames.com
// Basic Tutorial
 
require_once("includes/header.php");
 
must_login();

require_once("includes/constants/maps/forest.php");

if ($_POST["explore"])
{
  $random = rand(1, 100);
  if ($random < 50)
  {
    // get all monster id's
    $monsterIds = array_keys($monsters);
    // randomize them
    shuffle($monsterIds);
    // get the first random monster 
    $monster = $monsters[$monsterIds[0]];
    
    // set session
    $_SESSION["monsterFight"] = $monsterIds[0];
  } // if user meets monster
  else // gold on ground?
    if ($random > 70)
    {
      $gold = rand(1, 100);
      $success = "You have found ".$gold." currency on the ground!";
      $stat = getPlayerStat('money');
      updatePlayerStat('money', $stat + $gold);
    }
    else $success = "Nothing found. Keep exploring! Better luck next time";
} // if explore request

if ($_POST["fight"] && $_SESSION["monsterFight"])
{
  $monster = $monsters[$_SESSION["monsterFight"]];
  
  $thePlayer = computeStatsForBattle();
  
  /* Initiate fight */
  $rounds = 0;
  
  while (true)
  {
    $rounds++;
    // Start report for current round
    $report .= "Round ".$rounds.": ";
    /* Decide who fights now | $var = &$var2 means when editing $var, $var2 gets edited as well */
    if ($rounds % 2 !=0)
    {
      // this code gets executed if $rounds is an odd number
      $attacker = &$thePlayer; $defender = &$monster;
      $report .= $player["username"]." vs ".$monster["name"]." : ";
    }
    else
    {
      $attacker = &$monster; $defender = &$thePlayer;
      $report .= $monster["name"]." vs ".$player["username"]." : ";
    } // if
    
    /* 
       does attacker have more strength that defendant defense?
       if yes, subtract attacker strength from defender health
       otherwise subtract (def health - attacker strength) / 2 from attacker health
    */
    if ($attacker["strength"] > $defender["defense"])
    {
      $defender["health"] -= $attacker["strength"];
      $report .= "Attacker dealt ".$attacker["strength"]." damage. ";
    }
    else 
    {
      $dmg = intval(($defender["defense"] - $attacker["strength"]) / 2);
      $attacker["health"] -= $dmg;
      $report .= "Attacker failed and received ".$dmg." damage. ";
    }
    // Log health of fighter on each round
    $report .= "Attacker health: ".$attacker["health"]." | Defender health: ".$defender["health"];
    
    // has the player or monster died?
    if ($attacker["health"] <= 0 || $defender["health"] <= 0)
    {
      // find who's the winner, the one who still has health
      if ($attacker["health"] <= 0)
        $winner = $defender;
      else $winner = $attacker;
      
      // stop the while loop
      break;
    } // if one of them is dead
    
    $report .= "<br/>";
  } // while
  
  // compute how much currency lost/earned
  $currency = rand(1, 100);
  
  if ($winner == $thePlayer)
    $success = "You have won! You picked ".$currency." gold from the monster";
  else 
  {
    $error = "You've lost :(. You dropped ".$currency." on the ground!";
    // set currency to negative so that it's deducted from user currency
    $currency *= -1;
  }
  // give/take currency
  $stat = getPlayerStat('money');
  updatePlayerStat('money', $stat + $currency);
  
  unset($_SESSION["monsterFight"]);
} // if fight request

$templateVariables["map"]      = $map;
$templateVariables["monster"]  = $monster;
$templateVariables["report"]   = $report;

$templateVariables["display"] = "forest.tpl";
require_once("includes/footer.php");