@= $this->extend('layouts/default') !php
@= $this->section('content') !php
<div class="container-fluid mt-2">
	<div class="row justify-content-center">
		<div class="col-md-12">
		    <div class="card card-default">
		        <div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<h5>Update {! nameEntity !}</h5>
						<a class="btn btn-secondary btn-sm" href="@= site_url('/{! table !}') !php"><i class="bi bi-arrow-left"></i> Back</a> 
					</div>
		    	</div>
		        <div class="card-body">
		            <div class="col-md-12">
		                <form class="row g-2" role="form" action="@= base_url('{! table !}/update') !php" method="post" enctype="multipart/form-data">
		                    <input type="hidden" name="id" value="@= $value['id'] !php">
{! editForm !}
							<div class="col-md-12 d-flex justify-content-between align-items-center">
			                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
			                    <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
			                </div>
		                </form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div><!-- /.col-->
@= $this->endSection() !php
