<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
	}
	public function index()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "My Profile";
		$this->load->view("templates/user_header", $data);
		$this->load->view("templates/user_sidebar");
		$this->load->view("templates/user_topbar");
		$this->load->view("user/index");
		$this->load->view("templates/user_footer");
	}

	public function editprofile()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('last_name', 'Last_Name', 'required|trim');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Edit Profile";
		if ($this->form_validation->run() == false) {
			$this->load->view("templates/user_header", $data);
			$this->load->view("templates/user_sidebar");
			$this->load->view("templates/user_topbar");
			$this->load->view("user/editprofile");
			$this->load->view("templates/user_footer");
		} else {
			$old_image = $data['user']['image'];
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$last_name = $this->input->post('last_name');
			$image = $_FILES['image']['name'];
			if (empty($image)) {
				$image = $old_image;
			} else {
				if ($old_image != 'default.png') {
					unlink(FCPATH . 'assets/img/profile/' . $old_image);
				}
				$config['upload_path'] = './assets/img/profile/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']     = '1024';
				$this->load->library('upload', $config);
				$this->upload->do_upload('image');
				$image = $this->upload->data('file_name');
			}
			$user = [
				'name' => $name,
				'last_name' => $last_name,
				'image' => $image
			];
			$this->db->where('id', $id);
			$this->db->update('user', $user);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Profile have been edited !
					</div>');
			redirect('user/editprofile');
		}
	}
	public function changepassword()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$password = $data['user']['password'];
		$this->form_validation->set_rules('old_password', 'Old_Password', 'required|trim', [
			'required' => 'Old password cannot empty!'
		]);
		$this->form_validation->set_rules('new_password', 'New_Password', 'required|trim|min_length[3]', [
			'required' => 'New password cannot empty!',
			'min_length' => 'Password is too short!'
		]);
		$this->form_validation->set_rules('new_password2', 'New_Password2', 'required|trim|matches[new_password]', [
			'required' => 'Re-type the new password!',
			'matches' => 'Password not match!'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = "Change Password";
			$this->load->view("templates/user_header", $data);
			$this->load->view("templates/user_sidebar");
			$this->load->view("templates/user_topbar");
			$this->load->view("user/changepassword");
			$this->load->view("templates/user_footer");
		} else {
			$old_password = $this->input->post('old_password');
			if (password_verify($old_password, $password)) {
				$id = $this->input->post('id');
				$new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
				if (password_verify($old_password, $new_password)) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					New password cannot be the same as old password !
					</div>');
					redirect('user/changepassword');
				} else {
					$this->db->set('password', $new_password);
					$this->db->where('id', $id);
					$this->db->update('user');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Password changed !
					</div>');
					redirect('user/changepassword');
				}
			} else {
				$this->session->set_flashdata('not_match', '<small class="text-danger pl-3">Old password doesn\'t match!</small>');
				redirect('user/changepassword');
			}
		}
	}
}
