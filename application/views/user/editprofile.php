<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Edit Profile</h1>

	<div class="row">
		<div class="col-md-8">
			<?= $this->session->flashdata('message'); ?>
			<form action="<?= base_url('user/editprofile'); ?>" method="POST" enctype="multipart/form-data">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
					<div class="col-sm-10">
						<input type="hidden" name="id" value="<?= $user['id']; ?>">
						<input type="email" disabled class="form-control" id="inputEmail3" name="email" placeholder="<?= $user['email']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 col-form-label">Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputPassword3" name="name" value="<?= $user['name']; ?>">
						<?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 col-form-label">Last Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputPassword3" name="last_name" value="<?= $user['last_name']; ?>">
						<?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-2">Picture</div>
					<div class="form-group row">
						<div class="col-sm-4"><img src="<?= base_url('assets/img/profile/' . $user['image']); ?>" width="100"></div>
						<div class="col-sm-4"><input type="file" name="image" id="image"></div>
					</div>
				</div>
				<div class="form-group row justify-content-end">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
