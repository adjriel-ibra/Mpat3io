<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function cek_email($email) {
        return $this->db->get_where('penyewa', ['email_penyewa' => $email])->row_array();
    }
    public function get_penyewa($id) {
        return $this->db->get_where('penyewa', ['id_penyewa' => $id])->row_array();
    }
    public function insert($data) {
        return $this->db->insert('penyewa', $data);
    }

    public function update($email, $pass) {
        $this->db->where('email_penyewa', $email);
        return $this->db->update('penyewa', $pass);
    }
}
?>