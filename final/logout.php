<?php
//=========================================================================
// #region Logout
//-------------------------------------------------------------------------
//destroy the session completely and redirect to login page
require "./includes/auth.php"; 

//unset all session variables
$_SESSION = [];

//destroy the session
session_destroy();

//redirect to login page
header("Location: login.php");

//stops the script from executing
exit;
//-------------------------------------------------------------------------
// #endregion Logout
//=========================================================================
