<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function cek_email($email) {
        return $this->db->get_where('mitra', ['email_mitra' => $email])->row_array();
    }

    public function insert($data) {
        return $this->db->insert('mitra', $data);
    }

    public function update($email, $pass) {
        $this->db->where('email_mitra', $email);
        return $this->db->update('mitra', $pass);
    }
}
?>