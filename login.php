<?php
// File: login.php
// Author: makingbrowsergames.php
// Basic Tutorial
 
require_once("includes/header.php");
 
if ($_POST["login"])
{
  $username = $_POST["username"];
  $password = $_POST["password"];
  if (ctype_alnum($username))
  {
    $passwordHash = md5("23sfgh#%$@#".$username.$password);

    // check if user credentials are valid
    $check = $db->where("username", $username)
                ->where("password", $passwordHash)
                ->getOne("players", "player_id");
    if ($check["player_id"])
    {
      // login user
      $_SESSION["player_id"] = $check["player_id"];
 
      // redirect user to index
      header("Location: index.php");
    }
    else
      $error = "Access denied";
  } // if username is valid-ish
} // if

$templateVariables["display"] = "login.tpl";
require_once("includes/footer.php");