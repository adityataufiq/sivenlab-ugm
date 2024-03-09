<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('Menu_model', 'menu');

        // load library
        $this->load->library('pagination');

        // ambil data keyword
        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->unset_userdata('keyword');
        }

        // config
        $config['base_url'] = 'http://localhost/sivenlab-ugm/menu/index/';
        $this->db->like('menu', $data['keyword']);
        $this->db->from('user_menu');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['menu'] = $this->menu->getMenu($config['per_page'], $data['start'], $data['keyword']);
        //

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambahMenu()
    {
        $this->form_validation->set_rules('menu', 'Menu Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('menu');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Menu Added!</div>');
            redirect('menu');
        }
    }

    public function ubahMenu()
    {
        $this->load->model('Menu_model', 'menu');

        $this->form_validation->set_rules('menu', 'Menu Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('menu');
        } else {
            $this->menu->ubahDataMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('menu');
        }
    }

    public function hapusMenu()
    {
        $this->load->model('Menu_model', 'menu');
        $id = $this->input->post('id');

        $this->menu->hapusDataMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('menu');
    }

    public function submenu()
    {
        $data['title'] = 'Sub Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();
        $this->load->model('Menu_model', 'menu');

        // load library
        $this->load->library('pagination');

        // ambil data keyword
        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->unset_userdata('keyword');
        }

        // config
        $config['base_url'] = 'http://localhost/sivenlab-ugm/menu/submenu/';
        $this->db->like('title', $data['keyword']);
        $this->db->from('user_sub_menu');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['subMenu'] = $this->menu->getSubMenu($config['per_page'], $data['start'], $data['keyword']);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('templates/footer');
    }

    public function tambahSubMenu()
    {
        $this->form_validation->set_rules('title', 'Sub Menu Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Sub Menu Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('menu_id', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('url', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error4' => form_error('icon', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('menu/submenu');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Sub Menu Added!</div>');
            redirect('menu/submenu');
        }
    }

    public function ubahSubMenu()
    {
        $this->load->model('Menu_model', 'menu');

        $this->form_validation->set_rules('title', 'Sub Menu Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Sub Menu Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('menu_id', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('url', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error4' => form_error('icon', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('menu/submenu');
        } else {
            $this->menu->ubahDataSubMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('menu/submenu');
        }
    }

    public function hapusSubMenu()
    {
        $this->load->model('Menu_model', 'menu');
        $id = $this->input->post('id');

        $this->menu->hapusDataSubMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('menu/submenu');
    }
}
