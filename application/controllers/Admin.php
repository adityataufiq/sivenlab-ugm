<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $data['total_barang'] = $this->db->get('user_barang')->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('Role_model', 'user_role');

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
        $config['base_url'] = 'http://localhost/sivenlab-ugm/admin/datapengguna/';
        $this->db->like('role', $data['keyword']);
        $this->db->from('user_role');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['role'] = $this->user_role->getRole($config['per_page'], $data['start'], $data['keyword']);
        //

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function tambahRole()
    {
        $this->form_validation->set_rules('role', 'Role Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('role', '<div class="alert alert-danger" role="alert">', '</div>')
            ];
            $this->session->set_flashdata($data);
            redirect('admin/role');
        } else {
            $data = [
                'role' => $this->input->post('role'),
            ];

            $this->db->insert('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('admin/role');
        }
    }

    public function ubahRole()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $this->form_validation->set_rules('role', 'Role Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('role', '<div class="alert alert-danger" role="alert">', '</div>')
            ];
            $this->session->set_flashdata($data);
            redirect('admin/role');
        } else {
            $this->laboratorium->ubahDataRole();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('admin/role/');
        }
    }

    public function hapusRole()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $id = $this->input->post('id');

        $this->laboratorium->hapusDataRole($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('admin/role/');
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Access Changed!</div>');
    }

    public function dataPengguna()
    {
        $data['title'] = 'Data Pengguna';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();
        $this->load->model('Role_model', 'user_role');

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
        $config['base_url'] = 'http://localhost/sivenlab-ugm/admin/datapengguna/';
        $this->db->like('name', $data['keyword']);
        $this->db->from('user');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['role'] = $this->user_role->getUserRole($config['per_page'], $data['start'], $data['keyword']);
        //

        $data['role_id'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datapengguna', $data);
        $this->load->view('templates/footer');
    }

    public function tambahPengguna()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[8]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('role_id', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error4' => form_error('password1', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error5' => form_error('password2', '<div class="alert alert-danger" role="alert">', '</div>')
            ];
            $this->session->set_flashdata($data);
            redirect('admin/datapengguna');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('admin/datapengguna');
        }
    }

    public function hapusPengguna()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $id = $this->input->post('id');

        $this->laboratorium->hapusDataPengguna($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('admin/datapengguna/');
    }
}
