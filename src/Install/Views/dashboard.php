<div class="container-fluid">
	<div class="row ">
	  <div class="col-12">
		  <div class="jumbotron">
		    <h1 class="display-4"><h1>Hello, <?= session()->get('firstname') ?> <?= session()->get('lastname') ?> </h1>
		    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
		    <hr class="my-4">
		    
		    <a class="btn btn-info btn-sm" href="#" role="button">Learn more</a>
		  </div>
	  </div>
	</div>
</div>