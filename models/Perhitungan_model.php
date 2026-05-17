<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan_model extends CI_Model {

    /*
    |--------------------------------------------------------------------------
    | GET KRITERIA
    |--------------------------------------------------------------------------
    */

    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALTERNATIF
    |--------------------------------------------------------------------------
    */

    public function get_alternatif()
    {
        return $this->db->get('alternatif')->result();
    }

    /*
    |--------------------------------------------------------------------------
    | DATA NILAI
    |--------------------------------------------------------------------------
    */

    public function data_nilai($id_alternatif, $id_kriteria)
    {

        $query = $this->db->query("

            SELECT *

            FROM penilaian

            JOIN sub_kriteria
            ON penilaian.nilai =
            sub_kriteria.id_sub_kriteria

            WHERE
            penilaian.id_alternatif='$id_alternatif'
            AND
            penilaian.id_kriteria='$id_kriteria'

        ");

        return $query->row_array();
    }

    /*
    |--------------------------------------------------------------------------
    | GET MAX MIN
    |--------------------------------------------------------------------------
    */

    public function get_max_min($id_kriteria)
    {

        $query = $this->db->query("

            SELECT

            MAX(sub_kriteria.nilai) as max,

            MIN(sub_kriteria.nilai) as min,

            kriteria.jenis

            FROM penilaian

            JOIN sub_kriteria
            ON penilaian.nilai =
            sub_kriteria.id_sub_kriteria

            JOIN kriteria
            ON penilaian.id_kriteria =
            kriteria.id_kriteria

            WHERE penilaian.id_kriteria='$id_kriteria'

        ");

        return $query->row_array();
    }

    /*
    |--------------------------------------------------------------------------
    | GET HASIL
    |--------------------------------------------------------------------------
    */

    public function get_hasil()
    {

        $query = $this->db->query("

            SELECT *

            FROM hasil

            JOIN alternatif
            ON hasil.id_alternatif =
            alternatif.id_alternatif

            ORDER BY nilai DESC

        ");

        return $query->result();
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT HASIL
    |--------------------------------------------------------------------------
    */

    public function insert_nilai_hasil($hasil_akhir = [])
    {
        return $this->db->insert(
            'hasil',
            $hasil_akhir
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS HASIL
    |--------------------------------------------------------------------------
    */

    public function hapus_hasil()
    {
        return $this->db->query(
            "TRUNCATE TABLE hasil"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SENSITIVITY ANALYSIS
    |--------------------------------------------------------------------------
    */

    public function get_hasil_sensitivity(
        $persen = 10,
        $tipe = 'plus'
    )
    {

        $alternatif = $this->get_alternatif();

        $kriteria = $this->get_kriteria();

        $hasil = [];

        $bobot_baru = [];

        $total_bobot = 0;

        /*
        |--------------------------------------------------------------------------
        | PERUBAHAN BOBOT
        |--------------------------------------------------------------------------
        */

        foreach ($kriteria as $k) {

            $bobot = $k->bobot;

            /*
            |--------------------------------------------------------------------------
            | KRITERIA A
            |--------------------------------------------------------------------------
            */

            if ($k->kode_kriteria == 'A') {

                if ($tipe == 'plus') {

                    $bobot =
                    $bobot *
                    (1 + ($persen / 100));

                } else {

                    $bobot =
                    $bobot *
                    (1 - ($persen / 100));
                }
            }

            $bobot_baru[$k->id_kriteria] =
            $bobot;

            $total_bobot += $bobot;
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI ULANG
        |--------------------------------------------------------------------------
        */

        foreach ($bobot_baru as $id => $nilai) {

            $bobot_baru[$id] =
            $nilai / $total_bobot;
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG WASPAS
        |--------------------------------------------------------------------------
        */

        foreach ($alternatif as $a) {

            $ta = 0;

            $pa = 1;

            foreach ($kriteria as $k) {

                $data_nilai =
                $this->data_nilai(
                    $a->id_alternatif,
                    $k->id_kriteria
                );

                $min_max =
                $this->get_max_min(
                    $k->id_kriteria
                );

                /*
                |--------------------------------------------------------------------------
                | NORMALISASI
                |--------------------------------------------------------------------------
                */

                if ($min_max['jenis'] == 'Benefit') {

                    $r =
                    $data_nilai['nilai'] /
                    $min_max['max'];

                } else {

                    $r =
                    $min_max['min'] /
                    $data_nilai['nilai'];
                }

                $w =
                $bobot_baru[$k->id_kriteria];

                $ta += ($r * $w);

                $pa *= pow($r, $w);
            }

            /*
            |--------------------------------------------------------------------------
            | NILAI Qi
            |--------------------------------------------------------------------------
            */

            $qi =
            (0.5 * $ta) +
            (0.5 * $pa);

            $hasil[] = [

                'nama' => $a->nama,

                'nilai_qi' => $qi
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        usort($hasil, function($a, $b){

            return $b['nilai_qi']
            <=>
            $a['nilai_qi'];

        });

        return $hasil;
    }
}