<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer?timedout=true' );
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
        <?= $site->addCustomerDashboard(); ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <form id="customer-update" method="post" data-id="<?= $profile['id']; ?>" novalidate="novalidate">
                    <fieldset>
                        <div class="form-title">
                            <h2 class="fs-title main">Edit Your Information</h2>
                        </div>
                        <div class="customer-information">
                            <div class="customer-title" href="#customer-information" data-toggle="collapse" aria-expanded="false" aria-controls="">
                            <h2 class="fs-title">Edit Account</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <div id="customer-information" class="customer-inner-information collapse">
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
                        </div>
                        <div class="delivery-information">
                            <div class="delivery-title" href="#delivery-information" data-toggle="collapse" aria-expanded="false" aria-controls="">
                            <h2 class="fs-title">Edit Address</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <div id="delivery-information" class="delivery-inner-information collapse">
                                <div class="form-inner-container form-address d-flex half">
                                    <div class="form-field half">
                                        <label for="street">Address <span class="ast">*</span></label>
                                        <input type="text" id="street" name="street_name_number" placeholder="Street Name and Number" value="<?= isset($address->street) ? $address->street : ''; ?>" />
                                        <div id="street_warning" class="warning"></div>
                                    </div>
                                    <div class="form-field half">
                                        <label for="suite">Suite</label>
                                        <input type="text" id="suite" name="street_name_number" placeholder="Suite or Apartment Number (optional)" value="<?= isset($address->suite) ? $address->suite : ''; ?>" />
                                    </div>
                                </div>
                                <div class="form-inner-container form-address-other d-flex flex-column">
                                    <div class="form-field city">
                                        <label for="city">City <span class="ast">*</span></label>
                                        <input type="text" id="city" name="city" value="<?= isset($address->city) ? $address->city : ''; ?>" />
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
                                                    <?php if (isset($address->province)) :?>
                                                        <option value="<?= $key; ?>" <?= $address->province == $key ? 'selected' : '';?> class="province-value"><?= $value; ?></option>
                                                    <?php else :?>
                                                        <option value="<?= $key; ?>" class="province-value"><?= $value; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        <div id="province_warning" class="warning"></div>
                                    </div>
                                    <div class="form-field ps-0">
                                        <label for="postal">Postal Code <span class="ast">*</span></label>
                                        <input type="text" id="postal" name="postal" value="<?= isset($address->postal) ? $address->postal : ''; ?>"/>
                                        <div id="postal_warning" class="warning"></div>
                                    </div>
                                    <div class="form-field">
                                        <label for="country">Country <span class="ast">*</span></label>
                                        <input type="text" id="country" name="country" placeholder="Country" value="<?= isset($address->country) ? $address->country : ''; ?>"/>
                                        <div id="country_warning" class="warning"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="password-information">
                            <div class="password-title" href="#password-information" data-toggle="collapse" aria-expanded="false" aria-controls="">
                                <h2 class="fs-title">Change Password</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <div id="password-information" class="password-inner-information collapse">
                                <div class="form-inner-container form-password d-flex half">
                                    <div class="form-field half">
                                        <label for="current_password">Current Password <span class="ast">*</span></label>
                                        <input type="password" id="current_password" name="current_password" />
                                        <div id="current_password_warning" class="warning"></div>
                                    </div>
                                    <div class="form-field half">
                                        <label for="new_password">New Password <span class="ast">*</span></label>
                                        <input type="password" id="new_password" name="new_password" />
                                    </div>
                                </div>
                                <div class="form-inner-container form-password-confirm d-flex half justify-content-end">
                                    <div class="form-field half pe-0">
                                        <label for="confirm_new_password">Confirm New Password <span class="ast">*</span></label>
                                        <input type="password" id="confirm_new_password" name="confirm_new_password" />
                                        <div id="password_validate_warning" class="warning"></div>
                                    </div>
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