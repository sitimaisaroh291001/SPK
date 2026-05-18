<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan_model extends CI_Model {

    /*
    =========================================
    AMBIL DATA KRITERIA
    =========================================
    */
    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    /*
    =========================================
    AMBIL DATA ALTERNATIF
    =========================================
    */
    public function get_alternatif()
    {
        return $this->db->get('alternatif')->result();
    }

    /*
    =========================================
    AMBIL NILAI MODUS RESPONDEN
    =========================================
    */
    public function get_nilai_modus($id_alternatif, $id_kriteria)
    {
        $query = $this->db->query("
            SELECT 
                sub_kriteria.nilai,
                COUNT(*) as total

            FROM penilaian

            JOIN sub_kriteria
            ON penilaian.nilai = sub_kriteria.id_sub_kriteria

            WHERE penilaian.id_alternatif = '$id_alternatif'
            AND penilaian.id_kriteria = '$id_kriteria'

            GROUP BY sub_kriteria.nilai

            ORDER BY total DESC, sub_kriteria.nilai DESC

            LIMIT 1
        ");

        $row = $query->row_array();

        if($row){
            return $row['nilai'];
        }else{
            return 1;
        }
    }

    /*
    =========================================
    DATA NILAI UNTUK MATRIX KEPUTUSAN
    =========================================
    */
    public function data_nilai($id_alternatif, $id_kriteria)
    {
        $nilai_modus = $this->get_nilai_modus(
            $id_alternatif,
            $id_kriteria
        );

        return [
            'nilai' => $nilai_modus
        ];
    }

    /*
    =========================================
    AMBIL MAX DAN MIN
    =========================================
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
    =========================================
    AMBIL DATA HASIL
    =========================================
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
    =========================================
    INSERT HASIL
    =========================================
    */
    public function insert_nilai_hasil($hasil_akhir = [])
    {
        return $this->db->insert(
            'hasil',
            $hasil_akhir
        );
    }

    /*
    =========================================
    HAPUS HASIL
    =========================================
    */
    public function hapus_hasil()
    {
        return $this->db->query("
            TRUNCATE TABLE hasil
        ");
    }

}