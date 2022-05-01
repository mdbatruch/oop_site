// import {tns} from './src/tiny-slider.js';

(function ($) {

  var slider = tns({
    container: '.my-slider',
    items: 1,
    slideBy: 'page',
    autoplay: false,
    nav: false,
    loop: false,
    controlsContainer: "#customize-controls",
    responsive: {
        600: {
          edgePadding: 20,
          gutter: 20,
          items: 2
        },
        1030: {
           items: 3
        },
        1240: {
          items: 4
        }
    }
  });

})(jQuery);

(function ($) {

    var slider = tns({
      container: '.promo-slider',
      items: 1,
      slideBy: 'page',
      autoplay: false,
      nav: true,
      mouseDrag: true,
      controlsContainer: "#promos-controls",
    });
  
  })(jQuery);

  (function ($) {

    var slider = tns({
      container: '.pills-promo-slider',
      items: 1,
      slideBy: 'page',
      autoplay: false,
      nav: true,
      mouseDrag: true,
      controlsContainer: "#pills-promos-controls",
    });
  
  })(jQuery);

  (function ($) {

    var slider = tns({
      container: '.latest-slider',
      items: 1,
      slideBy: 'page',
      autoplay: false,
      nav: true,
      mouseDrag: true,
      controlsContainer: "#latest-release-controls",
      responsive: {
        600: {
          edgePadding: 20,
          gutter: 20,
          items: 2
        },
        1030: {
           items: 3
        },
        1240: {
          items: 4
        }
    }
    });
  
  })(jQuery);