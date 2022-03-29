<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    $address = json_decode($profile['address']);

    // echo '<pre>';
    // print_r($profile);

//  include('../includes/header.php');

 $title = 'Customer Profile';

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

 $site->addPrivateHeader($title);

?>

<header id="customer-header" class="container-fluid">
    <div class="row" id="customer-navigation">
        <?php $site->addCustomerCart($site, $count, $items, $subtotal, $db); ?>
    </div>
</header>
<main class="customer-main">
    <div class="container-fluid">
        <div class="row customer-top justify-content-center py-4">
            <div class="col-md-10 col-xl-9 text-center">
                <h3>Welcome back, <?= $_SESSION['username']; ?></h3>
                <div class="link-container d-flex justify-content-evenly">
                    <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">View Past Orders</a>
                    <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">Edit Profile</a>
                    <a href="<?= root_url('products.php'); ?>" class="btn btn-lightgrey py-3 my-2">Start Shopping</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <form id="customer-update" method="post" data-id="<?= $profile['id']; ?>">
                    <fieldset>
                        <div class="customer-information">
                            <h2 class="fs-title mt-4">Edit Your Account Information</h2>
                            <div class="form-inner-container form-name d-flex half">
                                <div class="form-field half">
                                    <label for="username">Username <span class="ast">*</span></label>
                                    <input type="text" id="username" name="username" value="<?= $profile['username']; ?>"/>
                                    <div id="username_warning" class="warning"></div>
                                </div>
                                <div class="form-field half">
                                    <label for="email">Email Address <span class="ast">*</span></label>
                                    <input type="email" id="email" class="half" name="email" value="<?= $profile['email']; ?>" />
                                    <div id="email_warning" class="warning"></div>
                                </div>
                            </div>
                            <div class="form-inner-container form-contact d-flex half">
                                <div class="form-field half">
                                    <label for="first_name">First Name <span class="ast">*</span></label>
                                    <input type="text" id="first_name" class="half" name="first_name" value="<?= $profile['first_name']; ?>" />
                                    <div id="first_name_warning" class="warning"></div>
                                </div>
                                <div class="form-field half">
                                    <label for="last_name">Last Name <span class="ast">*</span></label>
                                    <input type="text" id="last_name" class="half" name="last_name" value="<?= $profile['last_name']; ?>" />
                                    <div id="last_name_warning" class="warning"></div>
                                </div>
                            </div>
                        </div>
                        <div class="delivery-information">
                            <h2 class="fs-title mt-4">Edit Address</h2>
                            <div class="form-inner-container form-address d-flex half">
                                <div class="form-field half">
                                    <label for="street">Address <span class="ast">*</span></label>
                                    <input type="text" id="street" name="street_name_number" placeholder="Street Name and Number" value="<?= $address->street; ?>" />
                                    <div id="street_warning" class="warning"></div>
                                </div>
                                <div class="form-field half">
                                    <label for="suite">Suite <span class="ast">*</span></label>
                                    <input type="text" id="suite" name="street_name_number" placeholder="Suite or Apartment Number (optional)" value="<?= $address->suite; ?>" />
                                </div>
                            </div>
                            <div class="form-inner-container form-address-other d-flex flex-column">
                                <div class="form-field city">
                                    <label for="city">City <span class="ast">*</span></label>
                                    <input type="text" id="city" name="city" value="<?= $address->city; ?>" />
                                    <div id="city_warning" class="warning"></div>
                                </div>
                                <div class="form-field">
                                    <label for="province">Province <span class="ast">*</span></label>
                                    <?php $canadian_states = array( 
                                            "BC" => "British Columbia", 
                                            "ON" => "Ontario", 
                                            "NL" => "Newfoundland and Labrador", 
                                            "NS" => "Nova Scotia", 
                                            "PE" => "Prince Edward Island", 
                                            "NB" => "New Brunswick", 
                                            "QC" => "Quebec", 
                                            "MB" => "Manitoba", 
                                            "SK" => "Saskatchewan", 
                                            "AB" => "Alberta", 
                                            "NT" => "Northwest Territories", 
                                            "NU" => "Nunavut",
                                            "YT" => "Yukon Territory"
                                        ); ?>
                                        <select name="province" id="province" class="province">
                                            <option value=""></option>
                                            <?php foreach ($canadian_states as $key => $value) : ?>
                                                <option value="<?= $key; ?>" <?= $address->province == $key ? 'selected' : '';?> class="province-value"><?= $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <div id="province_warning" class="warning"></div>
                                </div>
                                <div class="form-field ps-0">
                                    <label for="postal">Postal Code <span class="ast">*</span></label>
                                    <input type="text" id="postal" name="postal" value="<?= $address->postal; ?>"/>
                                    <div id="postal_warning" class="warning"></div>
                                </div>
                                <div class="form-field">
                                    <label for="country">Country <span class="ast">*</span></label>
                                    <input type="text" id="country" name="country" placeholder="Country" value="<?= $address->country; ?>"/>
                                    <div id="country_warning" class="warning"></div>
                                </div>
                            </div>
                        </div>
                        <div class="password-information">
                            <h2 class="fs-title mt-4">Change Password</h2>
                            <div class="form-inner-container form-password d-flex half">
                                <div class="form-field half">
                                    <label for="current_password">Current Password <span class="ast">*</span></label>
                                    <input type="password" id="current_password" name="current_password" />
                                    <div id="current_password_warning" class="warning"></div>
                                </div>
                                <div class="form-field half">
                                    <label for="new_password">New Password <span class="ast">*</span></label>
                                    <input type="new_password" id="new_password" name="new_password" />
                                </div>
                            </div>
                            <div class="form-inner-container form-password-confirm d-flex half justify-content-end">
                                <div class="form-field half ps-2 pe-0">
                                    <label for="confirm_new_password">Confirm New Password <span class="ast">*</span></label>
                                    <input type="confirm_new_password" id="confirm_new_password" name="confirm_new_password" />
                                </div>
                            </div>
                        </div>
                        <div class="update-container mt-4 pt-4">
                            <div class="form-inner-container form-address d-flex half">
                                <div class="form-field half message">
                                    <div id="form-message"></div>
                                </div>
                                <div class="form-field half">
                                    <input type="submit" name="update_information" id="update_information" value="Update Information" class="update btn btn-black">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>