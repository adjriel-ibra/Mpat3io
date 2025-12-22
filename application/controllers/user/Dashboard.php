<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Villa_model');
        $this->load->model('User_model');
    }
    
    public function akun(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $this->load->view('user/dashboard/akun');
        $this->load->view('user/temp/footer');
    }
    public function faq(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $this->load->view('user/dashboard/faq');
        $this->load->view('user/temp/footer');
    }
    public function sk(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $this->load->view('user/dashboard/sk');
        $this->load->view('user/temp/footer');
    }
    public function contact(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $this->load->view('user/dashboard/contact');
        $this->load->view('user/temp/footer');
    }
    public function kebijakan(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $this->load->view('user/dashboard/kebijakan');
        $this->load->view('user/temp/footer');
    }
    public function index(){
        $data['villa'] = $this->Villa_model->get_villa();
        $this->load->view('user/dashboard/index',$data);
        $this->load->view('user/temp/footer');
    }
    public function riwayat(){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $penyewa_id = $this->session->userdata('penyewa_id');
        $data['pesanan'] = $this->Villa_model->get_pesanan_by_penyewa($penyewa_id);
        $this->load->view('user/dashboard/riwayat', $data);
        $this->load->view('user/temp/footer');
    }
    public function detail($id) {
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $data['villa'] = $this->Villa_model->get_by_id($id);
        $id_mitra = $data['villa']['id_mitra'];
        $data['villa_mitra'] = $this->Villa_model->get_by_mitra($id_mitra);
        $this->load->view('villa/detail', $data);
        $this->load->view('user/temp/footer');
    }
    public function detail_pesanan($id_pesanan){
        if (!$this->session->userdata('penyewa_nama')) {
            redirect('index/lp1');
            exit; 
        }
        $data['detail'] = $this->Villa_model->get_detail_pesanan($id_pesanan);
        
        $this->load->view('villa/riwayat', $data);
        $this->load->view('user/temp/footer');
    }
    public function batalkan_pesanan(){
        $id_pemesanan = $this->input->post('id_pesanan');

        if ($id_pemesanan) {
            $update = $this->Villa_model->batalkan_pesanan($id_pemesanan);

            if ($update) {
                $this->session->set_flashdata('pesan', 'Pesanan berhasil dibatalkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal membatalkan pesanan.');
            }
        }
        redirect('user/dashboard/riwayat');
    }
    public function form_pesan($id_villa) {
        if (!$this->session->userdata('penyewa_id')) {
            redirect('index/lp1');
            return;
        }

        $data['villa'] = $this->Villa_model->get_villa_by_id($id_villa);
        $data['user']  = $this->User_model->get_penyewa(
            $this->session->userdata('penyewa_id')
        );

        $this->load->view('villa/pesan_villa', $data);
        $this->load->view('user/temp/footer');
    }

    public function proses_bayar() {
        // Tangkap data input
        $id_villa      = $this->input->post('id_villa');
        $harga         = (int)$this->input->post('harga_villa');
        $tgl_in        = $this->input->post('tgl_check_in');
        $tgl_out       = $this->input->post('tgl_check_out');
        $id_penyewa    = $this->session->userdata('penyewa_id');

        // Hitung durasi dan harga
        $hari = ceil((strtotime($tgl_out) - strtotime($tgl_in)) / 86400);
        if ($hari <= 0) {
            echo "<script>alert('Tanggal tidak valid'); window.history.back();</script>";
            return;
        }

        $biaya_layanan = 100000;
        $total_harga   = ($harga * $hari) + $biaya_layanan;
        $id_mitra      = $this->Villa_model->get_mitra_by_villa($id_villa);

        // Data array untuk dimasukkan ke database (TANPA metode_bayar)
        $data_insert = [
            'id_penyewa'       => $id_penyewa,
            'id_villa'         => $id_villa,
            'id_mitra'         => $id_mitra,
            'total_harga'      => $total_harga,
            'tgl_check_in'     => $tgl_in,
            'tgl_check_out'    => $tgl_out,
            'tgl_pesanan'      => date('Y-m-d H:i:s'),
            'status_pesanan'   => 'pending',
        ];
        $this->Villa_model->insert_pesanan($data_insert);
        redirect('user/dashboard/riwayat/' );
    }
    public function get_snap_token() {
        require_once APPPATH . 'libraries/Midtrans.php';

        $serverKey = ''; // Ganti dengan server key Midtrans Anda
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $gross_amount = (int) $this->input->post('gross_amount');
        $penyewa_id = $this->session->userdata('penyewa_id');
        $penyewa = $this->User_model->get_penyewa($penyewa_id);

        $params = array(
            'transaction_details' => array(
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $gross_amount,
            ),
            'customer_details' => array(
                'first_name' => $penyewa['nama_penyewa'],
                'email' => $penyewa['email_penyewa'] ?? 'dummy@email.com',
                'phone' => $penyewa['no_telp'] ?? '08123456789',
            ),
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            echo $snapToken;
        } catch (Exception $e) {
            echo 'Gagal mendapatkan token: ' . $e->getMessage();
        }
    }
}
