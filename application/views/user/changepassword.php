<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Edit Password</h1>

	<div class="row">
		<div class="col-md-8">
			<?= $this->session->flashdata('message'); ?>
			<form action="<?= base_url('user/changepassword'); ?>" method="POST" enctype="multipart/form-data">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
					<div class="col-sm-6">
						<input type="hidden" name="id" value="<?= $user['id']; ?>">
						<input type="email" disabled class="form-control" id="inputEmail3" name="email" placeholder="<?= $user['email']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">Old Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="inputPassword3" name="old_password" value="">
						<?= $this->session->flashdata('not_match'); ?>
						<?= form_error('old_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">New Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="inputPassword3" name="new_password" value="">
						<?= form_error('new_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">Re-type New Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="inputPassword3" name="new_password2" value="">
						<?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
				</div>
				<div class="form-group row justify-content-end">
					<div class="col-sm-8">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
