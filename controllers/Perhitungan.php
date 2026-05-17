<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Perhitungan_model');
    }

    /*
    =========================================
    HALAMAN PERHITUNGAN
    =========================================
    */

    public function index()
    {
        $data = [
            'page'       => 'Perhitungan',
            'kriteria'   => $this->Perhitungan_model->get_kriteria(),
            'alternatif' => $this->Perhitungan_model->get_alternatif()
        ];

        $this->load->view('perhitungan/perhitungan', $data);
    }

    /*
    =========================================
    HASIL
    =========================================
    */

    public function hasil()
    {
        $data = [
            'page'  => 'Hasil',
            'hasil' => $this->Perhitungan_model->get_hasil()
        ];

        $this->load->view('perhitungan/hasil', $data);
    }

    /*
    =========================================
    SENSITIVITY ANALYSIS
    =========================================
    */

    public function sensitivity()
    {

        $kriteria   = $this->Perhitungan_model->get_kriteria();
        $alternatif = $this->Perhitungan_model->get_alternatif();

        /*
        ==========================
        BOBOT AWAL
        ==========================
        */

        $bobot_awal = [];

        foreach($kriteria as $k){

            $bobot_awal[$k->id_kriteria] = $k->bobot;

        }

        /*
        ==========================
        +10%
        ==========================
        */

        $bobot_plus = $bobot_awal;

        $id_utama = $kriteria[0]->id_kriteria;

        $bobot_plus[$id_utama] =
            $bobot_plus[$id_utama] * 1.1;

        $total_plus = array_sum($bobot_plus);

        foreach($bobot_plus as $id => $b){

            $bobot_plus[$id] = $b / $total_plus;

        }

        /*
        ==========================
        -10%
        ==========================
        */

        $bobot_minus = $bobot_awal;

        $bobot_minus[$id_utama] =
            $bobot_minus[$id_utama] * 0.9;

        $total_minus = array_sum($bobot_minus);

        foreach($bobot_minus as $id => $b){

            $bobot_minus[$id] = $b / $total_minus;

        }

        /*
        ==========================
        HITUNG
        ==========================
        */

        $hasil_awal  = [];
        $hasil_plus  = [];
        $hasil_minus = [];

        foreach($alternatif as $a){

            $qi_awal  = 0;
            $qi_plus  = 0;
            $qi_minus = 0;

            foreach($kriteria as $k){

                $nilai =
                    $this->Perhitungan_model
                    ->data_nilai(
                        $a->id_alternatif,
                        $k->id_kriteria
                    );

                $minmax =
                    $this->Perhitungan_model
                    ->get_max_min($k->id_kriteria);

                if(!$nilai){
                    continue;
                }

                $x = $nilai['nilai'];

                if($minmax['jenis'] == 'Benefit'){

                    $r = $x / $minmax['max'];

                }else{

                    $r = $minmax['min'] / $x;

                }

                /*
                AWAL
                */

                $qi_awal +=
                    $r *
                    $bobot_awal[$k->id_kriteria];

                /*
                PLUS
                */

                $qi_plus +=
                    $r *
                    $bobot_plus[$k->id_kriteria];

                /*
                MINUS
                */

                $qi_minus +=
                    $r *
                    $bobot_minus[$k->id_kriteria];

            }

            $hasil_awal[] = [
                'nama'  => $a->nama,
                'nilai' => $qi_awal
            ];

            $hasil_plus[] = [
                'nama'  => $a->nama,
                'nilai' => $qi_plus
            ];

            $hasil_minus[] = [
                'nama'  => $a->nama,
                'nilai' => $qi_minus
            ];
        }

        /*
        ==========================
        SORTING
        ==========================
        */

        usort($hasil_awal, function($a,$b){

            return $b['nilai'] <=> $a['nilai'];

        });

        usort($hasil_plus, function($a,$b){

            return $b['nilai'] <=> $a['nilai'];

        });

        usort($hasil_minus, function($a,$b){

            return $b['nilai'] <=> $a['nilai'];

        });

        /*
        ==========================
        KIRIM DATA
        ==========================
        */

        $data = [

            'page'         => 'Sensitivity',

            'hasil_awal'   => $hasil_awal,

            'hasil_plus'   => $hasil_plus,

            'hasil_minus'  => $hasil_minus

        ];

        $this->load->view(
            'perhitungan/sensitivity',
            $data
        );
    }
}