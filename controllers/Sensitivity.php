<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sensitivity extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function index()
    {

        // ==========================
        // HASIL AWAL
        // ==========================

        $hasil_awal =
        $this->hitungWaspas();



        // ==========================
        // AMBIL BOBOT AHP
        // ==========================

        $kriteria =
        $this->db
        ->get('kriteria')
        ->result();

        $bobot=[];

        foreach($kriteria as $k){

            $bobot[
                $k->id_kriteria
            ]
            =
            $k->bobot;

        }



        // ==========================
        // +10% SEMUA BOBOT
        // ==========================

        $bobot_plus=[];

        foreach(
            $bobot as
            $id=>$nilai
        ){

            $bobot_plus[$id]
            =
            $nilai*1.1;

        }



        // ==========================
        // -10% SEMUA BOBOT
        // ==========================

        $bobot_minus=[];

        foreach(
            $bobot as
            $id=>$nilai
        ){

            $bobot_minus[$id]
            =
            $nilai*0.9;

        }



        // ==========================
        // HITUNG ULANG WASPAS
        // ==========================

        $hasil_plus =
        $this->hitungWaspas(
            $bobot_plus
        );



        $hasil_minus =
        $this->hitungWaspas(
            $bobot_minus
        );



        // ==========================
        // KIRIM DATA KE VIEW
        // ==========================

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





    private function hitungWaspas(
        $bobot_custom=null
    )
    {

        // =======================
        // AMBIL BOBOT ASLI
        // =======================

        if(
            $bobot_custom==null
        ){

            $kr=
            $this->db
            ->get('kriteria')
            ->result();


            $b=[];


            foreach(
                $kr as $k
            ){

                $b[
                    $k->id_kriteria
                ]
                =
                $k->bobot;

            }

            $bobot_custom=$b;

        }



        // =======================
        // ALTERNATIF
        // =======================

        $alternatif=
        $this->db
        ->get(
            'alternatif'
        )
        ->result();



        $hasil=[];



        foreach(
            $alternatif as $a
        ){


            $nilai=
            $this->db
            ->where(
                'id_alternatif',
                $a->id_alternatif
            )
            ->get(
                'penilaian'
            )
            ->result();



            $wsm=0;

            $wpm=1;



            foreach(
                $nilai as $n
            ){


                $id=
                $n->id_kriteria;



                // ===================
                // AMBIL KRITERIA
                // ===================

                $kriteria=
                $this->db
                ->where(
                    'id_kriteria',
                    $id
                )
                ->get(
                    'kriteria'
                )
                ->row();



                // ===================
                // MAX
                // ===================

                $max=
                $this->db
                ->select_max(
                    'nilai'
                )
                ->where(
                    'id_kriteria',
                    $id
                )
                ->get(
                    'penilaian'
                )
                ->row()
                ->nilai;



                // ===================
                // MIN
                // ===================

                $min=
                $this->db
                ->select_min(
                    'nilai'
                )
                ->where(
                    'id_kriteria',
                    $id
                )
                ->get(
                    'penilaian'
                )
                ->row()
                ->nilai;




                // ===================
                // NORMALISASI
                // ===================

                if(
                    $kriteria->jenis
                    ==
                    'Benefit'
                ){

                    $r=
                    $n->nilai
                    /
                    $max;

                }
                else
                {

                    $r=
                    $min
                    /
                    $n->nilai;

                }



                // mengikuti pembulatan manual

                $r=
                round(
                    $r,
                    4
                );




                // ===================
                // WSM
                // ===================

                $wsm +=
                round(
                    (
                        $r
                        *
                        $bobot_custom[$id]
                    ),
                    6
                );



                // ===================
                // WPM
                // ===================

                $wpm *=
                round(
                    pow(
                        $r,
                        $bobot_custom[$id]
                    ),
                    6
                );

            }



            // ===================
            // QI
            // ===================

            $qi=
            round(
                (
                    (0.5*$wsm)
                    +
                    (0.5*$wpm)
                ),
                6
            );



            $hasil[]=[

                'nama'=>
                $a->nama,

                'nilai'=>
                $qi

            ];

        }



        usort(

            $hasil,

            function(
                $a,
                $b
            ){

                return
                $b['nilai']
                <=>
                $a['nilai'];

            }

        );



        return
        $hasil;

    }

}