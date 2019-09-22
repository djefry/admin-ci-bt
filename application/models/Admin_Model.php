<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Model extends CI_Model
{
	public function getUser()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		return $data['user'];
	}

	public function getRole()
	{
		$data['role'] = $this->db->get('user_role')->result_array();
		return $data['role'];
	}

	public function getRoleAccess($id)
	{
		$data['roleaccess'] = $this->db->get_where('user_role', ['id' => $id])->row_array();
		return $data['roleaccess'];
	}
}
