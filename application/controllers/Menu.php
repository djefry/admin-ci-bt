<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('Menu_Model', 'menu');
	}
	public function index()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('newmenu', 'NewMenu', 'required|trim', [
			'required' => 'Menu name is required!'
		]);
		if ($this->form_validation->run() == false) {
			$data['title'] = "Menu Management";
			$data['menu'] = $this->menu->getMenu();
			$this->load->view("templates/user_header", $data);
			$this->load->view("templates/user_sidebar");
			$this->load->view("templates/user_topbar");
			$this->load->view("menu/index");
			$this->load->view("templates/user_footer");
		} else {
			$newmenu = $this->input->post('newmenu');
			$this->db->insert('user_menu', ['menu' => $newmenu]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					New menu added !
					</div>');
			redirect('menu');
		}
	}

	public function submenu()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if (empty($this->session->userdata('email'))) {
			redirect(base_url());
		} else {
			$this->form_validation->set_rules('title', 'Title', 'required|trim', [
				'required' => 'Menu title is required!'
			]);
			$this->form_validation->set_rules('menu', 'Menu', 'required|trim', [
				'required' => 'Menu Parent is required!'
			]);
			$this->form_validation->set_rules('url', 'Url', 'required|trim', [
				'required' => 'Menu url is required!'
			]);
			$this->form_validation->set_rules('icon', 'Icon', 'required|trim', [
				'required' => 'Menu icon is required!'
			]);

			if ($this->form_validation->run() == false) {
				$data['title'] = "Submenu Management";
				$querySM = "SELECT user_submenu.id, menu_id, menu, title, url, icon, is_active FROM user_menu
							JOIN user_submenu
							ON user_submenu.menu_id = user_menu.id
							";
				$queryM = "SELECT * from `user_menu`";
				$data['menu'] = $this->db->query($queryM)->result_array();
				$data['submenu'] = $this->db->query($querySM)->result_array();
				$this->load->view("templates/user_header", $data);
				$this->load->view("templates/user_sidebar");
				$this->load->view("templates/user_topbar");
				$this->load->view("menu/submenu");
				$this->load->view("templates/user_footer");
			} else {
				if (!empty($this->input->post('is_active'))) {
					$isActive = 1;
				} else {
					$isActive = 0;
				}
				$data = [
					'menu_id' => $this->input->post('menu'),
					'title' => $this->input->post('title'),
					'url' => $this->input->post('url'),
					'icon' => $this->input->post('icon'),
					'is_active' => $isActive
				];
				$this->db->insert('user_submenu', $data);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					New submenu added !
					</div>');
				redirect('menu/submenu');
			}
		}
	}

	public function edit($id)
	{
		$this->db->where('user_menu.id', $id);
		$this->db->update('user_menu', ['menu' => $this->input->post('editMenuInput')]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Menu successfully edited !
					</div>');
		redirect('menu');
	}
	public function delete($id)
	{
		$this->db->where('user_menu.id', $id);
		$this->db->delete('user_menu');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Menu successfully deleted !
					</div>');
		redirect('menu');
	}

	public function editsub($id)
	{
		$this->menu->editSubModel($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Submenu successfully edited !
					</div>');
		redirect('menu/submenu');
	}

	public function deletesub($id)
	{
		$this->db->where('user_submenu.id', $id);
		$this->db->delete('user_submenu');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Submenu successfully deleted !
					</div>');
		redirect('menu/submenu');
	}
}
