<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboran_model extends CI_Model
{
    public function ubahDataLayanan()
    {
        $data = [
            'laboratorium_id' => $this->input->post('lab', true),
            'kode' => $this->input->post('kode', true),
            'layanan' => $this->input->post('layanan', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_layanan', $data);
    }

    public function hapusDataLayanan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_layanan');
    }

    public function getBarangPinjamLaboran($to_laboran, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('barang_barang', $keyword);
        }

        $this->db->where(['user_pinjam.to_laboran' => $to_laboran]);
        $this->db->order_by('tanggal_pinjam', 'DESC');
        $this->db->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->join('user_pinjam', 'user_pinjam.layanan_id=user_layanan.id');
        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }

    public function getKembaliBarang()
    {
        $id = $this->input->post('id');
        $query = "UPDATE `user_barang`
                JOIN `user_pinjam`
                ON `user_pinjam`.`barang_id` = `user_barang`.`id`
                SET `user_barang`.`jumlah_baik` = (`user_barang`.`jumlah_baik`+`user_pinjam`.`jumlah`)
                WHERE user_pinjam.id = $id
                ";

        $this->db->query($query);
    }

    public function getSelesaiPinjam()
    {
        $data = [
            'status' => 3,
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_pinjam', $data);
    }

    public function getTerimaPinjam()
    {
        $data = [
            'to_kalaboran' => $this->input->post('to_kalaboran'),
            'status' => 1,
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_pinjam', $data);
    }

    public function getTolakPinjam()
    {
        $data = [
            'status' => 0,
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_pinjam', $data);
    }
}
