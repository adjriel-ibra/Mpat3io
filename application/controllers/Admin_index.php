<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_index extends CI_Controller {
    public function index() {
        $this->load->view('index/admin_lp1');
    }
    public function landing_page() {
        $this->load->view('index/admin_lp2');
    }
    public function daftar(){
        $this->load->view('admin/login/daftar');
    }
    public function masuk(){
        $this->load->view('admin/login/masuk');
    }
    public function lupa_password(){
        $this->load->view('admin/login/lupa_password');
    }
    public function verifikasi(){
        $this->load->view('admin/login/verifikasi');
    }
    public function done(){
        $this->load->view('admin/login/done');
    }
}
