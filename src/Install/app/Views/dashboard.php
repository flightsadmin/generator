<?= $this->extend('layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 mt-2">
	        <div class="">
        		<div class="jumbotron">
        		  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        		  <hr class="my-4">
        		  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
          		 </div>
    		</div>
		</div>
        <div class="card bg-light text-light">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          </div>
        </div>
	</div>
</div>
<?= $this->endSection(); ?>