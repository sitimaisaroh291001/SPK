<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan_model extends CI_Model {

    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    public function get_alternatif()
    {
        return $this->db->get('alternatif')->result();
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL NILAI MODUS RESPONDEN
    |--------------------------------------------------------------------------
    */

    public function data_nilai($id_alternatif, $id_kriteria)
    {
        /*
        |--------------------------------------------------------------------------
        | Mapping Kriteria
        |--------------------------------------------------------------------------
        | 46 = nilai_a
        | 47 = nilai_b
        | 48 = nilai_c
        | dst
        |--------------------------------------------------------------------------
        */

        $mapping = [

            46 => 'nilai_a',
            47 => 'nilai_b',
            48 => 'nilai_c',
            49 => 'nilai_d',
            50 => 'nilai_e',
            51 => 'nilai_f',
            52 => 'nilai_g',

        ];

        /*
        |--------------------------------------------------------------------------
        | Ambil nama field
        |--------------------------------------------------------------------------
        */

        $field = $mapping[$id_kriteria];

        /*
        |--------------------------------------------------------------------------
        | Ambil MODUS
        |--------------------------------------------------------------------------
        */

        $query = $this->db->query("
            SELECT $field, COUNT($field) as total

            FROM responden

            WHERE asal_alternatif = '$id_alternatif'

            GROUP BY $field

            ORDER BY total DESC

            LIMIT 1
        ");

        $hasil = $query->row_array();

        /*
        |--------------------------------------------------------------------------
        | Jika belum ada responden
        |--------------------------------------------------------------------------
        */

        if (!$hasil) {

            return [
                'nilai' => 0
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Return format lama agar view tidak error
        |--------------------------------------------------------------------------
        */

        return [
            'nilai' => $hasil[$field]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MAX MIN
    |--------------------------------------------------------------------------
    */

    public function get_max_min($id_kriteria)
    {
        $alternatif = $this->get_alternatif();

        $nilai_list = [];

        foreach ($alternatif as $a) {

            $nilai = $this->data_nilai(
                $a->id_alternatif,
                $id_kriteria
            );

            $nilai_list[] = $nilai['nilai'];
        }

        $jenis = $this->db
            ->where('id_kriteria', $id_kriteria)
            ->get('kriteria')
            ->row_array();

        return [

            'max' => max($nilai_list),

            'min' => min($nilai_list),

            'jenis' => $jenis['jenis']
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | HASIL RANKING
    |--------------------------------------------------------------------------
    */

    public function get_hasil()
    {
        return $this->db->query("
            SELECT *

            FROM hasil

            JOIN alternatif
            ON hasil.id_alternatif = alternatif.id_alternatif

            ORDER BY nilai DESC
        ")->result();
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT HASIL
    |--------------------------------------------------------------------------
    */

    public function insert_nilai_hasil($hasil_akhir = [])
    {
        return $this->db->insert('hasil', $hasil_akhir);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS HASIL
    |--------------------------------------------------------------------------
    */

    public function hapus_hasil()
    {
        return $this->db->query("TRUNCATE TABLE hasil");
    }
}