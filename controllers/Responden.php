<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Responden extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN FORM KUESIONER
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $data['alternatif'] =
        $this->db->get('alternatif')->result();

        $data['kriteria'] =
        $this->db->get('kriteria')->result();

        $data['sub_kriteria'] =
        $this->db->get('sub_kriteria')->result();

        $this->load->view(
            'responden/index',
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA RESPONDEN
    |--------------------------------------------------------------------------
    */

    public function simpan()
    {

        $nilai = $this->input->post('nilai');

        $data = [

            'nama_responden' =>
            $this->input->post('nama_responden'),

            'asal_alternatif' =>
            $this->input->post('id_alternatif'),

            /*
            |--------------------------------------------------------------------------
            | NILAI KRITERIA
            |--------------------------------------------------------------------------
            | Menggunakan kode kriteria A-G
            */

            'nilai_a' =>
            isset($nilai['A']) ? $nilai['A'] : 0,

            'nilai_b' =>
            isset($nilai['B']) ? $nilai['B'] : 0,

            'nilai_c' =>
            isset($nilai['C']) ? $nilai['C'] : 0,

            'nilai_d' =>
            isset($nilai['D']) ? $nilai['D'] : 0,

            'nilai_e' =>
            isset($nilai['E']) ? $nilai['E'] : 0,

            'nilai_f' =>
            isset($nilai['F']) ? $nilai['F'] : 0,

            'nilai_g' =>
            isset($nilai['G']) ? $nilai['G'] : 0,

        ];

        /*
        |--------------------------------------------------------------------------
        | INSERT KE DATABASE
        |--------------------------------------------------------------------------
        */

        $this->db->insert(
            'responden',
            $data
        );

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        redirect('responden/sukses');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN SUKSES
    |--------------------------------------------------------------------------
    */

    public function sukses()
    {

        echo "

        <div style='
            margin-top:100px;
            text-align:center;
            font-family:Arial;
        '>

            <h2>
                Penilaian berhasil dikirim
            </h2>

            <br>

            <a href='".base_url('responden')."'
               style='
               background:#28a745;
               color:white;
               padding:10px 20px;
               text-decoration:none;
               border-radius:5px;
               '>

               Kembali

            </a>

        </div>

        ";
    }
}