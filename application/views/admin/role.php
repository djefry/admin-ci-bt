<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Role Management</h1>
	<div class="row">
		<div class="col col-lg-6">
			<?= form_error('newrole', '<div class="alert alert-danger">', '</div>'); ?>
			<?= $this->session->flashdata('message'); ?>
			<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMenuModal">Add New Role</a>
			<table class="table table-hover">
				<thead></thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Role</th>
					<th scope="col">Actions</th>
				</tr>
				<tbody>
					<?php
					$i = 1;
					foreach ($role as $r) :
						?>
						<tr>
							<th scope="row"><?= $i; ?></th>
							<td>
								<p class="text-capitalize"> <?= $r['role']; ?></p>
							</td>
							<td>
								<a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-warning">Access</a> |
								<a href="" class="badge badge-success" onclick="setId(<?= $r['id']; ?>,'<?= $r['role']; ?>')" data-toggle="modal" data-target="#editMenuModal">Edit</a> |
								<a href="" class="badge badge-danger" onclick="delId(<?= $r['id']; ?>,'<?= $r['role']; ?>')" data-toggle="modal" data-target="#deleteModal">Delete</a>
							</td>
						</tr>
						<?php $i++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add New Menu -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addMenuModalTitle">Add New Role</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/role'); ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="newrole" name="newrole" placeholder="Role Name">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editMenuModalTitle">Edit Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="editMenu" action="" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="editMenuInput" name="editMenuInput" placeholder="New Menu">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Ok</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Delete Menu -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalTitle">Delete Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="deleteMenu" action="" method="POST">
				<div class="modal-body">
					<div class="form-group">
						Are you sure to delete menu <span class="text-capitalize" id="delMenuName"></span>?
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Ok</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	function setId(pk, nm) {
		document.getElementById('editMenu').action = "editrole/" + pk;
		document.getElementById('editMenuInput').value = nm;
	}

	function delId(pk, nm) {
		document.getElementById('deleteMenu').action = "deleterole/" + pk;
		document.getElementById('delMenuName').innerHTML = nm;
	}
</script>
