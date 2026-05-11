<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Responden extends CI_Controller {

    // halaman form
    public function index()
    {
        // ambil alternatif
        $data['alternatif'] = $this->db
            ->get('alternatif')
            ->result();

        // ambil kriteria
        $data['kriteria'] = $this->db
            ->get('kriteria')
            ->result();

        // ambil sub kriteria
        $data['sub_kriteria'] = $this->db
            ->get('sub_kriteria')
            ->result();

        // tampilkan view
        $this->load->view('responden/index', $data);
    }

    // proses simpan penilaian
    public function simpan()
    {
        $nama = $this->input->post('nama_responden');
        $id_alternatif = $this->input->post('id_alternatif');
        $nilai = $this->input->post('nilai');

        // simpan responden
        $this->db->insert('responden', [
            'nama_responden' => $nama,
            'asal_alternatif' => $id_alternatif
        ]);

        $id_responden = $this->db->insert_id();

        // simpan penilaian
        foreach($nilai as $id_kriteria => $v){

            $this->db->insert('penilaian', [
                'id_responden' => $id_responden,
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id_kriteria,
                'nilai' => $v
            ]);

        }

        redirect('responden');
    }

}