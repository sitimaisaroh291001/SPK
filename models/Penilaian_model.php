<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model {

    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    public function get_alternatif()
    {
        return $this->db->query("SELECT * FROM alternatif")->result();
    }

    public function get_sub_kriteria()
    {
        return $this->db->get('sub_kriteria')->result();
    }

    public function data_sub_kriteria($id_kriteria)
    {
        return $this->db->query("
            SELECT * FROM sub_kriteria
            WHERE id_kriteria='$id_kriteria'
            ORDER BY nilai DESC
        ")->result_array();
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

    public function get_modus($id)
    {
        $fields = ['a','b','c','d','e','f','g'];
        $hasil = [];

        foreach ($fields as $f) {

            $query = $this->db->query("
                SELECT nilai_$f, COUNT(nilai_$f) as total
                FROM responden
                WHERE asal_alternatif = '$id'
                GROUP BY nilai_$f
                ORDER BY total DESC
                LIMIT 1
            ")->row();

            $hasil['nilai_'.$f] = $query ? $query->{'nilai_'.$f} : 0;
        }

        return $hasil;
    }
}