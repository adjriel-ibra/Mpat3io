<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function register() {
        if ($this->session->userdata('logged_in_penyewa')) {
            redirect('user/dashboard');
        }

        $nama = $this->input->post('nama');
        $telp = $this->input->post('telp');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($this->User_model->cek_email($email)) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar.');
            redirect('index/daftar');
            return;
        }

        $data = [
            'nama_penyewa' => $nama,
            'no_telp' => $telp,
            'email_penyewa' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->User_model->insert($data);
        
        $penyewa = $this->User_model->cek_email($email);
        $this->session->set_userdata([
            'penyewa_id' => $penyewa['id_penyewa'],
            'penyewa_nama' => $penyewa['nama_penyewa'],
            'penyewa_email' => $penyewa['email_penyewa'],
            'logged_in_penyewa' => true
        ]);
        redirect('user/dashboard');
    }
    
    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $penyewa = $this->User_model->cek_email($email);
        
        if ($penyewa) {
            if (password_verify($password, $penyewa['password'])) {
                
                $this->session->set_userdata([
                    'penyewa_id' => $penyewa['id_penyewa'],
                    'penyewa_nama' => $penyewa['nama_penyewa'],
                    'penyewa_email' => $penyewa['email_penyewa'],
                    'logged_in_penyewa' => true
                ]);
                redirect('user/dashboard');
                
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah.');
            }
        } else { 
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('index/masuk');
        }
    }
    public function lupa_pass(){
        $email = $this->input->post('email');
        $cek = $this->User_model->cek_email($email);
        if (!$cek){
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('index/lupa_password');
        } else {
            $this->session->set_flashdata('email', $email);
            redirect('index/verifikasi');
        }
    }

    public function verif() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $repass = $this->input->post('repass');
        $penyewa = $this->User_model->cek_email($email);

        if ($password !== $repass) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak sesuai.');
            redirect('index/verifikasi');
            return;
        }else {
            $update = [
                'password' => password_hash($password, PASSWORD_DEFAULT)];
            $this->User_model->update($email, $update);
            $this->session->set_userdata([
                'penyewa_id' => $penyewa['id_penyewa'],
                'penyewa_nama' => $penyewa['nama_penyewa'],
                'penyewa_email' => $penyewa['email_penyewa'],
                'logged_in_penyewa' => true
            ]);
            redirect('index/done');
        }
    }

    public function logout_penyewa() {
    $this->session->unset_userdata([
        'penyewa_id',
        'penyewa_nama',
        'penyewa_email',
        'logged_in_penyewa'
    ]);

    redirect('index');
}

}