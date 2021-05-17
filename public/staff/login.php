<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // $_SESSION['username'] = $username;
  // we validate the username & password first before giving access
    if (is_blank($username)) {
        $errors[] = "Username cannot be blank!";
    }
    if (is_blank($password)) {
        $errors[] = "Password cannot be blank!";
    }
    // if there were no errors, try to login
    if (empty($errors)) {
        // : .find the admin


    }


  redirect_to(url_for('/staff/index.php'));
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
