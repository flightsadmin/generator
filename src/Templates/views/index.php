@= $this->extend('layouts/template'); !php
@= $this->section('content'); !php
<div class="container-fluid py-1">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
					<div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<div class="float-left">
								<h4>{! nameEntity !} Listing <h4>
							</div>
							<div>
							<a href="@php echo site_url('/{! table !}-form') !php" class="btn btn-success mb-2">Add {! nameEntity !}</a>
							</div>
						</div>
					</div>
					
				@php
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
				}
				!php
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" id="{! table !}-list">
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
											<a href="@php echo base_url('{! table !}-edit/'.$row['{! primaryKey !}']);!php" class="btn btn-primary btn-sm">Edit</a>
											<a onclick="return confirm('Are you sure?')" href="@php echo base_url('{! table !}-delete/'.$row['{! primaryKey !}']);!php" class="btn btn-danger btn-sm">Delete</a>
										</td>
									</tr>
								@php endforeach; !php
							@php endif; !php
							</tbody>
						</table>
						@= $pager->links() !php
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection(); !php