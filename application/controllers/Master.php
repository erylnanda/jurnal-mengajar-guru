<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Master_model', 'master');
        $this->load->helper('download');
    }

    public function guru()
    {
        $data = [
            'title' => 'Modul Guru',
            'user' => $this->admin->sesi(),
            'guru' => $this->master->getGuru(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/guru/index', $data);
        $this->load->view('templates/footer');
    }

    public function addguru()
    {
        $data = [
            'title'   => 'Modul Guru',
            'subtitle' => 'Input Guru',
            'user'  => $this->admin->sesi(),
            'jurusan' => $this->master->getAllJurusan(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->_rulesGuru();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/guru/add_guru', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nip'           => $this->input->post('nip', true),
                'kodeguru'      => $this->input->post('kode', true),
                'namaguru'      => $this->input->post('namaguru', true),
                'jeniskelamin'  => $this->input->post('jenkel', true),
                'notelpseluler' => $this->input->post('notelp', true),
                'emailguru'     => $this->input->post('emailguru', true),
                'kodejurusan'   => $this->input->post('kodejurusan', true),
                'iduser'        => $this->session->userdata('iduser'),
                'is_active'     => $this->input->post('is_active', true)
            ];
            // $data2 = [
            //     'iduser' => $this->input->post('nip', true),
            //     'namauser' => $this->input->post('nip', true),
            //     'passuser' => md5($this->input->post('nip', true)),
            //     'namalengkapuser' => $this->input->post('namaguru', true),
            //     'role_id' => 2,
            //     'is_active'  => 1,
            //     'kodejurusan'  => $this->input->post('kodejurusan', true)
            // ];

            // $this->master->save_user($data2);
            $this->master->save_guru($data);
            $this->session->set_flashdata('message', 'data guru berhasil ditambah-kan');
            redirect('master/guru');
        }
    }

    private function _rulesGuru()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|is_unique[tb_guru.nip]', [
            'required' => '%s tidak boleh kosong',
            'is_unique' => '%s sudah terdaftar'
        ]);
        $this->form_validation->set_rules('namaguru', 'Nama guru', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('kode', 'Kode guru', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('notelp', 'No telp seluler', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('emailguru', 'Email', 'required|trim|valid_email', [
            'required' => '%s tidak boleh kosong',
            'valid_email' => '%s tidak sesuai'
        ]);
        $this->form_validation->set_rules('kodejurusan', 'Jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
    }

    public function editguru($nip)
    {
        $data = [
            'title'    => 'Modul Guru',
            'subtitle' => 'Update Guru',
            'user'  => $this->admin->sesi(),
            'dtguru' => $this->master->getGuruById($nip),
            'jurusan' => $this->master->getAllJurusan(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->_rulesEditGuru();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/guru/edit_guru', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->editDataGuru();
            $this->session->set_flashdata('message', 'data guru berhasil di-rubah!');
            redirect('master/guru');
        }
    }

    private function _rulesEditGuru()
    {
        $this->form_validation->set_rules('namaguru', 'Nama guru', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('kode', 'Kode guru', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('emailguru', 'Email', 'trim|valid_email', [
            'valid_email' => '%s tidak sesuai'
        ]);
    }

    public function deleteguru($nip)
    {
        $this->master->delguru($nip);
        $this->session->set_flashdata('message', 'data guru berhasil di-hapus!');
        redirect('master/guru');
    }

    public function userguru(){
        $data = [
            'title' => 'Modul User Guru',
            'user' => $this->admin->sesi(),
            'guru' => $this->master->getUserGuru(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/user/index', $data);
        $this->load->view('templates/footer');
    }

    private function _rulesEditUserGuru()
    {
        $this->form_validation->set_rules('namauser', 'Username', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('namalengkapuser', 'Nama Lengkap User', 'required|trim', [
            'valid_email' => '%s tidak boleh kosong'
        ]);
    }

    public function edituserguru($iduser)
    {
        $data = [
            'title'    => 'Modul User Guru',
            'subtitle' => 'Update User Guru',
            'user'  => $this->admin->sesi(),
            'dtguru' => $this->master->getUserGuruById($iduser),
            'jurusan' => $this->master->getAllJurusan(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->_rulesEditUserGuru();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/user/edit_guru', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->editDataUserGuru();
            $this->session->set_flashdata('message', 'data user guru berhasil di-rubah!');
            redirect('master/guru');
        }
    }

    public function deleteuserguru($iduser)
    {
        $this->master->deluserguru($iduser);
        $this->session->set_flashdata('message', 'data user guru berhasil di-hapus!');
        redirect('master/guru');
    }

    public function jurusan()
    {
        $data = [
            'title'     => 'Modul Jurusan',
            'user'      => $this->admin->sesi(),
            'jurusan'   => $this->master->getJurusan(),
            'guru'      => $this->master->getGuruProd(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('kodejur', 'Kode jurusan', 'required|trim|is_unique[tb_jurusan.kodejurusan]', [
            'required' => '%s tidak boleh kosong',
            'is_unique' => '%s sudah ada dalam database'
        ]);
        $this->form_validation->set_rules('namajur', 'Nama jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/jurusan/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kodejurusan' => $this->input->post('kodejur', true),
                'namajurusan' => $this->input->post('namajur', true),
                'iduser'      => $this->session->userdata('iduser')
            ];

            $this->master->save_jurusan($data);
            $this->session->set_flashdata('message', 'data jurusan berhasil ditambah-kan');
            redirect('master/jurusan');
        }
    }

    public function editjurusan($id)
    {
        $data = [
            'title'     => 'Modul Jurusan',
            'subtitle'  => 'Edit Jurusan',
            'user'      => $this->admin->sesi(),
            'dtjurusan' => $this->master->getJurusanById($id),
            'guru'      => $this->master->getAllGuru(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('namajur', 'Nama jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/jurusan/edit_jurusan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->update_jurusan();
            $this->session->set_flashdata('message', 'data jurusan berhasil di-rubah');
            redirect('master/jurusan');
        }
    }

    public function deletejurusan($id)
    {
        $this->master->deljurusan($id);
        $this->session->set_flashdata('message', 'data jurusan berhasil di-hapus');
        redirect('master/jurusan');
    }

    public function kelas()
    {
        $data = [
            'title'     => 'Modul Kelas',
            'user'      => $this->admin->sesi(),
            'kelas'     => $this->master->getKelas(),
            'jurusan'   => $this->master->getAllJurusan()
        ];

        $this->form_validation->set_rules('kodekls', 'Kode kelas', 'required|trim|is_unique[tb_kelas.kodekelas]', [
            'required' => '%s tidak boleh kosong',
            'is_unique' => '%s sudah ada dalam database'
        ]);
        $this->form_validation->set_rules('kodejur', 'Kode jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('namakls', 'Nama kelas', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kls', 'Kelas', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/kelas/index', $data);
            $this->load->view('templates/footer');
        } else {
            $title = $this->input->post('kodekls', true);
            $separator = "-";
            $kodek = str_replace(" ", $separator, $title);
            $data = [
                'kodekelas' => $kodek,
                'kodejurusan' => $this->input->post('kodejur', true),
                'namakelas' => $this->input->post('namakls', true),
                'kelas'     => $this->input->post('kls', true),
                'angkatankelas' => $this->input->post('angkatan', true),
                'is_active' => $this->input->post('is_active', true),
                'iduser'    => $this->session->userdata('iduser')
            ];

            $this->master->save_kelas($data);
            $this->session->set_flashdata('message', 'data kelas berhasil ditambah-kan');
            redirect('master/kelas');
        }
    }

    public function editkelas($id)
    {
        $data = [
            'title'     => 'Modul Kelas',
            'subtitle'  => 'Update Kelas',
            'user'      => $this->admin->sesi(),
            'dtkelas'   => $this->master->getKelasById($id),
            'jurusan'   => $this->master->getAllJurusan(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('namakls', 'Nama kelas', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/kelas/edit_kelas', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->update_kelas();
            $this->session->set_flashdata('message', 'data kelas berhasil di-rubah');
            redirect('master/kelas');
        }
    }

    public function deletekelas($id)
    {
        $this->master->delkelas($id);
        $this->session->set_flashdata('message', 'data kelas berhasil di-hapus');
        redirect('master/kelas');
    }

    // public function siswa()
    // {
    //     $data = [
    //         'title' => 'Modul Siswa',
    //         'user' => $this->admin->sesi(),
    //         'siswa' => $this->master->getSiswa(),
    //         'kelas'     => $this->master->getKelas()
    //     ];

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('master/siswa/index', $data);
    //     $this->load->view('templates/footer');
    // }

    public function siswa($id)
    {
        $k = $this->master->getKelasById($id);
        $data = [
            'title' => 'Modul Siswa '.$k['kelas']." ".$k['namakelas'],
            'user' => $this->admin->sesi(),
            'siswa' => $this->master->getDataSiswa2($id),
            'dtkelas'   => $this->master->getKelasById($id),
            'kelas'     => $this->master->getKelas()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/siswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function addsiswa($id)
    {
        $k = $this->master->getKelasById($id);
        $data = [
            'title' => 'Modul Siswa '.$k['kelas']." ".$k['namakelas'],
            'subtitle' => 'Input Siswa'.$k['kelas']." ".$k['namakelas'],
            'user' => $this->admin->sesi(),
            'jurusan' => $this->master->getAllJurusan(),
            'dtkelas'   => $this->master->getKelasById($id),
            'kelas' => $this->master->getKelas()
        ];

        $this->_rulesSiswa();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/siswa/add_siswa', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nis'       => $this->input->post('nis', true),
                'namasiswa' => $this->input->post('namasiswa', true),
                'jeniskelamin' => $this->input->post('jenkel', true),
                'kodekelas'    => $this->input->post('kodekls', true),
                'kodejurusan'  => $this->input->post('kodejur', true),
                'semester_aktif' => $this->input->post('semester', true),
                'is_active'    => 1,
                'iduser'       => $this->session->userdata('iduser')
            ];

            $data2 = [
                'iduser' => $this->input->post('nis', true),
                'namauser' => $this->input->post('nis', true),
                'passuser' => md5($this->input->post('nis', true)),
                'namalengkapuser' => $this->input->post('namasiswa', true),
                'role_id' => 4,
                'is_active'  => 1,
                'kodejurusan'  => $this->input->post('kodejur', true),
                'semester_aktif'  => $this->input->post('semester', true)
            ];

            $this->master->save_user($data2);
            $this->master->save_siswa($data);
            $this->session->set_flashdata('message', 'data siswa berhasil ditambah-kan');
            redirect('master/siswa/'.$k['kodekelas']);
        }
    }

    private function _rulesSiswa()
    {
        $this->form_validation->set_rules('nis', 'Nomor induk siswa', 'required|trim|is_unique[tb_siswa.nis]', [
            'required' => '%s tidak boleh kosong',
            'is_unique' => '%s sudah ada dalam database'
        ]);
        $this->form_validation->set_rules('namasiswa', 'Nama siswa', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('jenkel', 'Jenis kelamin', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('kodekls', 'Kode kelas', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('kodejur', 'Kode jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('semester', 'Semester', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
    }

    public function editsiswa($id,$kelas)
    {
        $k = $this->master->getKelasById($kelas);
        $data = [
            'title' => 'Modul Siswa '.$k['kelas']." ".$k['namakelas'],
            'subtitle' => 'Input Siswa'.$k['kelas']." ".$k['namakelas'],
            'user' => $this->admin->sesi(),
            'dtsiswa' => $this->master->getSiswaById($id),
            'jurusan' => $this->master->getAllJurusan(),
            'dtkelas'   => $this->master->getKelasById($kelas),
            'kelas' => $this->master->getKelas()
        ];

        $this->_rulesEditSiswa();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/siswa/edit_siswa', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->update_siswa();
            $this->session->set_flashdata('message', 'data siswa berhasil di-rubah');
            redirect('master/siswa/'.$k['kodekelas']);
        }
    }

    public function _rulesEditSiswa()
    {
        $this->form_validation->set_rules('namasiswa', 'Nama siswa', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('semester', 'Semester', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
    }

    public function deletesiswa($id)
    {
        $this->master->delsiswa($id);
        $this->session->set_flashdata('message', 'data siswa berhasil di-hapus');
        redirect('master/siswa'.$k['kodekelas']);
    }

    public function mapel()
    {
        $data = [
            'title'     => 'Modul Mata Pelajaran',
            'user'      => $this->admin->sesi(),
            'mapel'     => $this->master->getMapel(),
            'kodemp'    => $this->master->kode_mp(),
            'jrsn'      => $this->master->getAllJurusan(),
            'kelompok'  => $this->master->getKelompok(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('namamp', 'Nama mapel', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('tingkatan', 'Tingkatan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kelompok', 'Kelompok mapel', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kodejur', 'Jurusan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kkm', 'KKM', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/mapel/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kodemapel'     => $this->input->post('kodemp', true),
                'namamapel'     => $this->input->post('namamp', true),
                'tingkatan'     => $this->input->post('tingkatan', true),
                'idkelompokmapel' => $this->input->post('kelompok', true),
                'kodejurusan'   => $this->input->post('kodejur', true),
                'kkm'           => $this->input->post('kkm', true),
                'iduser'        => $this->session->userdata('iduser')
            ];

            $this->master->save_mapel($data);
            $this->session->set_flashdata('message', 'data mapel berhasil ditambah-kan');
            redirect('master/mapel');
        }
    }

    public function editmapel($id)
    {
        $data = [
            'title'     => 'Modul Mata Pelajaran',
            'subtitle'  => 'Update Mapel',
            'user'      => $this->admin->sesi(),
            'dtmapel'   => $this->master->getMapelById($id),
            'jurusan'   => $this->master->getAllJurusan(),
            'kelompok'  => $this->master->getKelompok(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('namamp', 'Nama mapel', 'required|trim', [
            'required' => '%s tidak boleh kosong',
        ]);
        $this->form_validation->set_rules('tingkatan', 'Tingkatan', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kelompok', 'Kelompok mapel', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kkm', 'KKM', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/mapel/edit_mapel', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->update_mapel();
            $this->session->set_flashdata('message', 'data mapel berhasil di-rubah');
            redirect('master/mapel');
        }
    }

    public function deletemapel($id)
    {
        $this->master->delmapel($id);
        $this->session->set_flashdata('message', 'data mapel berhasil di-hapus');
        redirect('master/mapel');
    }

    public function mengajar()
    {
        $data = [
            'title'     => 'Modul Mengajar',
            'user'      => $this->admin->sesi(),
            'ajar'      => $this->master->getAjar(),
            'mapel'     => $this->master->getMapel(),
            'guru'      => $this->master->getAllGuru(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('smstr', 'Semester', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('periode', 'Periode mengajar', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/mengajar/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kodemapel' => $this->input->post('kodemapel', true),
                'nip'       => $this->input->post('nip', true),
                'semester'  => $this->input->post('smstr', true),
                'kodekelas' => $this->input->post('kodekls', true),
                'periode_mengajar' => $this->input->post('periode', true)
            ];

            $this->master->save_mengajar($data);
            $this->session->set_flashdata('message', 'data mengajar berhasil ditambah-kan');
            redirect('master/mengajar');
        }
    }

    public function editajar($id)
    {
        $data = [
            'title'     => 'Modul Mengajar',
            'subtitle'  => 'Update Mengajar',
            'user'      => $this->admin->sesi(),
            'dtajar'    => $this->master->getAjarById($id),
            'mapel'     => $this->master->getMapel(),
            'guru'      => $this->master->getAllGuru(),
            'kelas'     => $this->master->getKelas()
        ];

        $this->form_validation->set_rules('smstr', 'Semester', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('periode', 'Periode mengajar', 'required|trim', [
            'required' => '%s tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/mengajar/edit_mengajar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->master->update_ajar();
            $this->session->set_flashdata('message', 'data mengajar berhasil di-rubah');
            redirect('master/mengajar');
        }
    }

    public function deleteajar($id)
    {
        $this->master->delajar($id);
        $this->session->set_flashdata('message', 'data mengajar berhasil di-hapus');
        redirect('master/mengajar');
    }

    public function download_formatguru()
    {
        $path = file_get_contents(base_url()."assets/file".$filename);
        $name = "format_data_guru.xlsx";
        force_download($name, $path);
    }

    public function download_formatmapel()
    {
        $path = file_get_contents(base_url()."assets/file".$filename);
        $name = "format_data_mapel.xlsx";
        force_download($name, $path);
    }

    public function download_formatsiswa()
    {
        $path = file_get_contents(base_url()."assets/file".$filename);
        $name = "format_data_siswa.xlsx";
        force_download($name, $path);
    }
}
