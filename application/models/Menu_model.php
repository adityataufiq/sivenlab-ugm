<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    // public function getSubMenu()
    // {
    //     $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
    //               FROM `user_sub_menu` JOIN `user_menu`
    //               ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
    //             ";

    //     return $this->db->query($query)->result_array();
    // }

    public function getMenu($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('menu', $keyword);
        }

        return $this->db->get('user_menu', $limit, $start)->result_array();
    }

    public function getSubMenu($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('title', $keyword);
        }

        $this->db->join('user_menu', 'user_menu.id=user_sub_menu.menu_id');
        return $this->db->get('user_sub_menu', $limit, $start)->result_array();
    }

    public function ubahDataMenu()
    {
        $data = [
            'menu' => $this->input->post('menu', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_menu', $data);
    }

    public function hapusDataMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    public function ubahDataSubMenu()
    {
        $data = [
            'title' => $this->input->post('title', true),
            'menu_id' => $this->input->post('menu_id', true),
            'url' => $this->input->post('url', true),
            'icon' => $this->input->post('icon', true),
            'is_active' => $this->input->post('is_active', true)
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_sub_menu', $data);
    }

    public function hapusDataSubMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }
}
