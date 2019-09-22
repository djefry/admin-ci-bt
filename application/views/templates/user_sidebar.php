<!-- Page Wrapper -->
<div id="wrapper">

	<!-- Sidebar -->
	<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		<!-- Sidebar - Brand -->
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
			<div class="sidebar-brand-icon rotate-n-15">
				<i class="fas fa-address-card"></i>
			</div>
			<div class="sidebar-brand-text mx-2">WandaShare<sup>&reg;</sup></div>
		</a>


		<!-- Query Menu Melakukan join dari 3 tabel-->
		<?php
		$role_id = $this->session->userdata('role_id');
		$queryMenu =   "SELECT user_menu.id, menu FROM user_menu
						JOIN user_access_menu 
						ON user_menu.id=user_access_menu.menu_id 
						WHERE user_access_menu.role_id=$role_id 
						ORDER BY user_access_menu.menu_id ASC
						";
		$menu = $this->db->query($queryMenu)->result_array();
		?>

		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<!-- Looping Menu -->
		<?php foreach ($menu as $m) : ?>
			<div class="sidebar-heading">
				<?= $m['menu']; ?>
			</div>

			<!-- Lopping sub menu -->
			<?php
			$submenuId = $m['id'];
			$querySubMenu = "SELECT * FROM user_submenu
							WHERE user_submenu.menu_id=$submenuId
							AND user_submenu.is_active = '1'
							";
			$submenu = $this->db->query($querySubMenu)->result_array();
			//var_dump($submenu);
			//die;
			?>
			<?php foreach ($submenu as $sm) : ?>

				<!-- Nav Item - Dashboard -->
				<?php if ($sm['title'] == $title) : ?>
					<li class="nav-item active">
					<?php else : ?>
					<li class="nav-item">
					<?php endif; ?>
					<a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
						<i class="<?= $sm['icon']; ?>"></i>
						<span><?= $sm['title']; ?></span></a>
				</li>

			<?php endforeach; ?>

			<!-- Divider -->
			<hr class="sidebar-divider mt-3">

		<?php endforeach; ?>

		<!-- Sidebar Toggler (Sidebar) -->
		<div class="text-center d-none d-md-inline">
			<button class="rounded-circle border-0" id="sidebarToggle"></button>
		</div>

	</ul>
	<!-- End of Sidebar -->
