<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_Model extends CI_Model
{
	public function editSubModel($id)
	{
		if (!empty($this->input->post('editIs_active'))) {
			$active = 1;
		} else {
			$active = 0;
		}
		$data = [
			'menu_id' => $this->input->post('editMenu'),
			'title' => $this->input->post('editTitle'),
			'url' => $this->input->post('editUrl'),
			'icon' => $this->input->post('editIcon'),
			'is_active' => $active
		];
		$this->db->where('user_submenu.id', $id);
		$this->db->update('user_submenu', $data);
	}
	public function getMenu()
	{
		$data['menu'] = $this->db->get('user_menu')->result_array();
		return $data['menu'];
	}
}
