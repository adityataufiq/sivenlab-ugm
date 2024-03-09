<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function getRole($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('role', $keyword);
        }

        return $this->db->get('user_role', $limit, $start)->result_array();
    }

    public function getUserRole($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('name', $keyword);
        }

        $this->db->join('user', 'user.role_id=user_role.id');
        return $this->db->get('user_role', $limit, $start)->result_array();
    }

    public function getAllRole($id)
    {
        $this->db->from('user')->join('user_role', 'user_role.id=user.role_id')->get();
        return $this->db->get_where('user_role', ['id' => $id])->result_array();
    }
}
