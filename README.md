# Regulate_Page_Access

Regulating page access with PHP

                    --------------------------------------------------------------
                     |                  REGULATE PAGE ACCESS                    |
                    --------------------------------------------------------------


                    ===============================================================
                     |            # User Authentication is Essential             |
                    ===============================================================

    - Password-protected areas are common in most web apps
    - Learning best practices avoids costly mistakes
    - Development choices and security concerns are
      intertwined topics

                                  # TICKET ANALOGY
    - Purchase tickets for a concert          - Admin creates a user
    - Present ID at the gate                  - User logs in via a login form
    - Get handstamp amd enter concert         - User is authenticated and given access
    - Show handstamp, avoid line, and reenter - User requests additional password-protected pages
    - Wash away handstamp                     - User logs out

                                  # User Authentication
    - User logs in via  login form
    - Application searches for the username in the database
    - If the username is found, it encrypts the form password and compares it with the encrypted stored password
    - If the passwords match, then it sets a value in the session to the user ID and redirects to post-login
    - User request additional password-protected pages
    - Application checks the session data for the user ID
    - If present, it returns the requested page
    - If absent, it redirects to the login form
    - User logs out
    - User ID stored in session is removed

                    ===============================================================
                     |                   # Create admins tables                  |
                    ===============================================================
                    CREATE TABLE admins (
                      id INT(11) NOT NULL AUTO_INCREMENT,
                      first_name VARCHAR(255),
                      last_name VARCHAR(255),
                      email VARCHAR(255),
                      username VARCHAR(255),
                      hashed_password VARCHAR(255),
                      PRIMARY KEY (id)
                    );

                    ALTER TABLE admins ADD INDEX index_username (username);


                    ===============================================================
                     |                   # Build admin management                |
                    ===============================================================

        # For the Admin CRUD          # Admin Queries         # Admin Validations

        - /staff/admins/index.php     - find_all_admins()     - FirstName: 2-255 char
        - /staff/admins/show.php      - find_admin_by_id($id) - LastName: 2-255 char
        - /staff/admins/new.php       - insert_admin($admin)  - Email: no blank, max.255 char, valid format
        - /staff/admins/edit.php      - update_admin($admin)  - Username: 8-255 char, unique
        - /staff/admins/delete.php    - delete_admin($admin)  - Password: 12+ char
                                                              - Password: 1 upper, 1 lower, 1 number, 1 symbol
                                                              - Confirm password: no blank, matches password





                    ===============================================================
                     |                   # PHP password functions                |
                    ===============================================================

                    # Encrypting Passwords

                    - Never store passwords in plain text
                    - Users reuse passwords
                    - Use one-way encryption
                    - Same inputs + same + hashing algorithm = same output
                    - Encrypts the actual password, and then stores it
                    - Encrypts the attempted password and then compares it to stored password
                    - Encryption algorithm: one-way, strong, slow
                    - Bcrypt, based on Blowfish cipher

                        // PHP > 5.5
                        - password_hash($password, PASSWORD_DEFAULT);
                        - password_hash($password, PASSWORD_BCRYPT), ['cost' => 10]);
                        - password_verify($password, $shared_password);



                    ===============================================================
                     |                  # Authenticate user access               |
                    ===============================================================





                    ===============================================================
                     |                   # Require authorization                 |
                    ===============================================================
                      // is_logged_in() contains all the logic for determining if a
                      // request should be considered a "logged in" request or not.
                      // It is the core of require_login() but it can also be called
                      // on its own in other contexts (e.g. display one link if an admin
                      // is logged in and display another link if they are not)
                      function is_logged_in() {
                        // Having a admin_id in the session serves a dual-purpose:
                        // - Its presence indicates the admin is logged in.
                        // - Its value tells which admin for looking up their record.
                        return isset($_SESSION['admin_id']);
                      }

                      // Call require_login() at the top of any page which needs to
                      // require a valid login before granting access to the page.
                      function require_login() {
                        if(!is_logged_in()) {
                          redirect_to(url_for('/staff/login.php'));
                        } else {
                          // Do nothing, let the rest of the page proceed
                        }
                      }



                    ===============================================================
                     |                   # Log out a user                        |
                    ===============================================================

                    <?php
                    require_once('../../private/initialize.php');

                    log_out_admin();
                    redirect_to(url_for('/staff/login.php'));

                    ?>
                  // Performs all actions necessary to log out an admin
                  function log_out_admin() {
                    unset($_SESSION['admin_id']);
                    unset($_SESSION['last_login']);
                    unset($_SESSION['username']);
                    // session_destroy(); // optional: destroys the whole session
                    return true;
                  }


                    ===============================================================
                     |                  # Optional password updating             |
                    ===============================================================
                    //:.add if-statement
                    if ($password_required) {
                      if(is_blank($admin['password'])) {
                        $errors[] = "Password cannot be blank.";
                      } elseif (!has_length($admin['password'], array('min' => 12))) {
                        $errors[] = "Password must contain 12 or more characters";
                      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
                        $errors[] = "Password must contain at least 1 uppercase letter";
                      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
                        $errors[] = "Password must contain at least 1 lowercase letter";
                      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
                        $errors[] = "Password must contain at least 1 number";
                      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
                        $errors[] = "Password must contain at least 1 symbol";
                      }

                      if(is_blank($admin['confirm_password'])) {
                        $errors[] = "Confirm password cannot be blank.";
                      } elseif ($admin['password'] !== $admin['confirm_password']) {
                        $errors[] = "Password and confirm password must match.";
                      }
                    }





                    ===============================================================
                     |                    # Authorized previewing                |
                    ===============================================================
                      function is_logged_in() {
                        // Having a admin_id in the session serves a dual-purpose:
                        // - Its presence indicates the admin is logged in.
                        // - Its value tells which admin for looking up their record.
                        return isset($_SESSION['admin_id']);
                      }

                    $preview = $_GET['preview'] == 'true' ? true : false;

>
> # Contribution
>
> - Kevin Skoglund (Instructor)
>
> - Stephane Sob F.
> 
> - Lynda.com
> 
