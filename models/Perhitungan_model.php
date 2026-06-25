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

}