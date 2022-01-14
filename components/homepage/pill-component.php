<div class="browse-categories bd-categories-tabs">
  <div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-3">
                <div class="nav">
                    <a class="nav-link text-white bg-dark w-100 text-center" id="#" data-toggle="pill" href="#" role="tab" aria-controls="v-pills-title" aria-selected="false">Browse Category</a>
                </div>
            </div>
            <div class="col-9">
                <div id="root"></div>
            </div>
        </div>
    </div>
    <div class="col-3">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <!-- <a class="nav-link text-white bg-dark" id="#" data-toggle="pill" href="#" role="tab" aria-controls="v-pills-title" aria-selected="false">Browse Category</a> -->
        <a class="nav-link " id="v-pills-new-tab" data-toggle="pill" href="#v-pills-new" role="tab" aria-controls="v-pills-new" aria-selected="true">New and Exclusive</a>
        <a class="nav-link" id="v-pills-bestsellers-tab" data-toggle="pill" href="#v-pills-bestsellers" role="tab" aria-controls="v-pills-bestsellers" aria-selected="false">Bestsellers</a>
        <a class="nav-link" id="v-pills-good-tab" data-toggle="pill" href="#v-pills-good" role="tab" aria-controls="v-pills-good" aria-selected="false">The Lord of the Rings Miniatures - Good</a>
        <a class="nav-link" id="v-pills-evil-tab" data-toggle="pill" href="#v-pills-evil" role="tab" aria-controls="v-pills-evil" aria-selected="false">The lord of the Rings Miniatures - Evil</a>
        <a class="nav-link" id="v-pills-scenery-tab" data-toggle="pill" href="#v-pills-scenery" role="tab" aria-controls="v-pills-scenery" aria-selected="false">Painting, Modelling and Scenery</a>
      </div>
    </div>
    <div class="col-9">
      <div class="tab-content p-3" id="v-pills-tabContent">
        <div class="tab-pane fade" id="v-pills-new" role="tabpanel" aria-labelledby="v-pills-new-tab">
          <p>Cillum ad ut irure tempor velit nostrud occaecat ullamco aliqua anim Lorem sint. Veniam sint duis incididunt do esse magna mollit excepteur laborum qui. Id id reprehenderit sit est eu aliqua occaecat quis et velit excepteur laborum mollit dolore eiusmod. Ipsum dolor in occaecat commodo et voluptate minim reprehenderit mollit pariatur. Deserunt non laborum enim et cillum eu deserunt excepteur ea incididunt minim occaecat.</p>
        </div>
        <div class="tab-pane fade" id="v-pills-bestsellers" role="tabpanel" aria-labelledby="v-pills-bestsellers-tab">
          <p>Cillum ad ut irure tempor velit nostrud occaecat ullamco aliqua anim Lorem sint. Veniam sint duis incididunt do esse magna mollit excepteur laborum qui. Id id reprehenderit sit est eu aliqua occaecat quis et velit excepteur laborum mollit dolore eiusmod. Ipsum dolor in occaecat commodo et voluptate minim reprehenderit mollit pariatur. Deserunt non laborum enim et cillum eu deserunt excepteur ea incididunt minim occaecat.</p>
        </div>
        <div class="tab-pane fade" id="v-pills-good" role="tabpanel" aria-labelledby="v-pills-good-tab">
          <p>Culpa dolor voluptate do laboris laboris irure reprehenderit id incididunt duis pariatur mollit aute magna pariatur consectetur. Eu veniam duis non ut dolor deserunt commodo et minim in quis laboris ipsum velit id veniam. Quis ut consectetur adipisicing officia excepteur non sit. Ut et elit aliquip labore Lorem enim eu. Ullamco mollit occaecat dolore ipsum id officia mollit qui esse anim eiusmod do sint minim consectetur qui.</p>
        </div>
        <div class="tab-pane fade" id="v-pills-evil" role="tabpanel" aria-labelledby="v-pills-evil-tab">
          <p>Fugiat id quis dolor culpa eiusmod anim velit excepteur proident dolor aute qui magna. Ad proident laboris ullamco esse anim Lorem Lorem veniam quis Lorem irure occaecat velit nostrud magna nulla. Velit et et proident Lorem do ea tempor officia dolor. Reprehenderit Lorem aliquip labore est magna commodo est ea veniam consectetur.</p>
        </div>
        <div class="tab-pane fade" id="v-pills-scenery" role="tabpanel" aria-labelledby="v-pills-scenery-tab">
          <p>Eu dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit consectetur elit id dolor proident in cupidatat officia. Voluptate excepteur commodo labore nisi cillum duis aliqua do. Aliqua amet qui mollit consectetur nulla mollit velit aliqua veniam nisi id do Lorem deserunt amet. Culpa ullamco sit adipisicing labore officia magna elit nisi in aute tempor commodo eiusmod.</p>
        </div>
      </div>
      <?= include 'components/homepage/pills-gallery-component.php'; ?>
    </div>
  </div>
</div>