@= $this->extend('layouts/template'); !php
@= $this->section('content'); !php
<div class="container-fluid py-1">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-between align-items-center">
							<h5>Add {! nameEntity !}<h5>
							<a class="btn btn-info" href="@= site_url('/{! table !}') !php"><i class="fa fa-arrow-left"></i> Back </a> 
						</div>
					</div>
				<div class="card-body">
					<div class="text-danger">
					@= \Config\Services::validation()->listErrors(); !php
					</div>
					<div class="form">						
						<form method="post" id="add_{! table !}" name="add_{! table !}"
							  action="@= site_url('/{! table !}-submit') !php">
						<div class="row">
{! inputForm !}
						</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Add {! nameEntity !}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection(); !php