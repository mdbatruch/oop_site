<?php 

global $site;
//find slider by ID
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $id=1;
    }
    $gallery = $site->findSliderByPageId($id);

    $slides = json_decode($gallery['slides']);

    // echo '<pre>';
    // print_r($slides);
?>

<?php if ($gallery['active']) : ?>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php foreach($slides as $slide) : ?>
            <div class="swiper-slide">
                <img src="<?php echo root_url('uploads/' . $slide); ?>" style="max-width: 100%" />
            </div>
        <?php endforeach; ?>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar"></div>
</div>


<script type="text/javascript">

var mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
})

</script>

<?php endif; ?>