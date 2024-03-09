<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kalaboran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function lab()
    {
        $data['title'] = 'Data Laboratorium';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();
        $this->load->model('Lab_model', 'laboratorium');

        $kalaboran_id = $this->session->userdata('id');

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
        $this->db->like('laboratorium', $data['keyword']);
        $this->db->from('user_laboratorium');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['lab'] = $this->laboratorium->getAllLab($kalaboran_id, $config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/lab', $data);
        $this->load->view('templates/footer');
    }

    public function tambahLab()
    {
        $this->form_validation->set_rules('kode', 'Kode Laboratorium', 'required');
        $this->form_validation->set_rules('laboratorium', 'Nama Laboratorium', 'required');
        $this->form_validation->set_rules('departemen', 'Departemen / Program Studi', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('laboratorium', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('departemen', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/lab');
        } else {
            $data = [
                'kode' => $this->input->post('kode'),
                'laboratorium' => $this->input->post('laboratorium'),
                'departemen' => $this->input->post('departemen'),
                'kalaboran_id' => $this->session->userdata('id'),
                'kalaboran_name' => $this->session->userdata('name'),
            ];

            $this->db->insert('user_laboratorium', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('kalaboran/lab');
        }
    }

    public function ubahLab()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $this->form_validation->set_rules('kode', 'Kode Laboratorium', 'required');
        $this->form_validation->set_rules('laboratorium', 'Nama Laboratorium', 'required');
        $this->form_validation->set_rules('departemen', 'Departemen / Program Studi', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('laboratorium', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('departemen', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/lab');
        } else {
            $this->laboratorium->ubahDataLab();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('kalaboran/lab');
        }
    }

    public function hapusLab()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $id = $this->input->post('id');
        $this->laboratorium->hapusDataLab($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('kalaboran/lab');
    }

    public function layanan($laboratorium_id)
    {
        $data['title'] = 'Data Laboratorium';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();
        $this->load->model('Lab_model', 'laboratorium');

        // load library
        $this->load->library('pagination');
        $this->load->helper('url');

        // ambil data keyword
        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->unset_userdata('keyword');
        }

        // config
        $config['base_url'] = site_url('kalaboran/layanan/' . $laboratorium_id . '/');
        $this->db->like('layanan', $data['keyword']);
        // $this->db->or_like('email', $data['keyword']);
        $this->db->from('user_laboratorium')->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->where(['laboratorium_id' => $laboratorium_id]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 4;
        $config['per_page'] = 8;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(4);
        $data['layanan'] = $this->laboratorium->getSearchLayanan($laboratorium_id, $config['per_page'], $data['start'], $data['keyword']);
        //

        $data['lab'] = $this->laboratorium->getLab($laboratorium_id);
        $data['laboran'] = $this->laboratorium->getLaboran();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/layanan', $data);
        $this->load->view('templates/footer');
    }

    public function tambahLayanan()
    {
        $laboratorium_id = $this->input->post('laboratorium_id');

        $this->form_validation->set_rules('kode', 'Kode Layanan', 'required');
        $this->form_validation->set_rules('layanan', 'Nama Layanan', 'required');
        $this->form_validation->set_rules('laboran_id', 'Nama Laboran', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('layanan', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('laboran_id', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/layanan/' . $laboratorium_id);
        } else {
            $data = [
                'laboratorium_id' => $this->input->post('laboratorium_id'),
                'kode' => $this->input->post('kode'),
                'layanan' => $this->input->post('layanan'),
                'kalaboran_id' => $this->input->post('kalaboran_id'),
                'laboran_id' => $this->input->post('laboran_id'),
                'laboran_name' => $this->input->post('laboran_name')
            ];

            $this->db->insert('user_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('kalaboran/layanan/' . $laboratorium_id);
        }
    }

    public function ubahLayanan()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $laboratorium_id = $this->input->post('laboratorium_id');

        $this->form_validation->set_rules('kode', 'Kode Layanan', 'required');
        $this->form_validation->set_rules('layanan', 'Nama Layanan', 'required');
        $this->form_validation->set_rules('laboran_id', 'Nama Laboran', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('layanan', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('laboran_id', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/layanan/' . $laboratorium_id);
        } else {
            $this->laboratorium->ubahDataLayanan();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('kalaboran/layanan/' . $laboratorium_id);
        }
    }

    public function hapusLayanan()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $id = $this->input->post('id');
        $user_layanan = $this->db->get_where('user_layanan', ['id' => $id])->row_array();
        $data = [
            'laboratorium_id' => $user_layanan['laboratorium_id'],
        ];
        $this->session->set_userdata($data);

        $this->laboratorium->hapusDataLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('kalaboran/layanan/' . $this->session->userdata('laboratorium_id'));
    }

    public function dataBarang($layanan_id)
    {
        $data['title'] = 'Data Laboratorium';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('Lab_model', 'laboratorium');

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
        $config['base_url'] = 'http://localhost/sivenlab-ugm/kalaboran/databarang/' . $layanan_id;
        $this->db->like('barang', $data['keyword']);
        // $this->db->or_like('email', $data['keyword']);
        $this->db->from('user_layanan')->join('user_barang', 'user_barang.layanan_id=user_layanan.id');
        $this->db->where(['layanan_id' => $layanan_id]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(4);
        $data['barang'] = $this->laboratorium->getSearchBarang($layanan_id, $config['per_page'], $data['start'], $data['keyword']);

        $data['layanan'] = $this->laboratorium->getOneLayanan($layanan_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/databarang', $data);
        $this->load->view('templates/footer');
    }

    public function tambahBarang()
    {
        $layanan_id = $this->input->post('layanan_id');

        $this->form_validation->set_rules('kode', 'Kode Barang', 'required');
        $this->form_validation->set_rules('barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah_baik', 'Jumlah Barang Kondisi Baik', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('barang', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('jumlah_baik', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/databarang/' . $layanan_id);
        } else {
            $data = [
                'laboratorium_id' => $this->input->post('laboratorium_id'),
                'layanan_id' => $this->input->post('layanan_id'),
                'kode' => $this->input->post('kode'),
                'barang' => $this->input->post('barang'),
                'spesifikasi' => $this->input->post('spesifikasi'),
                'jumlah_baik' => $this->input->post('jumlah_baik'),
                'jumlah_rusak' => $this->input->post('jumlah_rusak'),
                'tanggal' => time(),
                'bisa_dipinjam' => $this->input->post('bisa_dipinjam'),
                'keterangan' => $this->input->post('keterangan'),
                'laboran_id' => $this->input->post('laboran_id'),
            ];

            $this->db->insert('user_barang', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('kalaboran/databarang/' . $layanan_id);
        }
    }

    public function ubahBarang()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $layanan_id = $this->input->post('layanan_id');

        $this->form_validation->set_rules('kode', 'Kode Barang', 'required');
        $this->form_validation->set_rules('barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah_baik', 'Jumlah Barang Kondisi Baik', 'required');
        $this->form_validation->set_rules('jumlah_rusak', 'Jumlah Barang Kondisi Rusak', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('barang', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('jumlah_baik', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error4' => form_error('jumlah_rusak', '<div class="alert alert-danger" role="alert">', '</div>')
            ];
            $this->session->set_flashdata($data);
            redirect('kalaboran/databarang/' . $layanan_id);
        } else {
            $this->laboratorium->ubahDataBarang();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('kalaboran/databarang/' . $layanan_id);
        }
    }

    public function hapusBarang()
    {
        $this->load->model('Lab_model', 'laboratorium');
        $id = $this->input->post('id');
        $user_barang = $this->db->get_where('user_barang', ['id' => $id])->row_array();
        $data = [
            'layanan_id' => $user_barang['layanan_id'],
        ];
        $this->session->set_userdata($data);

        $this->laboratorium->hapusDataBarang($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('kalaboran/databarang/' . $this->session->userdata('layanan_id'));
    }

    public function dataPeminjaman()
    {
        $data['title'] = 'Data Peminjaman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('Lab_model', 'laboratorium');

        $to_kalaboran = $this->session->userdata('id');

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
        $this->db->like('barang_barang', $data['keyword']);
        $this->db->from('user_pinjam');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['maupinjam'] = $this->laboratorium->getBarangPinjamKalaboran($to_kalaboran, $config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datapeminjaman', $data);
        $this->load->view('templates/footer');
    }

    public function selesaiPinjam()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $this->laboratorium->getKembaliBarang();
        $this->laboratorium->getSelesaiPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Peminjaman telah selesai!</div>');
        redirect('kalaboran/datapeminjaman');
    }

    public function terimaPinjam()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $this->laboratorium->getKurangBarang();
        $this->laboratorium->getTerimaPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diterima!</div>');
        redirect('kalaboran/datapeminjaman');
    }

    public function tolakPinjam()
    {
        $this->load->model('Lab_model', 'laboratorium');

        $this->laboratorium->getTolakPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditolak!</div>');
        redirect('kalaboran/datapeminjaman');
    }
}
