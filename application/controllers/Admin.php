<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('Admin_Model', 'admin');
		$this->load->model('Menu_Model', 'menu');
	}
	public function index()
	{
		$data['user'] = $this->admin->getUser();
		$data['title'] = "Dashboard";
		$this->load->view("templates/user_header", $data);
		$this->load->view("templates/user_sidebar");
		$this->load->view("templates/user_topbar");
		$this->load->view("admin/index");
		$this->load->view("templates/user_footer");
	}
	public function role()
	{
		$this->form_validation->set_rules('newrole', 'NewRole', 'required|trim', [
			'required' => 'Role name required !'
		]);
		if ($this->form_validation->run() == false) {
			$data['user'] = $this->admin->getUser();
			$data['role'] = $this->admin->getRole();
			$data['title'] = "Role";
			$this->load->view("templates/user_header", $data);
			$this->load->view("templates/user_sidebar");
			$this->load->view("templates/user_topbar");
			$this->load->view("admin/role");
			$this->load->view("templates/user_footer");
		} else {
			$role = $this->input->post('newrole');
			$this->db->insert('user_role', ['role' => $role]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					New role added !
					</div>');
			redirect('admin/role');
		}
	}

	public function editrole($id)
	{
		$this->db->where('user_role.id', $id);
		$this->db->update('user_role', ['role' => $this->input->post('editMenuInput')]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Role successfully edited !
					</div>');
		redirect('admin/role');
	}
	public function deleterole($id)
	{
		$this->db->where('user_role.id', $id);
		$this->db->delete('user_role');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Role successfully deleted !
					</div>');
		redirect('admin/role');
	}

	public function roleaccess($id)
	{
		$data['user'] = $this->admin->getUser();
		$data['roleaccess'] = $this->admin->getRoleAccess($id);
		$data['menu'] = $this->menu->getMenu();
		$data['title'] = "Role";
		$this->load->view("templates/user_header", $data);
		$this->load->view("templates/user_sidebar");
		$this->load->view("templates/user_topbar");
		$this->load->view("admin/roleaccess");
		$this->load->view("templates/user_footer");
	}

	public function saveroleaccess($id)
	{
		$data = $this->db->get('user_menu')->result_array();
		foreach ($data as $d) {
			if ($d['menu'] != 'admin') {
				if (!empty($this->input->post($d['id']))) {
					$this->db->where('role_id', $id);
					$this->db->where('menu_id', $d['id']);
					$check = $this->db->get('user_access_menu');
					if ($check->num_rows() < 1) {
						$this->db->insert('user_access_menu', ['role_id' => $id, 'menu_id' => $d['id']]);
					}
				} else {
					$this->db->where('role_id', $id);
					$this->db->where('menu_id', $d['id']);
					$check = $this->db->get('user_access_menu');
					if ($check->num_rows() > 0) {
						$this->db->where('role_id', $id);
						$this->db->where('menu_id', $d['id']);
						$this->db->delete('user_access_menu');
					}
				}
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Access Changed !
					</div>');
		redirect('admin/roleaccess/' . $id);
	}
}
