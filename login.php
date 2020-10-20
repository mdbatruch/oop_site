<?php

  require('initialize.php');

  include('includes/header.php');

  if ($session->is_logged_in()) {
    header( 'location: private/index.php' );
  }


  // while (list($var,$value) = each ($_SERVER)) {
  //   echo "$var => $value <br />";
//  }

?>
<div class="container">
    <div class="row">
        <div id="content" class="login-page col-12 col-md-8 offset-md-4">
            <form id="login" method="post">
            <img class="icon" src="<?php echo root_url('images/icon.svg');?>" alt="Mike Batruch Icon">
              <h1>Login</h1>
              <div class="form-container">
                  <div id="form-message"></div>
                  <label>Username:</label>
                  <input type="text" id="username" name="username" placeholder="Username"/>
                  <div id="username-error"></div>
                  <br />
                  <label>Password:</label>
                  <input type="password" id="password" name="password" placeholder="Password" value="" />
                  <div id="password-error"></div><br />
              </div>
              <input type="submit" name="submit" value="Submit"  />
              <div class="logged-out">
                  <?php if (isset($_SESSION['logout_message'])) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['logout_message'];
                          unset($_SESSION['logout_message']);
                          session_destroy(); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                  <?php endif; ?>
              </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>