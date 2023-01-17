<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // kalau sudah login tidak bisa akses page login lagi
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data['title'] = 'Login Page';

        $this->form_validation->set_rules('username', 'Username', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasinya sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $data = [
            'namauser' => $username
        ];

        // $user = $this->user->getUserByEmail($data);
        $user = $this->user->getUserByUname($data);

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek passwordnya
                if ($password == $user['passuser']) {
                    $data = [
                        'namauser' => $user['namauser'],
                        'role_id' => $user['role_id'],
                        'iduser'  => $user['iduser']
                    ];

                    $this->session->set_userdata($data);

                    if ($user['role_id'] == 1) {
                        // $this->session->set_flashdata('message', 'Hello ' . $user['name'] . ', welcome back!');
                        redirect('admin');
                    } else {
                        // $this->session->set_flashdata('message', 'Hello ' . $user['name'] . ', welcome back!');
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username ini belum di-aktif kan!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username belum terdaftar!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('namauser');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah berhasil logout!</div>');
        redirect('auth');
    }
}
