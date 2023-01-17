<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class Import extends CI_Controller
{
    public function upload()
    {
        $file_mimes = ['application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['berkas_excel']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            for ($i = 1; $i+1 < count($sheetData); $i++) {
                if($sheetData[$i]['1']==null) {
                    break;
                }
                $jurusan = $sheetData[$i]['5'];
                if ($jurusan == null) {
                    $jurusan = "-";
                }
                $data = [
                    'nip' => $sheetData[$i]['1'],
                    'kodeguru' => $sheetData[$i]['2'],
                    'namaguru' => $sheetData[$i]['3'],
                    'jeniskelamin' => $sheetData[$i]['4'],
                    'kodejurusan'  => $jurusan
                ];
                $this->db->insert('tb_guru', $data);
            }
            $this->session->set_flashdata('message', 'data guru berhasil di-import');
            redirect('master/guru');
        }
    }

    public function uploadmapel()
    {
        $file_mimes = ['application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['berkas_excel']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            for ($i = 1; $i < count($sheetData); $i++) {

                $data = [
                    'kodemapel' => $sheetData[$i]['1'],
                    'namamapel' => $sheetData[$i]['2'],
                    'tingkatan' => $sheetData[$i]['3'],
                    'kodejurusan' => $sheetData[$i]['5']
                ];

                $this->db->insert('tb_mapel', $data);
            }
            $this->session->set_flashdata('message', 'data mapel berhasil di-import');
            redirect('master/mapel');
        }
    }

    public function uploadsiswa()
    {
        $file_mimes = ['application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['berkas_excel']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            for ($i = 1; $i < count($sheetData); $i++) {
                if($sheetData[$i]['1']==null) {
                    break;
                }
                $data = [
                    'nis'           => $sheetData[$i]['1'],
                    'namasiswa'     => $sheetData[$i]['2'],
                    'jeniskelamin'  => $sheetData[$i]['3'],
                    'kodekelas'     => $this->input->post('kodekls'),
                    'kodejurusan'   => $this->input->post('kodejur'),
                    'semester_aktif' => $this->input->post('semester')
                ];

                $data2 = [
                    'iduser' => $sheetData[$i]['1'],
                    'namauser' => $sheetData[$i]['1'],
                    'passuser' => md5($sheetData[$i]['1']),
                    'namalengkapuser' => $sheetData[$i]['2'],
                    'role_id' => 4,
                    'is_active'  => 1,
                    'kodejurusan'  => $this->input->post('kodejur'),
                    'semester_aktif'  => $this->input->post('semester')
                ];

                $this->db->insert('user_login', $data2);

                $this->db->insert('tb_siswa', $data);
            }
            $k = $this->input->post('kodekls');
            $this->session->set_flashdata('message', 'data siswa berhasil di-import');
            redirect('master/siswa/'.$k);
        }
    }
}
