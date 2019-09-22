<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800 text-capitalize">Role Access For : <?= $roleaccess['role']; ?></h1>
	<div class="row">
		<div class="col col-lg-6">
			<?= $this->session->flashdata('message'); ?>
			<form action="<?= base_url('admin/saveroleaccess/') . $roleaccess['id']; ?>" method="post">
				<table class="table table-hover">
					<thead></thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Menu</th>
						<th scope="col">Access</th>
					</tr>
					<tbody>
						<?php
						$i = 1;
						foreach ($menu as $m) :
							if ($m['menu'] != 'admin') {
								?>
								<tr>
									<th scope="row"><?= $i; ?></th>
									<td>
										<p class="text-capitalize"> <?= $m['menu']; ?></p>
									</td>
									<td>
										<input type="checkbox" value="1" name="<?= $m['id']; ?>" <?= checkAccess($roleaccess['id'], $m['id']); ?>></td>
									</td>
								</tr>
								<?php $i++;
							}
						endforeach; ?>
					</tbody>
				</table>
				<a href="<?= base_url('admin/role'); ?>" class="btn btn-primary mb-3">Back</a> &nbsp;&nbsp;&nbsp; <button type="submit" class="btn btn-primary mb-3">Save</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
