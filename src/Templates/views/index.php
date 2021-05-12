@= $this->extend('layouts/default'); !php
@= $this->section('content'); !php
<div class="container-fluid mt-2">
	<div class="row justify-contents-center">
		<div class="col-md-12">
			<div class="d-flex justify-content-between align-items-center">
				<h4>{! nameEntity !} Listing <h4>
				<a href="@php echo site_url('/{! table !}/add') !php" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> Add {! nameEntity !}</a>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-sm">
					<thead class="thead">
					<tr>
{! fieldsTh !}
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					@php if(${! table !}): !php
						@php foreach(${! table !} as $row): !php
							<tr>
{! fieldsTd !}
								<td>
									<a href="@php echo base_url('{! table !}/edit/'.$row['{! primaryKey !}']);!php"><i class="bi bi-pencil text-primary"></i></a>
									<a onclick="return confirm('Are you sure you want to delete this {! singularTable !}?')" href="@php echo base_url('{! table !}/delete/'.$row['{! primaryKey !}']);!php"><i class="bi bi-trash text-danger pl-2"></i></a>
								</td>
							</tr>
						@php endforeach; !php
					@php endif; !php
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@= $this->endSection(); !php