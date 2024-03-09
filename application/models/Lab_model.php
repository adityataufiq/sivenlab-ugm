<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lab_model extends CI_Model
{
    public function getLaboran()
    {
        return $this->db->get_where('user', ['role_id' => 3])->result_array();
    }

    public function getAllLab($kalaboran_id, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('laboratorium', $keyword);
        }

        $this->db->where(['kalaboran_id' => $kalaboran_id]);
        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }

    public function getAllLay($laboran_id, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('layanan', $keyword);
        }

        $this->db->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->where(['laboran_id' => $laboran_id]);
        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }

    public function getLabById($id)
    {
        return $this->db->get_where('user_laboratorium', ['id' => $id])->row_array();
    }

    public function getSearchLayanan($laboratorium_id, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('layanan', $keyword);
        }

        $this->db->join('user_layanan', 'user_layanan.laboratorium_id=user_laboratorium.id');
        $this->db->where(['laboratorium_id' => $laboratorium_id]);

        return $this->db->get('user_laboratorium', $limit, $start)->result_array();
    }

    public function getLab($id)
    {
        $this->db->from('user_layanan')->join('user_laboratorium', 'user_laboratorium.id=user_layanan.laboratorium_id')->get();
        return $this->db->get_where('user_laboratorium', ['id' => $id])->row_array();
    }

    public function getOneLayanan($id)
    {
        $this->db->from('user_barang')->join('user_layanan', 'user_layanan.id=user_barang.layanan_id')->get();
        return $this->db->get_where('user_layanan', ['id' => $id])->row_array();
    }

    public function getSearchBarang($layanan_id, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('barang', $keyword);
        }

        $this->db->join('user_barang', 'user_barang.layanan_id=user_layanan.id');
        $this->db->where(['layanan_id' => $layanan_id]);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('user_layanan', $limit, $start)->result_array();
    }

    public function getBarangPinjamKalaboran($to_kalaboran, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('barang_barang', $keyword);
        }

        $this->db->where(['user_pinjam.to_kalaboran' => $to_kalaboran]);
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


    public function getKurangBarang()
    {
        $id = $this->input->post('id');
        $query = "UPDATE `user_barang`
                JOIN `user_pinjam`
                ON `user_pinjam`.`barang_id` = `user_barang`.`id`
                SET `user_barang`.`jumlah_baik` = (`user_barang`.`jumlah_baik`-`user_pinjam`.`jumlah`)
                WHERE user_pinjam.id = $id
                ";

        $this->db->query($query);
    }

    public function getTerimaPinjam()
    {
        $data = [
            'status' => 2,
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

    public function hapusDataRole($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }

    public function hapusDataPengguna($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function hapusDataLab($id)
    {
        $hasil = $this->db->query("DELETE FROM user_laboratorium WHERE id='$id'");
        return $hasil;
    }

    public function hapusDataLayanan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_layanan');
    }

    public function hapusDataBarang($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_barang');
    }

    public function ubahDataRole()
    {
        $data = [
            'role' => $this->input->post('role', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_role', $data);
    }

    public function ubahDataLab()
    {
        $data = [
            'kode' => $this->input->post('kode', true),
            'laboratorium' => $this->input->post('laboratorium', true),
            'departemen' => $this->input->post('departemen', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_laboratorium', $data);
    }

    public function ubahDataLayanan()
    {
        $data = [
            'kode' => $this->input->post('kode', true),
            'layanan' => $this->input->post('layanan', true),
            'laboran_id' => $this->input->post('laboran_id', true),
            'laboran_name' => $this->input->post('laboran_name', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_layanan', $data);
    }

    public function ubahDataBarang()
    {
        $data = [
            'kode' => $this->input->post('kode', true),
            'barang' => $this->input->post('barang', true),
            'spesifikasi' => $this->input->post('spesifikasi', true),
            'jumlah_baik' => $this->input->post('jumlah_baik', true),
            'jumlah_rusak' => $this->input->post('jumlah_rusak', true),
            'bisa_dipinjam' => $this->input->post('bisa_dipinjam', true),
            'keterangan' => $this->input->post('keterangan', true),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_barang', $data);
    }
}
