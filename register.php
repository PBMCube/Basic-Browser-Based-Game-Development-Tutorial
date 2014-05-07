<?php
// register.php
// Author: makingbrowsergames.com
// Basic Tutorial

require("includes/header.php"); 
if ($_POST["register"])
{
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    $error = "Invalid email";

  if (!(ctype_alnum($_POST["username"]) && (strlen($_POST["username"]) >= 3 && strlen($_POST["username"])) <= 25))
    $error = "Invalid username";

  if (!((strlen($_POST["password"]) >= 3 && strlen($_POST["password"])) <= 25))
    $error = "Invalid password";

  $check = $db->where("username", $_POST["username"])->getOne("players", "player_id");
  if ($check["player_id"])
    $error = "Username already in use!";

  $check = $db->where("email", $_POST["email"])->getOne("players", "player_id");
  if ($check["player_id"])
    $error = "Email already in use!";

  if (strpos($_POST["password"], $_POST["username"]) !== false)
    $error = "Password cannot contain the username"; 

  if (!isset($error))
  {
    $success = "Account created! Welcome, ".$_POST["username"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $passwordHash = md5("23sfgh#%$@#".$username.$_POST["password"]);

    $expNext = levelExperience(2);

    $dataInsert = array(
      "username" => $username,
      "password" => $passwordHash,
      "expNext"  => $expNext,
      "email" => $email
    );

    $db->insert("players", $dataInsert);

  } // if
} // if

$templateVariables["display"] = "register.tpl";
require_once("includes/footer.php");