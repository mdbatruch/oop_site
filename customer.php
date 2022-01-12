<?php

  require('initialize.php');

  if (isset($_SESSION['account']) && $session->is_logged_in_as_customer($_SESSION['account'])) {
    header( 'location: private/customer/index.php' );
  }

  $subtotal = 0;

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);

            $subtotal = '';

            if ($products) {
                foreach ($products as $product_item) {
                    $product_item['price'] = substr($product_item['price'], 1);

                    $total = $product_item['price'] * $product_item['quantity'];
                    
                    $subtotal = intval($subtotal) + intval($total);
                }
            } else {
                $subtotal = 0;
            }
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

  $site->addHeader();

?>
<header <?= !empty($_SESSION) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="header-container">
        <?php 
            if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                $site->addAdminBar($site);
            } else {
                $site->addCartHeader($site, $count, $items, $subtotal, $db);
            } ?>
    </div>
</header>
<main class="login-registration">
    <div class="container">
        <div class="row">
            <div id="login-customer" class="customer-login-page col-12">
                <div class="row">
                <div class="col-12 col-md-6 pb-4 d-flex login-container">
                    <div class="login-option text-center">
                        <div>
                            <h3 class="mb-4 w-100">Login</h3>
                            <p class="mb-4">If you already have an account with us, click the button below to access your account to view your purchase history and manage your profile</p>
                            <a href="#" class="btn btn-black login-option-button">Login</a>
                        </div>
                    </div>
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
                                    <label class="mb-1">Password<span class="ast">*</span></label>
                                    <input type="password" id="login-password" name="login-password" placeholder="Password" value="" />
                                    <div id="login-password-error"></div><br />
                                </div>
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-black" />
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
                </div>
                <div class="col-12 col-md-6 pb-4 d-flex register-container">
                    <div class="register-option text-center">
                        <div>
                            <h3 class="mb-4 w-100">Not a customer? <br/>Register an account now.</h3>
                            <p class="mb-4">
                                Register now to access your order status and history. Just fill in the fields, and we'll get a new account set up for you in no time.
                                We will only ask you for information necessary to make the purchase process faster and easier.
                            </p>
                            <a href="#" class="btn btn-black register-option-button">Register</a>
                        </div>
                    </div>
                    <form id="customer-register" method="post" class="flex-column justify-content-center customer-register">
                        <div>
                            <h3 class="mb-4 w-100"><img src="<?= root_url('uploads/register.png'); ?>" alt="Login" class="img-fluid me-3">Register</h3>
                            <div class="form-container">
                                <div id="form-message"></div>
                                <div class="form-field">
                                    <label class="mb-1">First Name<span class="ast">*</span></label>
                                    <input type="text" id="firstname" name="firstname" placeholder="First Name"/>
                                    <div id="firstname-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Last Name<span class="ast">*</span></label>
                                    <input type="text" id="lastname" name="lastname" placeholder="Last Name"/>
                                    <div id="lastname-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Email<span class="ast">*</span></label>
                                    <input type="text" id="email" name="email" placeholder="Email"/>
                                    <div id="email-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Address<span class="ast">*</span></label>
                                    <input type="text" id="street" class="mb-2" name="street_name_number" placeholder="Street Name and Number" />
                                    <div id="street_warning" class="warning"></div>
                                    <input type="text" id="suite" class="mb-2" name="street_name_number" placeholder="Suite or Apartment Number (optional)" />
                                    <input type="text" id="city" class="mb-2" name="city" placeholder="City" />
                                    <div id="city_warning" class="warning"></div>
                                    <div class="form-field-inner d-flex">
                                        <select name="province" id="province" class="province">
                                            <option value="">Prov./Ter.</option>
                                            <option value="AB" class="province-value">Alberta
                                            </option><option value="BC" class="province-value">British Columbia
                                            </option><option value="MB" class="province-value">Manitoba
                                            </option><option value="NB" class="province-value">New Brunswick
                                            </option><option value="NL" class="province-value">Newfoundland and Labrador
                                            </option><option value="NT" class="province-value">Northwest Territories
                                            </option><option value="NS" class="province-value">Nova Scotia
                                            </option><option value="NU" class="province-value">Nunavut
                                            </option><option value="ON" class="province-value">Ontario
                                            </option><option value="PE" class="province-value">Prince Edward Island
                                            </option><option value="QC" class="province-value">Quebec
                                            </option><option value="SK" class="province-value">Saskatchewan
                                            </option><option value="YT" class="province-value">Yukon Territory
                                            </option>
                                        </select>
                                        <input type="text" id="postal" name="postal" placeholder="Postal Code" />
                                        <div id="postal_warning" class="warning"></div>
                                        <input type="text" id="country" name="country" placeholder="Country" />
                                        <div id="country_warning" class="warning"></div>
                                    </div>
                                </div>
                                <div class="form-field d-none">
                                    <label class="mb-1">Address<span class="ast">*</span></label>
                                    <textarea id="address" name="address" placeholder="Address"></textarea>
                                    <div id="address-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Username<span class="ast">*</span></label>
                                    <input type="text" id="username" name="username" placeholder="Username"/>
                                    <div id="username-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Password<span class="ast">*</span></label>
                                    <input type="password" id="password" name="password" placeholder="Password" value="" />
                                    <div id="password-error"></div>
                                </div>
                                <br />
                                <div class="form-field">
                                    <label class="mb-1">Confirm Password<span class="ast">*</span></label>
                                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" value="" />
                                    <div id="confirm-password-error"></div>
                                </div>
                                <br />
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-black" />
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>