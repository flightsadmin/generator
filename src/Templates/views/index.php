@= $this->extend('layouts/template'); !php
@= $this->section('content'); !php
<div class="container-fluid py-1">
	<div class="row justify-contents-center">
		<div class="col-md-12">
			<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-between align-items-center">
							<h4>{! nameEntity !} Listing <h4>
							<a href="@php echo site_url('/{! table !}-form') !php" class="btn btn-success"><i class="fa fa-plus"></i> Add {! nameEntity !}</a>
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
											<a href="@php echo base_url('{! table !}-edit/'.$row['{! primaryKey !}']);!php"><i class="fa fa-edit text-primary"></i></a>
											<a onclick="return confirm('Are you sure?')" href="@php echo base_url('{! table !}-delete/'.$row['{! primaryKey !}']);!php"><i class="fa fa-trash text-danger pl-2"></i></a>
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