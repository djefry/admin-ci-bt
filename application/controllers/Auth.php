<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		haveLogin();
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$data['title'] = 'Wandashare Login';
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = htmlspecialchars($this->input->post('email', true));
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];
					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
					Login failed! Please check your email and password.
					</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
				This email has not been activated!.
				</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
			Login failed! Please check your email and password.
			</div>');
			redirect('auth');
		}
	}

	public function register()
	{
		haveLogin();
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'This email has already registered !',
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
			'min_length' => 'Password too short !',
			'matches' => 'Password doesn\'t match !'
		]);
		$this->form_validation->set_rules('password_rt', 'Password', 'required|trim|matches[password]', [
			'required' => 'Re-type the password !'
		]);
		$data['title'] = 'Wandashare Registration';
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/register');
			$this->load->view('templates/auth_footer');
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'last_name' => htmlspecialchars($this->input->post('last_name', true)),
				'image' => 'default.png',
				'email' => htmlspecialchars($this->input->post('email', true)),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
				'date_created' => time(),
			];
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $this->input->post('email', true),
				'token' => $token,
				'date_created' => time()
			];
			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);
			$this->_sendEmail($token, 'verify');
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$this->db->where('email', $email);
		$data['user_token'] = $this->db->get('user_token')->row_array();
		if ($data['user_token'] == null) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Activation failed, wrong email!
		  </div>');
			redirect('auth');
		} else {
			if ($token == $data['user_token']['token']) {
				$this->db->where('email', $email);
				$this->db->delete('user_token');
				$this->db->where('email', $email);
				$this->db->update('user', ['is_active' => 1]);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Congratulations! your account has been activated. Please Login!
		  </div>');
				redirect('auth');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Activation failed!
		  </div>');
				redirect('auth');
			}
		}
	}

	private function _sendEmail($token, $type)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		//$config['smtp_timeout'] = '10';
		$config['smtp_user']    = 'djefryhentris@gmail.com';
		$config['smtp_pass']    = 'xxxxxx';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not   

		$this->email->initialize($config);

		if ($type == 'verify') {
			$this->email->from('djefryhentris@gmail.com', 'WandaShare');
			$this->email->to('djefryhentris@gmail.com');
			$this->email->subject('Account Verification');
			$this->email->message('<a href="' . base_url('auth/verify?email=') . $this->input->post('email', true) . '&token=' . urlencode($token) . '">Click this link to activate the account</a>');
			if (!$this->email->send()) {
				$this->email->print_debugger();
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulations! your account has been created. Please activate your account!
			  </div>');
			redirect('auth');
		} else if ($type == 'reset') {
			$this->email->from('djefryhentris@gmail.com', 'WandaShare');
			$this->email->to('djefryhentris@gmail.com');
			$this->email->subject('Reset Password');
			$this->email->message('<a href="' . base_url('auth/reset?email=') . $this->input->post('email', true) . '&token=' . urlencode($token) . '">Click this link to reset your password</a>');
			if (!$this->email->send()) {
				$this->email->print_debugger();
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Please check your email to reset you password!
			  </div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
		You have been Log Out!
		</div>');
		redirect('auth');
	}

	public function block()
	{
		$data['title'] = "Actions Block !";
		$this->load->view('auth/block', $data);
	}

	public function resetpassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$data['title'] = 'Wandashare Reset Password';
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/resetpassword');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('email');
			$data = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
			if ($data) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $this->input->post('email', true),
					'token' => $token,
					'date_created' => time()
				];
				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'reset');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Your email is not registered or activated!
				</div>');
				redirect('auth/resetpassword');
			}
		}
	}
	public function reset()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$this->db->where('email', $email);
		$data['user_token'] = $this->db->get('user_token')->row_array();
		if ($data['user_token'] == null) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Email not registered!
		  </div>');
			redirect('auth');
		} else {
			if ($token == $data['user_token']['token']) {
				$this->session->set_userdata('resetemail', $email);
				$this->changepassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Password reset failed!
		  </div>');
				redirect('auth');
			}
		}
	}
	public function changepassword()
	{
		$email = $this->session->userdata('resetemail');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[3]');
		$this->form_validation->set_rules('password1', 'Password1', 'required|matches[password]');
		$data['title'] = 'Wandashare Change Password';
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/changepassword');
			$this->load->view('templates/auth_footer');
		} else {
			$password = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
			$this->db->where('email', $email);
			$this->db->update('user', ['password' => $password]);
			$this->db->where('email', $email);
			$this->db->delete('user_token');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Password for ' . $email . ' has changed !
		  </div>');
			redirect('auth');
		}
	}
}
