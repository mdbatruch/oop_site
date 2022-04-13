<form id="customer-login" method="post" class="d-flex flex-column justify-content-center customer-login">
    <div>
        <h3 class="mb-4 w-100"><img src="<?= root_url('uploads/login.png'); ?>" alt="Login" class="img-fluid me-3">Login</h3>
        <div class="form-container">
            <div id="login-form-message"></div>
            <div class="form-field">
                <label class="mb-1">Username or E-mail<span class="ast">*</span></label>
                <input type="text" id="login-username" name="login-username" placeholder="Username"/>
                <div id="login-username-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Password<span class="ast">*</span></label>
                <input type="password" id="login-password" name="login-password" placeholder="Password" value="" />
                <div id="login-password-error"></div><br />
            </div>
        </div>
        <div class="submit-container">
            <input type="submit" name="submit" value="Sign In" class="btn btn-black" />
        </div>
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
    </div>
    </form>