@= $this->extend('layouts/template'); !php
@= $this->section('content'); !php
<div class="container-fluid py-1">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
					<div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<div class="float-left">
								<h5>Edit {! nameEntity !}<h5>
							</div>
						</div>
					</div>
				<div class="card-body">
					<div class="form">
						<form method="post" id="update_{! tableName !}" name="update_{! tableName !}"
							  action="@= site_url('/{! table !}-update') !php">
							<input type="hidden" name="{! primaryKey !}" id="{! primaryKey !}" value="@php echo $value['{! primaryKey !}']; !php">
{! editForm !}
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