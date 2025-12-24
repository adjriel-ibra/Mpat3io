<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Villa_model extends CI_Model {
    public function get_villa() {
        return $this->db->get('villa')->result_array();
    }
    public function get_all_except($id_kecuali) {
        $this->db->where('id_villa !=', $id_kecuali);
        return $this->db->get('villa')->result_array();
    }
    public function get_mitra_by_id($id) {
        return $this->db->where('id_mitra',$id)->get('mitra')->row();
    }
    public function get_villa_by_mitra($id) {
        return $this->db->where('id_mitra',$id)->get('villa')->result_array();
    }
    public function update_mitra($id, $data) {
        $this->db->where('id_mitra', $id);
        return $this->db->update('mitra', $data);
    }
    public function insert_villa($data){
        return $this->db->insert('villa', $data);
    }
    public function search_villa($keyword)
    {
        $this->db->like('nama_villa', $keyword);
        $this->db->or_like('deskripsi', $keyword);

        return $this->db->get('villa')->result();
    }
    public function get_by_id($id) {
        $this->db->select('*'); 
        $this->db->from('villa');
        $this->db->join('mitra', 'mitra.id_mitra = villa.id_mitra');
        $this->db->where('villa.id_villa', $id);
        
        return $this->db->get()->row_array();
    }
    public function get_by_mitra($id_mitra) {
        $this->db->select('*'); 
        $this->db->from('villa');
        $this->db->join('mitra', 'mitra.id_mitra = villa.id_mitra');
        $this->db->where('villa.id_mitra', $id_mitra);
        
        return $this->db->get()->result_array(); 
    }
    public function get_pesanan_by_penyewa($penyewa_id){
        $this->db->select('pesanan.*, villa.nama_villa, villa.gambar, mitra.nama_mitra');
        $this->db->from('pesanan');
        $this->db->join('villa', 'villa.id_villa = pesanan.id_villa', 'left');
        $this->db->join('mitra', 'mitra.id_mitra = pesanan.id_mitra', 'left');
        $this->db->where('pesanan.id_penyewa', $penyewa_id);
        $this->db->order_by('id_pesanan', 'DESC'); 
        return $this->db->get()->result();
    }
    public function get_pesanan_by_mitra($mitra_id){
        $this->db->select('pesanan.*, villa.nama_villa, villa.gambar, penyewa.nama_penyewa, penyewa.email_penyewa');
        $this->db->from('pesanan');
        $this->db->join('villa', 'villa.id_villa = pesanan.id_villa', 'left');
        $this->db->join('penyewa', 'penyewa.id_penyewa = pesanan.id_penyewa', 'left');
        $this->db->where('pesanan.id_mitra', $mitra_id);
        $this->db->order_by('id_pesanan', 'DESC'); 
        return $this->db->get()->result();
    }
    public function get_detail_pesanan($id_pesanan){
        $this->db->select('pesanan.*,villa.*,mitra.*,penyewa.*');
        $this->db->from('pesanan');
        $this->db->join('villa', 'villa.id_villa = pesanan.id_villa', 'left');
        $this->db->join('mitra', 'mitra.id_mitra = pesanan.id_mitra', 'left');
        $this->db->join('penyewa', 'penyewa.id_penyewa = pesanan.id_penyewa', 'left');
        $this->db->where('pesanan.id_pesanan', $id_pesanan);
        return $this->db->get()->row(); 
    }

    public function update_pesanan($id, $data) {
        $this->db->where('id_pesanan', $id);
        return $this->db->update('pesanan', $data);
    }

    public function get_villa_by_id($id) {
        return $this->db->get_where('villa', ['id_villa' => $id])->row_array();
    }
    public function insert_pesanan($data) {
        return $this->db->insert('pesanan', $data);
    }
    public function get_mitra_by_villa($id_villa) {
        $this->db->select('id_mitra');
        $this->db->from('villa');
        $this->db->where('id_villa', $id_villa);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id_mitra; // Mengembalikan id_mitra (misal: 5)
        }
        return null; // Jika villa tidak ditemukan
    }
    public function batalkan_pesanan($id_pemesanan)
    {
        $data = [
            'status_pesanan' => 'cancelled'
        ];
        
        $this->db->where('id_pesanan', $id_pemesanan);
        return $this->db->update('pesanan', $data); 
    }
    public function updateVilla($id_villa, $data) {
        $this->db->where('id_villa', $id_villa);
        return $this->db->update('villa', $data);
    }
}
?>
