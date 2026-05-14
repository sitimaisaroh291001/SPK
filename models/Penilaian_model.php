<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model {

    public function get_kriteria()
    {
        $query = $this->db->get('kriteria');
        return $query->result();
    }

    public function get_alternatif()
    {
        $query = $this->db->query("SELECT * FROM alternatif");
        return $query->result();
    }

    public function get_sub_kriteria()
    {
        $query = $this->db->get('sub_kriteria');
        return $query->result();
    }

    public function data_sub_kriteria($id_kriteria)
    {
        $query = $this->db->query("
            SELECT * FROM sub_kriteria 
            WHERE id_kriteria='$id_kriteria' 
            ORDER BY nilai DESC
        ");

        return $query->result_array();
    }

    public function get_responden()
    {
        $query = $this->db->query("
            SELECT 
                alternatif.id_alternatif,
                alternatif.nama,
                COUNT(responden.id_responden) as jumlah_responden

            FROM alternatif

            LEFT JOIN responden 
            ON responden.asal_alternatif = alternatif.id_alternatif

            GROUP BY alternatif.id_alternatif
        ");

        return $query->result();
    }
}