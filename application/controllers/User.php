<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function cariBarang()
    {
        $data['title'] = 'Cari Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('User_model', 'barang');

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
        $config['base_url'] = 'http://localhost/sivenlab-ugm/user/caribarang/';
        $this->db->like('barang', $data['keyword']);
        $this->db->from('user_barang');
        $this->db->where(['bisa_dipinjam' => 1]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['search'] = $this->barang->getSearchBarang($config['per_page'], $data['start'], $data['keyword']);
        // 

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/caribarang', $data);
        $this->load->view('templates/footer');
    }

    public function pinjamBarang()
    {
        $this->load->model('User_model', 'barang');

        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('jumlah', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('tanggal_kembali', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('user/caribarang/');
        } else {
            $this->barang->getPinjamBarang();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diajukan!</div>');
            redirect('user/statuspeminjaman/');
        }
    }
    public function statusPeminjaman()
    {
        $data['title'] = 'Status Peminjaman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('User_model', 'barang');

        $user_id = $this->session->userdata('id');

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
        $config['base_url'] = 'http://localhost/sivenlab-ugm/user/caribarang/';
        $this->db->like('barang_barang', $data['keyword']);
        $this->db->from('user_pinjam');
        $this->db->where(['user_id' => $user_id]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        // 

        $data['pinjamdong'] = $this->barang->getMauPinjam($user_id, $config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/statuspeminjaman', $data);
        $this->load->view('templates/footer');
    }
}
