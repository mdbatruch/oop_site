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
    
    <div class="swiper-pagination"></div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>


<script type="text/javascript">

var mySwiper = new Swiper('.swiper-container', {
  loop: true,
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
})

</script>

<?php endif; ?>