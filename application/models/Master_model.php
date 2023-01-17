<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function getAllGuru()
    {
        return $this->db->get('tb_guru')->result_array();
    }

    public function getGuru()
    {
        $this->db->select('tb_guru.*, tb_jurusan.namajurusan');
        $this->db->from('tb_guru');
        $this->db->join('tb_jurusan', 'tb_guru.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getGuruProd()
    {
        $this->db->where('kodejurusan != "-"');
        return $this->db->get('tb_guru')->result_array();
    }

    public function save_guru($data)
    {
        $this->db->insert('tb_guru', $data);
        return true;
    }

    public function getGuruById($nip)
    {
        return $this->db->get_where('tb_guru', ['nip' => $nip])->row_array();
    }

    public function editDataGuru()
    {
        $data = [
            'namaguru'      => $this->input->post('namaguru', true),
            'kodeguru'      => $this->input->post('kode', true),
            'jeniskelamin'  => $this->input->post('jenkel', true),
            'notelpseluler' => $this->input->post('notelp', true),
            'emailguru'     => $this->input->post('emailguru', true),
            'kodejurusan'   => $this->input->post('kodejurusan', true),
            'iduser'        => $this->session->userdata('iduser'),
            'is_active'     => $this->input->post('is_active', true)
        ];

        $this->db->where('nip', $this->input->post('idnip'));
        $this->db->update('tb_guru', $data);
        return true;
    }

    public function delguru($nip)
    {
        $this->db->delete('tb_guru', ['nip' => $nip]);
        $this->db->delete('user_login', ['namauser' => $nip]);
        return true;
    }

    public function getUserGuru()
    {
        $this->db->select('user_login.*, tb_jurusan.namajurusan');
        $this->db->from('user_login');
        $this->db->join('tb_jurusan', 'user_login.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $this->db->where('user_login.role_id', 2);
        $this->db->or_where('user_login.role_id', 3);
        $result = $this->db->get();
        return $result->result_array();
    }
    
    public function getUserGuruById($iduser)
    {
        return $this->db->get_where('user_login', ['iduser' => $iduser])->row_array();
    }

    public function editDataUserGuru()
    {
        $passuser = md5($this->input->post('passuser'));
        if ($passuser == null){
            $passuser = $this->input->post('passuser2', true);
        }
        $data = [
            'namauser'      => $this->input->post('namauser', true),
            'passuser'      => $passuser,
            'namalengkapuser'  => $this->input->post('namalengkapuser', true),
            'is_active'     => $this->input->post('is_active', true)
        ];

        $this->db->where('iduser', $this->input->post('iduser'));
        $this->db->update('user_login', $data);
        return true;
    }

    public function deluserguru($iduser)
    {
        $this->db->delete('user_login', ['iduser' => $iduser]);
        return true;
    }

    public function getAllJurusan()
    {
        return $this->db->get('tb_jurusan')->result_array();
    }

    public function getJurusan()
    {
        $this->db->select('*');
        $this->db->from('tb_jurusan');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function save_jurusan($data)
    {
        $this->db->insert('tb_jurusan', $data);
        return true;
    }

    public function getJurusanById($id)
    {
        return $this->db->get_where('tb_jurusan', ['kodejurusan' => $id])->row_array();
    }

    public function update_jurusan()
    {
        $data = [
            'namajurusan' => $this->input->post('namajur', true),
            'iduser'      => $this->session->userdata('iduser')
        ];

        $this->db->where('kodejurusan', $this->input->post('kode'));
        $this->db->update('tb_jurusan', $data);
        return true;
    }

    public function deljurusan($id)
    {
        $this->db->delete('tb_jurusan', ['kodejurusan' => $id]);
        return true;
    }

    public function getKelas()
    {
        $this->db->select('tb_kelas.*, tb_jurusan.namajurusan');
        $this->db->from('tb_kelas');
        $this->db->join('tb_jurusan', 'tb_kelas.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getKelasByTingkatan($Tingkat)
    {
        $this->db->select('tb_kelas.*, tb_jurusan.namajurusan');
        $this->db->from('tb_kelas');
        $this->db->join('tb_jurusan', 'tb_kelas.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $this->db->where('tb_kelas.kelas', $Tingkat);
        $result = $this->db->get();
        return $result->result();
    }

    public function getDataKelas($id)
    {
        $this->db->select('*');
        $this->db->from('tb_kelas');
        $this->db->where('kodejurusan', $id);
        $this->db->order_by('angkatankelas', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    public function save_kelas($data)
    {
        $this->db->insert('tb_kelas', $data);
        return true;
    }

    public function getKelasById($id)
    {
        return $this->db->get_where('tb_kelas', ['kodekelas' => $id])->row_array();
    }

    public function update_kelas()
    {
        $data = [
            'kodejurusan' => $this->input->post('kodejur', true),
            'namakelas'   => $this->input->post('namakls', true),
            'kelas'       => $this->input->post('kls', true),
            'angkatankelas' => $this->input->post('angkatan', true),
            'is_active'   => $this->input->post('is_active', true),
            'iduser'      => $this->session->userdata('iduser')
        ];

        $this->db->where('kodekelas', $this->input->post('kode'));
        $this->db->update('tb_kelas', $data);
        return true;
    }

    public function delkelas($id)
    {
        $this->db->delete('tb_kelas', ['kodekelas' => $id]);
        return true;
    }

    public function getSiswa()
    {
        $this->db->select('tb_siswa.*, tb_jurusan.namajurusan, tb_kelas.namakelas, tb_kelas.kelas');
        $this->db->from('tb_siswa');
        $this->db->join('tb_jurusan', 'tb_siswa.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $this->db->join('tb_kelas', 'tb_siswa.kodekelas = tb_kelas.kodekelas', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getDataSiswa($Kelas)
    {
        $this->db->select('tb_siswa.*, tb_kelas.kelas, tb_kelas.namakelas');
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_siswa.kodekelas = tb_kelas.kodekelas', 'left');
        $this->db->where('tb_siswa.kodekelas', $Kelas);
        $result = $this->db->get();
        return $result->result();
    }

    public function getDataSiswa2($kodekls)
    {
        $this->db->select('tb_siswa.*, tb_jurusan.namajurusan, tb_kelas.namakelas, tb_kelas.kelas');
        $this->db->from('tb_siswa');
        $this->db->join('tb_jurusan', 'tb_siswa.kodejurusan = tb_jurusan.kodejurusan', 'left');
        $this->db->join('tb_kelas', 'tb_siswa.kodekelas = tb_kelas.kodekelas', 'left');
        $this->db->where('tb_siswa.kodekelas', $kodekls);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function save_siswa($data)
    {
        $this->db->insert('tb_siswa', $data);
        return true;
    }

    public function save_user($data)
    {
        $this->db->insert('user_login', $data);
        return true;
    }

    public function getSiswaById($id)
    {
        return $this->db->get_where('tb_siswa', ['nis' => $id])->row_array();
    }

    public function update_siswa()
    {
        $data = [
            'namasiswa' => $this->input->post('namasiswa', true),
            'jeniskelamin' => $this->input->post('jenkel', true),
            'kodekelas'    => $this->input->post('kodekls', true),
            'kodejurusan'  => $this->input->post('kodejur', true),
            'semester_aktif' => $this->input->post('semester', true),
            'is_active'    => 1,
            'iduser'       => $this->session->userdata('iduser')
        ];

        $this->db->where('nis', $this->input->post('dnis'));
        $this->db->update('tb_siswa', $data);
        return true;
    }

    public function delsiswa($id)
    {
        $this->db->delete('tb_siswa', ['nis' => $id]);
        return true;
    }

    public function getMapel()
    {
        $this->db->select('tb_mapel.*, tb_jurusan.namajurusan, tb_mapel_kelompok.namakelompokmapel');
        $this->db->from('tb_mapel');
        $this->db->join('tb_jurusan', 'tb_jurusan.kodejurusan = tb_mapel.kodejurusan', 'left');
        $this->db->join('tb_mapel_kelompok', 'tb_mapel_kelompok.idkelompokmapel = tb_mapel.idkelompokmapel', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function kode_mp()
    {
        $this->db->select('RIGHT(tb_mapel.kodemapel, 2) as kode', FALSE);
        $this->db->from('tb_mapel');
        $this->db->order_by('kodemapel', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('');      //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) {
            //jika kode ternyata sudah ada.      
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            //jika kode belum ada      
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT); // angka 3 menunjukkan jumlah digit angka 0
        $kodehasil = "MP" . $kodemax;
        return $kodehasil;
    }

    public function save_mapel($data)
    {
        $this->db->insert('tb_mapel', $data);
        return true;
    }

    public function getMapelById($id)
    {
        return $this->db->get_where('tb_mapel', ['kodemapel' => $id])->row_array();
    }

    public function update_mapel()
    {
        $data = [
            'namamapel'     => $this->input->post('namamp', true),
            'tingkatan'     => $this->input->post('tingkatan', true),
            'idkelompokmapel' => $this->input->post('kelompok', true),
            'kodejurusan'   => $this->input->post('kodejur', true),
            'kkm'           => $this->input->post('kkm', true),
            'iduser'        => $this->session->userdata('iduser')
        ];

        $this->db->where('kodemapel', $this->input->post('kode'));
        $this->db->update('tb_mapel', $data);
        return true;
    }

    public function delmapel($id)
    {
        $this->db->delete('tb_mapel', ['kodemapel' => $id]);
        return true;
    }

    public function save_komp($data)
    {
        $this->db->insert('tb_kompdasar', $data);
        return true;
    }

    public function getKompdasarP($id)
    {
        $this->db->select('*');
        $this->db->from('tb_kompdasar');
        $this->db->where('kodemapel', $id);
        $this->db->where('jenis', 'P');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getKompdasarByMapel($id)
    {
        $this->db->select('tb_kompdasar.*, tb_mapel.namamapel');
        $this->db->from('tb_kompdasar');
        $this->db->join('tb_mapel', 'tb_mapel.kodemapel = tb_kompdasar.kodemapel', 'left');        
        $this->db->where('tb_kompdasar.kodemapel', $id);
        // $this->db->where('tb_agenda.status_absen', 0);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getKompById($id)
    {
        return $this->db->get_where('tb_kompdasar', ['idkd' => $id])->row_array();
    }

    public function getKelompok()
    {
        return $this->db->get('tb_mapel_kelompok')->result_array();
    }

    public function getAjar()
    {
        $this->db->select('tb_mengajar.*, tb_mapel.namamapel, tb_guru.namaguru, tb_kelas.namakelas, tb_kelas.kelas');
        $this->db->from('tb_mengajar');
        $this->db->join('tb_mapel', 'tb_mapel.kodemapel = tb_mengajar.kodemapel', 'left');
        $this->db->join('tb_guru', 'tb_guru.nip = tb_mengajar.nip', 'left');
        $this->db->join('tb_kelas', 'tb_kelas.kodekelas = tb_mengajar.kodekelas', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getAmpu($kelas, $semeter, $periode)
    {
        $this->db->select('tb_mengajar.*, tb_kelas.kelas, tb_kelas.namakelas, tb_guru.kodeguru, tb_guru.namaguru, tb_mapel.namamapel, tb_mapel_kelompok.namakelompokmapel');
        $this->db->from('tb_mengajar');
        $this->db->join('tb_kelas', 'tb_mengajar.kodekelas = tb_kelas.kodekelas', 'left');
        $this->db->join('tb_mapel', 'tb_mengajar.kodemapel = tb_mapel.kodemapel', 'left');
        $this->db->join('tb_mapel_kelompok', 'tb_mapel.idkelompokmapel = tb_mapel_kelompok.idkelompokmapel', 'left');
        $this->db->join('tb_guru', 'tb_mengajar.nip = tb_guru.nip', 'left');
        $this->db->where('tb_kelas.kelas', $kelas);
        $this->db->where('tb_mengajar.semester', $semeter);
        $this->db->where('tb_mengajar.periode_mengajar', $periode);
        $result = $this->db->get();
        return $result->result();
    }

    public function save_mengajar($data)
    {
        $this->db->insert('tb_mengajar', $data);
        return true;
    }

    public function getAjarById($id)
    {
        return $this->db->get_where('tb_mengajar', ['idmengajar' => $id])->row_array();
    }

    public function update_ajar()
    {
        $data = [
            'kodemapel' => $this->input->post('kodemapel', true),
            'nip'       => $this->input->post('nip', true),
            'semester'  => $this->input->post('smstr', true),
            'kodekelas' => $this->input->post('kodekls', true),
            'periode_mengajar' => $this->input->post('periode', true)
        ];

        $this->db->where('idmengajar', $this->input->post('kode'));
        $this->db->update('tb_mengajar', $data);
        return true;
    }

    public function delajar($id)
    {
        $this->db->delete('tb_mengajar', ['idmengajar' => $id]);
        return true;
    }

    public function getAbsen($kelas, $semester)
    {
        $sql = "SELECT tb_siswa.nis, tb_siswa.namasiswa,

                /* ----------- jumlah sakit ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'S'
                AND tb_absensi.semester = '$semester'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS sakit,

                /* ----------- jumlah ijin ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'I'
                AND tb_absensi.semester = '$semester'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS ijin,

                /* ----------- jumlah alpa ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'A'
                AND tb_absensi.semester = '$semester'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS alpha

            FROM tb_siswa
            WHERE tb_siswa.kodekelas = '$kelas'
            GROUP BY tb_siswa.nis
            ORDER BY tb_siswa.nis ASC;";

        return $this->db->query($sql);
    }

    public function getAbsenbyMengajar($kelas, $mengajar)
    {
        $sql = "SELECT tb_siswa.nis, tb_siswa.namasiswa,

                /* ----------- jumlah hadir ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'H'
                AND tb_absensi.idmengajar = '$mengajar'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS hadir,

                /* ----------- jumlah sakit ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'S'
                AND tb_absensi.idmengajar = '$mengajar'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS sakit,

                /* ----------- jumlah ijin ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'I'
                AND tb_absensi.idmengajar = '$mengajar'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS izin,

                /* ----------- jumlah alpa ------------*/
                IFNULL((SELECT COUNT(tb_absensi.keterangan)
                FROM tb_absensi
                WHERE tb_absensi.keterangan = 'A'
                AND tb_absensi.idmengajar = '$mengajar'
                AND tb_absensi.nis = tb_siswa.nis
                AND tb_absensi.nis IN (SELECT tb_siswa.nis
                                FROM tb_siswa
                                WHERE tb_siswa.kodekelas = '$kelas'
                                ORDER BY tb_siswa.nis ASC)
                GROUP BY tb_absensi.nis
                ORDER BY tb_absensi.nis ASC), 0) AS alfa

            FROM tb_siswa
            WHERE tb_siswa.kodekelas = '$kelas'
            GROUP BY tb_siswa.nis
            ORDER BY tb_siswa.nis ASC;";

        return $this->db->query($sql);
    }
}
