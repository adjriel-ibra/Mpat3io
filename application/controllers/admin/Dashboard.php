<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Villa_model');

        if (!$this->session->userdata('mitra_nama')) {
            redirect('admin_index');
            exit;
        }
    }

    public function index()
    {
        $id = $this->session->userdata('mitra_id');
        $data['villa'] = $this->Villa_model->get_villa_by_mitra($id);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/temp/footer_mitra');
    }

    public function pesanan()
    {
        $id = $this->session->userdata('mitra_id');
        $data['pesanan'] = $this->Villa_model->get_pesanan_by_mitra($id);
        $this->load->view('admin/dashboard/pesanan', $data);
        $this->load->view('admin/temp/footer_mitra');
    }
    public function detail_admin($id_pesanan)
    {
        $data['detail'] = $this->Villa_model->get_detail_pesanan($id_pesanan);

        $this->load->view('villa/detail_admin', $data);
        $this->load->view('admin/temp/footer_mitra');
    }
    public function update_action()
    {
        $id_pesanan = $this->input->post('id_pesanan');
        $tgl_in = $this->input->post('tgl_check_in');
        $tgl_out = $this->input->post('tgl_check_out');
        $status = $this->input->post('status_pesanan');

        // Validasi Server-side: Mencegah tgl_out < tgl_in
        if (strtotime($tgl_out) <= strtotime($tgl_in)) {
            $this->session->set_flashdata('error', 'Update Gagal! Tanggal Checkout tidak valid.');
            redirect('admin/dashboard/pesanan');
            return;
        }

        $data_update = [
            'tgl_check_in' => $tgl_in,
            'tgl_check_out' => $tgl_out,
            'status_pesanan' => $status
        ];

        if ($this->Villa_model->update_pesanan($id_pesanan, $data_update)) {
            $this->session->set_flashdata('success', 'Data pesanan berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat update.');
        }
        redirect('admin/dashboard/pesanan');
    }
    public function akun()
    {
        $id = $this->session->userdata('mitra_id');
        $data['mitra'] = $this->Villa_model->get_mitra_by_id($id);
        $this->load->view('admin/dashboard/akun', $data);
        $this->load->view('admin/temp/footer_mitra');
    }

    public function update_profil()
    {
        $id = $this->session->userdata('mitra_id');
        $data = [
            'username' => $this->input->post('username', true),
            'nama_mitra' => $this->input->post('nama_mitra', true),
            'email_mitra' => $this->input->post('email_mitra', true),
            'alamat' => $this->input->post('alamat', true),
        ];

        $this->Villa_model->update_mitra($id, $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil berhasil diperbarui!</div>');
        redirect('admin/dashboard/akun');
    }

    public function tambah_fasilitas()
    {
        $this->load->view('admin/dashboard/tambah');
        $this->load->view('admin/temp/footer_mitra');
    }

    public function simpan()
    {
        $foto = null;

        if (!empty($_FILES['gambar']['name'])) {

            $config['upload_path'] = 'asset/Uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE; // nama file acak (aman)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata(
                    'pesan_error',
                    $this->upload->display_errors()
                    // The upload path does not appear to be valid.
                );
                redirect('admin/dashboard/tambah');
                return;
            }

            // Ambil data upload
            $uploadData = $this->upload->data();

            // SIMPAN RELATIVE PATH + FILENAME
            $foto = 'asset/Uploads/' . $uploadData['file_name'];
        }

        // Data yang akan disimpan
        $data = [
            'id_mitra' => $this->session->userdata('mitra_id'),
            'nama_villa' => $this->input->post('nama', TRUE),
            'harga' => $this->input->post('harga', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'gambar' => $foto,
            'status_villa' => $this->input->post('status', TRUE),
        ];

        $this->Villa_model->insert_villa($data);

        $this->session->set_flashdata('pesan_sukses', 'Data villa berhasil disimpan');
        redirect('admin/dashboard');
    }
    public function edit($id_villa)
    {
        $data['villa'] = $this->Villa_model->get_villa_by_id($id_villa);
        $this->load->view('admin/dashboard/edit_villa', $data);
        $this->load->view('admin/temp/footer_mitra');
    }

    public function update_villa()
    {
        $id_villa = $this->input->post('id_villa');
        $data = [
            'nama_villa' => $this->input->post('nama_villa'),
            'harga' => $this->input->post('harga'),
            'deskripsi' => $this->input->post('deskripsi'),
            'status_villa' => $this->input->post('status_villa'),
        ];

        if (!empty($_FILES['gambar']['name'])) {

            $config['upload_path'] = FCPATH . 'asset/Uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE; // nama file acak

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                // Jika upload berhasil:
                $uploadData = $this->upload->data();
                $data['gambar'] = 'asset/Uploads/' . $uploadData['file_name'];

            } else {
                $this->session->set_flashdata(
                    'pesan_error',
                    $this->upload->display_errors()
                );
                redirect('admin/dashboard/edit/' . $id_villa);
                return;
            }
        }
        $this->Villa_model->updateVilla($id_villa, $data);

        redirect('admin/dashboard');
    }
    public function villa_delete($id_villa)
    {
        $this->Villa_model->delete_Villa($id_villa);
        $this->session->set_flashdata('pesan_sukses', 'Data villa berhasil dihapus');
        redirect('admin/dashboard');
    }
}
