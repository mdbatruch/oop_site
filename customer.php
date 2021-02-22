<?php

  require('initialize.php');

  include('includes/header.php');

  if ($session->is_logged_in()) {
    header( 'location: private/index.php' );
  }

?>
<div class="container">
    <div class="row">
        <div id="login-content" class="customer-login-page col-12">
            <div class="row">
            <div class="col-12 col-md-6">
            <form id="customer-login" method="post">
                <h3>Login to your Account</h3>
                <div class="form-container">
                    <div id="login-form-message"></div>
                    <label>Username:</label>
                    <input type="text" id="login-username" name="login-username" placeholder="Username"/>
                    <div id="login-username-error"></div>
                    <br />
                    <label>Password:</label>
                    <input type="password" id="login-password" name="login-password" placeholder="Password" value="" />
                    <div id="login-password-error"></div><br />
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
            <div class="col-12 col-md-6">
                <form id="customer-register" method="post">
                <h3>Not a customer? Register an account now.</h3>
                <div class="form-container">
                    <div id="form-message"></div>
                        <label>First Name:</label>
                            <input type="text" id="firstname" name="firstname" placeholder="First Name"/>
                    <div id="firstname-error"></div>
                        <label>Last Name:</label>
                            <input type="text" id="lastname" name="lastname" placeholder="Last Name"/>
                    <div id="lastname-error"></div>
                        <label>Email:</label>
                            <input type="text" id="email" name="email" placeholder="Email"/>
                    <div id="email-error"></div>
                        <label>Address:</label>
                            <textarea id="address" name="address" placeholder="Address"></textarea>
                    <div id="address-error"></div>
                        <label>Username:</label>
                            <input type="text" id="username" name="username" placeholder="Username"/>
                    <div id="username-error"></div>
                    <br />
                        <label>Password:</label>
                            <input type="password" id="password" name="password" placeholder="Password" value="" />
                    <div id="password-error"></div><br />
                        <label>Confirm Password:</label>
                            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" value="" />
                    <div id="confirm-password-error"></div><br />
                </div>
                <input type="submit" name="submit" value="Submit"  />
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>