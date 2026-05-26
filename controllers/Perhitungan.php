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

            'page'=>"Perhitungan",

            'kriteria'=>
            $this->Perhitungan_model
            ->get_kriteria(),

            'alternatif'=>
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

        $data=[

            'page'=>'Hasil',

            'hasil'=>
            $this->Perhitungan_model
            ->get_hasil()

        ];

        $this->load->view(
            'Perhitungan/hasil',
            $data
        );

    }



    // =====================================
    // SENSITIVITY
    // =====================================

    public function sensitivity()
    {

        $hasil_awal=
        $this->Perhitungan_model
        ->get_hasil();


        $kriteria=
        $this->Perhitungan_model
        ->get_kriteria();


        $alternatif=
        $this->Perhitungan_model
        ->get_alternatif();



        $bobot=[];

        foreach($kriteria as $k){

            $bobot[
                $k->id_kriteria
            ]
            =
            $k->bobot;

        }



        // +10% semua bobot

        $bobot_plus=[];

        foreach(
            $bobot as
            $id=>$nilai
        ){

            $bobot_plus[$id]
            =
            $nilai*1.1;

        }



        // -10% semua bobot

        $bobot_minus=[];

        foreach(
            $bobot as
            $id=>$nilai
        ){

            $bobot_minus[$id]
            =
            $nilai*0.9;

        }



        $hasil_plus=[];

        $hasil_minus=[];



        foreach(
            $alternatif as $alt
        ){

            $ta_plus=0;
            $pa_plus=1;

            $ta_minus=0;
            $pa_minus=1;



            foreach(
                $kriteria as $k
            ){

                $nilai=
                $this->Perhitungan_model
                ->data_nilai(
                    $alt->id_alternatif,
                    $k->id_kriteria
                );



                $minmax=
                $this->Perhitungan_model
                ->get_max_min(
                    $k->id_kriteria
                );



                if(
                    $k->jenis=="Benefit"
                ){

                    $r=
                    $nilai['nilai']
                    /
                    $minmax['max'];

                }
                else{

                    $r=
                    $minmax['min']
                    /
                    $nilai['nilai'];

                }


                $r=round($r,4);



                $ta_plus +=
                $r*
                $bobot_plus[
                    $k->id_kriteria
                ];



                $pa_plus *=
                pow(
                    $r,
                    $bobot_plus[
                    $k->id_kriteria
                    ]
                );



                $ta_minus +=
                $r*
                $bobot_minus[
                    $k->id_kriteria
                ];



                $pa_minus *=
                pow(
                    $r,
                    $bobot_minus[
                    $k->id_kriteria
                    ]
                );

            }



            $qi_plus=
            round(
            (0.5*$ta_plus)
            +
            (0.5*$pa_plus),
            6
            );



            $qi_minus=
            round(
            (0.5*$ta_minus)
            +
            (0.5*$pa_minus),
            6
            );



            $hasil_plus[]=[

                'nama'=>
                $alt->nama,

                'nilai'=>
                $qi_plus

            ];



            $hasil_minus[]=[

                'nama'=>
                $alt->nama,

                'nilai'=>
                $qi_minus

            ];

        }



        usort(
            $hasil_plus,
            function($a,$b){

                return
                $b['nilai']
                <=>
                $a['nilai'];

            }
        );


        usort(
            $hasil_minus,
            function($a,$b){

                return
                $b['nilai']
                <=>
                $a['nilai'];

            }
        );



        $data=[

            'page'=>'Sensitivity',

            'hasil_awal'=>$hasil_awal,

            'hasil_plus'=>$hasil_plus,

            'hasil_minus'=>$hasil_minus

        ];



        $this->load->view(
            'Perhitungan/sensitivity',
            $data
        );

    }

}