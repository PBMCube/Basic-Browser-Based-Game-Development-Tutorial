<?php
if ($logged)
{
  $templateVariables["player"] = $player;
} // if logged
 
$templateVariables["error"]   = $error;
$templateVariables["success"] = $success;
 
$smarty->assign($templateVariables);
 
$smarty->display($templateVariables["display"]);