<?php

  require('initialize.php');

  include('includes/header.php');
  
  global $session;

  if (isset($_SESSION['account']) && $session->is_logged_in_as_admin($_SESSION['account'])) {
    header( 'location: private/index.php' );
  }

  $subtotal = 0;

  if (isset($_SESSION['account'])) {

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

  } else {
      $count = 0;
      $items = null;
  }


  $site->addHeader();

?>
<header <?= isset($_SESSION['account']) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="header-container">
        <?php 
            if (isset($_SESSION['account']) && $_SESSION['account'] == 'Administrator') {
                $site->addAdminBar($site);
            } else {
                $site->addCartHeader($site, $count, $items, $subtotal, $db);
            } ?>
    </div>
</header>
<main class="admin-login d-flex">
  <div class="container">
      <div class="row">
          <div id="content" class="login-page col-12">
              <form id="login" method="post">
                <h3 class="mb-4 w-100 text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
                  </svg>
                  Login
                </h3>
                <div class="form-container">
                    <div id="form-message"></div>
                      <label class="mb-1 text-white">Username<span class="ast">*</span></label>
                      <input type="text" id="username" name="username" placeholder="Username"/>
                      <div id="username-error"></div>
                    <br />
                      <label class="mb-1 text-white">Password<span class="ast">*</span></label>
                      <input type="password" id="password" name="password" placeholder="Password" value="" />
                      <div id="password-error"></div>
                    <br />
                </div>
                <input type="submit" name="submit" value="Submit" class="btn btn-black" />
                <div class="logged-out mt-4">
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
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>