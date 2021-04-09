<?php
    
    require('initialize.php');

    // $page = new Page("Welcome to my site!", $db);

    $pages = $site->find_all_pages();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id=1;
    }

    if ($_GET['id'] == 0 || $_GET['id'] == null) {
        header('Location: index.php?id=1');
    }
    

     //     //Process all pages in one pass
     foreach($pages as $row) {
        //Logic to match the requested page id
        // echo $row['id'];
        if($row['id'] == $id) {
            //Requested Page
            $page = $row['page'];
            $title = $row['title'];
            $subtitle = $row['subtitle'];
            $description = $row['description'];
            
            break;

        }
        // else {
        //     echo 'not working';
        // }

    }


    $page = new Page($title, $description, $db);
    $site->setPage($page);

    $gallery = $site->findSliderByPageId($id);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $cart_id = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

    //  $page->render_nav();
    // echo '<pre>';
    // print_r($page);

    // try {

    // $stmt = $db->prepare("SELECT id, page, title, subtitle FROM pages");
    // $stmt->execute();
    // $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($pages);

    // $page_name = basename(__FILE__, '.php');

    // $page_id = '';

    // echo $page_id;
    
    // $nav = array();
        $site->addHeader();

    // } 
    
    // catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    // }

    //  $page->content = $description;

    // $cart_item = new CartItem($db);
    // echo '<pre>';
    // print_r($_SESSION);
    // $count = $cart_item->getCartCount(2, $_SESSION['id']);

    // echo '<pre>';
    // print_r($count);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main>
<div class="container-fluid">
        <div class="row">
        <?php if ($gallery) :?>
                <?= $site->addSlider(); ?>
        <?php endif; ?>
        </div>
        <div class="row">
            <?php if ($page->isHome()) : ?>
            <div class="col-12 text-center mt-4">
                <h3>Search for a Product</h3>
                <p>
                    <div id="root"></div>
                </p>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <p>
                    <?php $site->render(); ?>
                </p>
            </div>
        </div>
    </div>
</main>
<script>!function(e){function r(r){for(var n,a,i=r[0],c=r[1],l=r[2],f=0,p=[];f<i.length;f++)a=i[f],Object.prototype.hasOwnProperty.call(o,a)&&o[a]&&p.push(o[a][0]),o[a]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);for(s&&s(r);p.length;)p.shift()();return u.push.apply(u,l||[]),t()}function t(){for(var e,r=0;r<u.length;r++){for(var t=u[r],n=!0,i=1;i<t.length;i++){var c=t[i];0!==o[c]&&(n=!1)}n&&(u.splice(r--,1),e=a(a.s=t[0]))}return e}var n={},o={1:0},u=[];function a(r){if(n[r])return n[r].exports;var t=n[r]={i:r,l:!1,exports:{}};return e[r].call(t.exports,t,t.exports,a),t.l=!0,t.exports}a.e=function(e){var r=[],t=o[e];if(0!==t)if(t)r.push(t[2]);else{var n=new Promise((function(r,n){t=o[e]=[r,n]}));r.push(t[2]=n);var u,i=document.createElement("script");i.charset="utf-8",i.timeout=120,a.nc&&i.setAttribute("nonce",a.nc),i.src=function(e){return a.p+"static/js/"+({}[e]||e)+"."+{3:"b00644f9"}[e]+".chunk.js"}(e);var c=new Error;u=function(r){i.onerror=i.onload=null,clearTimeout(l);var t=o[e];if(0!==t){if(t){var n=r&&("load"===r.type?"missing":r.type),u=r&&r.target&&r.target.src;c.message="Loading chunk "+e+" failed.\n("+n+": "+u+")",c.name="ChunkLoadError",c.type=n,c.request=u,t[1](c)}o[e]=void 0}};var l=setTimeout((function(){u({type:"timeout",target:i})}),12e4);i.onerror=i.onload=u,document.head.appendChild(i)}return Promise.all(r)},a.m=e,a.c=n,a.d=function(e,r,t){a.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,r){if(1&r&&(e=a(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(a.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var n in e)a.d(t,n,function(r){return e[r]}.bind(null,n));return t},a.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(r,"a",r),r},a.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},a.p="/",a.oe=function(e){throw console.error(e),e};var i=this["webpackJsonpsearch-products"]=this["webpackJsonpsearch-products"]||[],c=i.push.bind(i);i.push=r,i=i.slice();for(var l=0;l<i.length;l++)r(i[l]);var s=c;t()}([])</script>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>