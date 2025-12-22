<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Villa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Villa_model');
    }

    public function search(){
        $keyword = $this->input->get('keyword');

        $data['keyword'] = $keyword;
        $data['results'] = $this->Villa_model->search_villa($keyword);

        $this->load->view('villa/src', $data);
        $this->load->view('user/temp/footer');
    }
    public function riwayat(){
        $this->load->view('villa/riwayat');
        $this->load->view('user/temp/footer');
    }
}
