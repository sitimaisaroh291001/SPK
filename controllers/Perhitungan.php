<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->library('form_validation');

        $this->load->model('Perhitungan_model');
    }

    // =====================================
    // HALAMAN PERHITUNGAN
    // =====================================

    public function index()
    {
        $data = [

            'page' => "Perhitungan",

            'kriteria' =>
            $this->Perhitungan_model
            ->get_kriteria(),

            'alternatif' =>
            $this->Perhitungan_model
            ->get_alternatif()

        ];

        $this->load->view(
            'Perhitungan/perhitungan',
            $data
        );
    }

    // =====================================
    // HALAMAN HASIL
    // =====================================

    public function hasil()
    {

        $data = [

            'page' => 'Hasil',

            'hasil' =>
            $this->Perhitungan_model
            ->get_hasil()

        ];

        $this->load->view(
            'Perhitungan/hasil',
            $data
        );
    }

}