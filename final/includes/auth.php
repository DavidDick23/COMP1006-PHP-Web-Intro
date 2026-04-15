<?php
//=========================================================================
// #region Session Startup
//-------------------------------------------------------------------------
//start the session if one is not already active
//include this file at the top of every page that needs auth awareness
//-------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
//-------------------------------------------------------------------------
// #endregion Session Startup
//=========================================================================

//=========================================================================
// #region Auth Helpers
//-------------------------------------------------------------------------
//redirects to login.php if the user is not logged in
//called at the top of any page that should be restricted
function requireLogin()
{
    if (empty($_SESSION['user_id']))
    {
        header("Location: login.php");
        exit;
    }
}

//returns the logged in user's session data as an array, or null if not logged in
function getCurrentUser()
{
    if (!empty($_SESSION['user_id']))
    {
        return 
        [
            'id'       => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email'    => $_SESSION['email'],
        ];
    }
    return null;
}

//returns true if a user is currently logged in
function isLoggedIn()
{
    return !empty($_SESSION['user_id']);
}
//-------------------------------------------------------------------------
// #endregion Auth Helpers
//=========================================================================