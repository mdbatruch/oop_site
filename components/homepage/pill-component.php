<div class="browse-categories bd-categories-tabs container">
  <div class="row">
      <div class="col-12">
          <div class="row">
              <div class="nav-title col-6 col-lg-3">
                  <div class="nav">
                      <div class="pill-link nav-link-header text-white w-100" id="#" data-toggle="pill" href="#" role="tab" aria-controls="v-pills-title" aria-selected="false">
                        <div class="text">
                          Browse Category
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                          </svg>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-6 col-lg-9 px-0 search-container">
                  <div id="root"></div>
              </div>
          </div>
      </div>
  </div>
  <div class="row position-relative">
    <div class="bg"></div>
    <div class="col-12 col-lg-3 pill-container">
      <div class="nav flex-column nav-pills" id="v-pills-tab">
        <div class="pill-link nav-link-header inner text-white w-100" id="#">
          <div class="text">
            Browse Category
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
          </div>
        </div>
        <div class="pill-link" id="v-pills-new-tab" href="#v-pills-new" data-toggle="collapse" aria-expanded="false" aria-controls="v-pills-new">
          <div class="text">
            New and Exclusive
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <div class="tab-pane p-3 collapse" id="v-pills-new">
            <div class="list-container">
                <ul class="category menu">
                  <li>
                    <a class="category-header" href="#">Show all New &amp; Exclusive</a>
                      <ul class="sub-menu mt-4">
                        <li><a class="category-link" href="#">New &amp; Exclusive Evil</a></li>
                        <li><a class="category-link" href="#">New &amp; Exclusive Good</a></li>
                        <li><a class="category-link" href="#">New &amp; Exclusive Scenery</a></li>
                      </ul>
                  </li>
                </ul> 
              </div>
          </div>
        </div>
        <div class="pill-link" id="v-pills-bestsellers-tab" href="#v-pills-bestsellers" data-toggle="collapse" aria-expanded="false" aria-controls="v-pills-bestsellers">
          <div class="text">
            Bestsellers
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <div class="tab-pane p-3 collapse" id="v-pills-bestsellers">
            <div class="list-container">
              <ul class="category menu">
                <li>
                  <a class="category-header" href="#">Show all Bestsellers</a>
                    <ul class="sub-menu mt-4">
                      <li><a class="category-link" href="#">Evil Bestsellers</a></li>
                      <li><a class="category-link" href="#">Good Bestsellers</a></li>
                      <li><a class="category-link" href="#">Scenery Bestsellers</a></li>
                      <li><a class="category-link" href="#">Books Bestsellers</a></li>
                    </ul>
                </li>
              </ul> 
            </div>
          </div>
        </div>
        <div class="pill-link" id="v-pills-good-tab" href="#v-pills-good" data-toggle="collapse" aria-expanded="false" aria-controls="v-pills-good">
          <div class="text">
            The Lord of the Rings Miniatures - Good 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <div class="tab-pane p-3 collapse" id="v-pills-good">
            <div class="list-container">
              <ul class="category menu">
                <li>
                  <a class="category-header" href="#">Show all Good</a>
                    <ul class="sub-menu mt-4">
                      <li><a class="category-link" href="<?= root_url('products?page=1&category=minas+tirith'); ?>">Minas Tirith</a></li>
                      <li><a class="category-link" href="<?= root_url('products?page=1&category=rohan'); ?>">Rohan</a></li>
                      <li><a class="category-link" href="<?= root_url('products?page=1&category=the+fellowship'); ?>">The Fellowship</a></li>
                    </ul>
                </li>
              </ul> 
            </div>
          </div>
        </div>
        <div class="pill-link" id="v-pills-evil-tab" href="#v-pills-evil" data-toggle="collapse" aria-expanded="false" aria-controls="v-pills-evil">
          <div class="text">
            The lord of the Rings Miniatures - Evil
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <div class="tab-pane p-3 collapse" id="v-pills-evil">
              <div class="list-container">
                <ul class="category menu">
                  <li>
                    <a class="category-header" href="#">Show all Evil</a>
                       <ul class="sub-menu mt-4">
                         <li><a class="category-link" href="<?= root_url('products?page=1&category=isengard'); ?>" target="_self">Isengard</a></li>
                        <li><a class="category-link" href="<?= root_url('products?page=1&category=mordor'); ?>">Mordor</a></li>
                        <li><a class="category-link" href="<?= root_url('products?page=1&category=moria'); ?>">Moria</a></li>
                        <li><a class="category-link" href="<?= root_url('products?page=1&category=desolator+of+the+north'); ?>">Desolator of the North</a></li>
                       </ul>
                   </li>
                </ul> 
              </div>
          </div>
        </div>
        <div class="pill-link" id="v-pills-scenery-tab" href="#v-pills-scenery" data-toggle="collapse" aria-expanded="false" aria-controls="v-pills-scenery">
          <div class="text">
            Painting, Modelling and Scenery
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <div class="tab-pane p-3 collapse" id="v-pills-scenery">
            <div class="list-container">
                <ul class="category menu">
                  <li>
                    <a class="category-header" href="#">Show all</a>
                      <ul class="sub-menu mt-4">
                        <li><a class="category-link" href="#">Undercoat</a></li>
                        <li><a class="category-link" href="#">Brushes</a></li>
                        <li><a class="category-link" href="#">Paint</a></li>
                        <li><a class="category-link" href="#">Basing</a></li>
                      </ul>
                  </li>
                </ul> 
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-9 position-relative pills-gallery">
      <?php include 'components/homepage/pills-gallery-component.php'; ?>
    </div>
  </div>
</div>