<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function dataLayanan()
    {
        $data['title'] = 'Data Layanan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();
        $this->load->model('Lab_model', 'laboratorium');

        $laboran_id = $this->session->userdata('id');

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
        $config['base_url'] = base_url() . 'laboran/datalayanan/';
        $this->db->like('layanan', $data['keyword']);
        $this->db->from('user_layanan');
        $this->db->where(['laboran_id' => $laboran_id]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['lay'] = $this->laboratorium->getAllLay($laboran_id, $config['per_page'], $data['start'], $data['keyword']);
        // 

        $data['labplease'] = $this->db->get('user_laboratorium')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datalayanan', $data);
        $this->load->view('templates/footer');
    }

    public function tambahLayanan()
    {
        $this->form_validation->set_rules('lab', 'Nama Laboratorium', 'required');
        $this->form_validation->set_rules('kode', 'Kode Layanan', 'required');
        $this->form_validation->set_rules('layanan', 'Nama Layanan', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('lab', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('layanan', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('laboran/datalayanan');
        } else {
            $data = [
                'laboratorium_id' => $this->input->post('lab'),
                'kode' => $this->input->post('kode'),
                'layanan' => $this->input->post('layanan'),
                'laboran_id' => $this->session->userdata('id'),
            ];

            $this->db->insert('user_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('laboran/datalayanan');
        }
    }

    public function ubahLayanan()
    {
        $this->load->model('Laboran_model', 'laboratorium');

        $this->form_validation->set_rules('lab', 'Nama Laboratorium', 'required');
        $this->form_validation->set_rules('kode', 'Kode Layanan', 'required');
        $this->form_validation->set_rules('layanan', 'Nama Layanan', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'error1' => form_error('lab', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error2' => form_error('kode', '<div class="alert alert-danger" role="alert">', '</div>'),
                'error3' => form_error('layanan', '<div class="alert alert-danger" role="alert">', '</div>'),
            ];
            $this->session->set_flashdata($data);
            redirect('laboran/datalayanan');
        } else {
            $this->laboratorium->ubahDataLayanan();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('laboran/datalayanan/');
        }
    }

    public function hapusLayanan()
    {
        $this->load->model('Laboran_model', 'laboratorium');

        $id = $this->input->post('id');
        $this->laboratorium->hapusDataLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('laboran/datalayanan/');
    }

    public function dataBarang($layanan_id)
    {
        $data['title'] = 'Data Layanan';
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
        $config['base_url'] = base_url() . 'laboran/databarang/' . $layanan_id . '/';
        $this->db->like('barang', $data['keyword']);
        $this->db->from('user_barang');
        $this->db->where(['layanan_id' => $layanan_id]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(4);
        $data['barang'] = $this->laboratorium->getSearchBarang($layanan_id, $config['per_page'], $data['start'], $data['keyword']);
        // 

        $data['layanan'] = $this->laboratorium->getOneLayanan($layanan_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laboran/barangbarang', $data);
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
            redirect('laboran/databarang/' . $layanan_id);
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
                'laboran_id' => $this->session->userdata('id'),
            ];

            $this->db->insert('user_barang', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditambahkan!</div>');
            redirect('laboran/databarang/' . $layanan_id);
        }
    }

    public function ubahBarang()
    {
        $this->load->model('Lab_model', 'laboratorium');
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
            redirect('laboran/databarang/' . $layanan_id);
        } else {
            $this->laboratorium->ubahDataBarang();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diubah!</div>');
            redirect('laboran/databarang/' . $layanan_id);
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
        redirect('laboran/databarang/' . $this->session->userdata('layanan_id'));
    }

    public function dataPeminjaman()
    {
        $data['title'] = 'Data Pinjam';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['status'] = $this->db->get_where('user_role', ['id' => $this->session->userdata('role_id')])->row_array();

        $this->load->model('Laboran_model', 'laboratorium');

        $to_laboran = $this->session->userdata('id');

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
        $config['base_url'] = base_url() . 'laboran/datapeminjaman/';
        $this->db->like('barang_barang', $data['keyword']);
        $this->db->from('user_pinjam');
        $this->db->where(['to_laboran' => $to_laboran]);
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['maupinjam'] = $this->laboratorium->getBarangPinjamLaboran($to_laboran, $config['per_page'], $data['start'], $data['keyword']);
        // 

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laboran/pinjampinjam', $data);
        $this->load->view('templates/footer');
    }

    public function selesaiPinjam()
    {
        $this->load->model('Laboran_model', 'laboratorium');

        $this->laboratorium->getKembaliBarang();
        $this->laboratorium->getSelesaiPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Peminjaman telah selesai!</div>');
        redirect('laboran/datapeminjaman');
    }

    public function terimaPinjam()
    {
        $this->load->model('Laboran_model', 'laboratorium');

        $this->laboratorium->getTerimaPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil diterima!</div>');
        redirect('laboran/datapeminjaman');
    }

    public function tolakPinjam()
    {
        $this->load->model('Laboran_model', 'laboratorium');

        $this->laboratorium->getTolakPinjam();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil ditolak!</div>');
        redirect('laboran/datapeminjaman');
    }

    // public function sendEmail()
    // {
    //     $config = array();
    //     $config['protocol'] = 'smtp';
    //     $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    //     $config['smtp_user'] = 'sivenlab@gmail.com';
    //     $config['smtp_pass'] = 'Aditya-12';
    //     $config['smtp_port'] = 465;
    //     $config['mailtype'] = 'html';
    //     $config['charset'] = 'utf-8';
    //     $this->email->initialize($config);

    //     $this->email->set_newline("\r\n");

    //     $this->load->library('email', $config);

    //     $this->email->from('sivenlab@gmail.com', 'SIVENLAB UGM');
    //     $this->email->to($this->input->post('email'));

    //     $this->email->subject('Account Verification');
    //     $this->email->message('');

    //     if ($this->email->send()) {
    //         return true;
    //     } else {
    //         echo $this->email->print_debugger();
    //     }
    // }
}
