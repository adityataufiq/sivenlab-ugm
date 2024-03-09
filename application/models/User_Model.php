<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getAllBarang()
    {
        return $this->db->get('user_barang')->result_array();
    }

    public function getSearchBarang($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('barang', $keyword);
        }

        $this->db->where(['bisa_dipinjam' => 1]);
        $this->db->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->join('user_barang', 'user_barang.layanan_id=user_layanan.id');
        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }

    public function getPinjamBarang()
    {
        $data = [
            'laboratorium_id' => $this->input->post('laboratorium_id'),
            'layanan_id' => $this->input->post('layanan_id'),
            'barang_id' => $this->input->post('barang_id'),
            'kode' => $this->input->post('kode'),
            'barang_barang' => $this->input->post('barang_barang'),
            'barang_spesifikasi' => $this->input->post('barang_spesifikasi'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal_pinjam' => time(),
            'tanggal_kembali' => date_format(date_create($this->input->post('tanggal_kembali')), 'd F Y'),
            'user_id' => $this->session->userdata('id'),
            'user_name' => $this->session->userdata('name'),
            'to_laboran' => $this->input->post('to_laboran'),
            'to_kalaboran' => null,
            'status' => null,
        ];

        $this->db->insert('user_pinjam', $data);
    }

    public function getMauPinjam($user_id, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('barang_barang', $keyword);
        }

        $this->db->where(['user_id' => $user_id]);
        $this->db->order_by('tanggal_pinjam', 'DESC');
        $this->db->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->join('user_pinjam', 'user_pinjam.layanan_id=user_layanan.id');
        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }
}
