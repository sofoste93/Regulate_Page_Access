<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Generating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['last_login'] = time();

    // here the username is admin
    $_SESSION['username'] = $admin;
    return true;
  }


