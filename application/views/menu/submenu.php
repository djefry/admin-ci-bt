<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Submenu Management</h1>
	<div class="row">
		<div class="col col-lg">
			<?= form_error(
				'title',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">',
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    		<span aria-hidden="true">&times;</span>
  			</button></div>'
			); ?>
			<?= form_error(
				'menu',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">',
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    		<span aria-hidden="true">&times;</span>
  			</button></div>'
			); ?>
			<?= form_error(
				'url',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">',
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    		<span aria-hidden="true">&times;</span>
  			</button></div>'
			); ?>
			<?= form_error(
				'icon',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">',
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    		<span aria-hidden="true">&times;</span>
  			</button></div>'
			); ?>
			<?= $this->session->flashdata('message'); ?>
			<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSubmenuModal">Add New Submenu</a>
			<table class="table table-hover">
				<thead></thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Title</th>
					<th scope="col">Menu</th>
					<th scope="col">Url</th>
					<th scope="col">Icon</th>
					<th scope="col">State</th>
					<th scope="col">Actions</th>
				</tr>
				<tbody>
					<?php
					$i = 1;
					foreach ($submenu as $sm) :
						?>
						<tr>
							<th scope="row"><?= $i; ?></th>
							<td><?= $sm['title']; ?></td>
							<td>
								<p class="text-capitalize"><?= $sm['menu']; ?></p>
							</td>
							<td><?= $sm['url']; ?></td>
							<td><span class="<?= $sm['icon']; ?>"></span></td>
							<td><?php if ($sm['is_active'] == 1) {
									echo 'Active';
								} else {
									echo 'Unactive';
								} ?></td>
							<td>
								<a href="" class="badge badge-success" data-toggle="modal" data-target="#editSubmenuModal" onclick="editId(<?= $sm['id']; ?>,'<?= $sm['title']; ?>',<?= $sm['menu_id']; ?>,'<?= $sm['url']; ?>','<?= $sm['icon']; ?>',<?= $sm['is_active']; ?>)">Edit</a> |
								<a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteSubmenuModal" onclick="delId(<?= $sm['id']; ?>,'<?= $sm['title']; ?>')">Delete</a>
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
<div class="modal fade" id="addSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="addSubmenuModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addSubmenuModalTitle">Add New Submenu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('menu/submenu'); ?>" method="POST">
				<div class="modal-body">
					<div class="form-group row">
						<label for="title" class="col-sm-2 col-form-label">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group row">
						<label for="menu" class="col-sm-2 col-form-label">Parent</label>
						<div class="col-sm-10">
							<select type="text" class="form-control" id="menu" name="menu">
								<option value="">-- Select Menu --</option>
								<?php foreach ($menu as $m) : ?>
									<option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="url" class="col-sm-2 col-form-label">Url</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="url" name="url" placeholder="Url Menu">
						</div>
					</div>
					<div class="form-group row">
						<label for="icon" class="col-sm-2 col-form-label">Icon</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="icon" name="icon" placeholder="Icon Menu">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
								<label class="form-check-label" for="gridCheck1">
									Active
								</label>
							</div>
						</div>
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

<!-- Modal Edit SubMenu -->
<div class="modal fade" id="editSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="editSubmenuModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editSubmenuModalTitle">Edit Submenu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" id="editSubmenu" method="POST">
				<div class="modal-body">
					<div class="form-group row">
						<label for="editTitle" class="col-sm-2 col-form-label">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="editTitle" name="editTitle">
						</div>
					</div>
					<div class="form-group row">
						<label for="editMenu" class="col-sm-2 col-form-label"></label>
						<div class="col-sm-10">
							<select type="text" class="form-control" id="editMenu" name="editMenu">
								<option value="">-- Select Menu --</option>
								<?php foreach ($menu as $m) : ?>
									<option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="editUrl" class="col-sm-2 col-form-label">Url</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="editUrl" name="editUrl" placeholder="Url Menu">
						</div>
					</div>
					<div class="form-group row">
						<label for="editIcon" class="col-sm-2 col-form-label">Icon</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="editIcon" name="editIcon" placeholder="Icon Menu">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="editIs_active" name="editIs_active" checked>
								<label class="form-check-label" for="gridCheck1">
									Active
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Delete Submenu -->
<div class="modal fade" id="deleteSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteSubmenuModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteSubmenuModalTitle">Delete Submenu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="deleteSubMenu" action="" method="POST">
				<div class="modal-body">
					<div class="form-group">
						Are you sure want to delete submenu <span class="text-capitalize" id="delSubMenuName"></span>?
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

<script type="text/javascript">
	function editId(id, title, menu_id, url, icon, is_active) {
		document.getElementById('editSubmenu').action = "editsub/" + id;
		document.getElementById('editTitle').value = title;
		document.getElementById('editMenu').value = menu_id;
		document.getElementById('editUrl').value = url;
		document.getElementById('editIcon').value = icon;
		if (is_active == 1) {
			document.getElementById('editIs_active').checked = true;
		} else {
			document.getElementById('editIs_active').checked = false;
		}
	}

	function delId(id, title) {
		document.getElementById('deleteSubMenu').action = "deletesub/" + id;
		document.getElementById('delSubMenuName').innerHTML = title;
	}
</script>
