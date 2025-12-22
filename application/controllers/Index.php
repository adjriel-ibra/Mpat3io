<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Villa_model');
    }
    public function index() {
        $data['villa'] = $this->Villa_model->get_villa('get_villa');
        $this->load->view('user/dashboard/index',$data);
        $this->load->view('user/temp/footer');
    }
    public function lp1() {
        $this->load->view('index/lp1');
    }
    
    public function landing_page() {
        $this->load->view('index/lp2');
    }
    public function daftar(){
        $this->load->view('user/login/daftar');
    }

    public function masuk(){
        $this->load->view('user/login/masuk');
    }

    public function lupa_password(){
        $this->load->view('user/login/lupa_password');
    }

    public function verifikasi(){
        $this->load->view('user/login/verifikasi');
    }

    public function done(){
        $this->load->view('user/login/done');
    }
}
