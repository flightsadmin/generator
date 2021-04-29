@= $this->extend('layouts/template'); !php
@= $this->section('content'); !php
<div class="container-fluid py-1">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-between align-items-center">
							<h5>Edit {! nameEntity !}<h5>
							<a class="btn btn-info" href="@= site_url('/{! table !}') !php"><i class="fa fa-arrow-left"></i> Back </a> 
						</div>
					</div>
				<div class="card-body">
					<div class="form">
						<form method="post" id="update_{! tableName !}" name="update_{! tableName !}" action="@= site_url('/{! table !}-update') !php">
						<div class="row">
							<input type="hidden" name="{! primaryKey !}" id="{! primaryKey !}" value="@php echo $value['{! primaryKey !}']; !php">
{! editForm !}
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info">Update {! nameEntity !}</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection(); !php