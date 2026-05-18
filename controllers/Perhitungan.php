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

    // =========================================
    // HALAMAN PERHITUNGAN
    // =========================================
    public function index()
    {
        if ($this->session->userdata('id_user_level') != "1") {

            ?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location='<?php echo base_url("Login/home"); ?>'
            </script>
            <?php
        }

        $data = [

            'page'       => "Perhitungan",

            'kriteria'   => $this->Perhitungan_model->get_kriteria(),

            'alternatif' => $this->Perhitungan_model->get_alternatif(),
        ];

        $this->load->view(
            'Perhitungan/perhitungan',
            $data
        );
    }

    // =========================================
    // HALAMAN HASIL
    // =========================================
    public function hasil()
    {
        $data = [

            'page'  => "Hasil",

            'hasil' => $this->Perhitungan_model->get_hasil()
        ];

        $this->load->view(
            'Perhitungan/hasil',
            $data
        );
    }

    // =========================================
    // SENSITIVITY ANALYSIS
    // =========================================
    public function sensitivity()
    {
        $kriteria   = $this->Perhitungan_model->get_kriteria();

        $alternatif = $this->Perhitungan_model->get_alternatif();

        // =====================================
        // KRITERIA UTAMA
        // =====================================
        $kriteria_utama = $kriteria[0];

        // =====================================
        // BOBOT AWAL
        // =====================================
        $bobot_awal = [];

        foreach ($kriteria as $k) {

            $bobot_awal[$k->id_kriteria] = $k->bobot;
        }

        // =====================================
        // BOBOT +10%
        // =====================================
        $bobot_plus = $bobot_awal;

        $bobot_plus[$kriteria_utama->id_kriteria] =
            $bobot_plus[$kriteria_utama->id_kriteria] * 1.1;

        $total_plus = array_sum($bobot_plus);

        foreach ($bobot_plus as $id => $b) {

            $bobot_plus[$id] = $b / $total_plus;
        }

        // =====================================
        // BOBOT -10%
        // =====================================
        $bobot_minus = $bobot_awal;

        $bobot_minus[$kriteria_utama->id_kriteria] =
            $bobot_minus[$kriteria_utama->id_kriteria] * 0.9;

        $total_minus = array_sum($bobot_minus);

        foreach ($bobot_minus as $id => $b) {

            $bobot_minus[$id] = $b / $total_minus;
        }

        // =====================================
        // ARRAY HASIL
        // =====================================
        $hasil_awal  = [];

        $hasil_plus  = [];

        $hasil_minus = [];

        // =====================================
        // PERHITUNGAN
        // =====================================
        foreach ($alternatif as $alt) {

            // =================================
            // AMBIL QI AWAL
            // =================================
            $hasil_db = $this->db
                ->where('id_alternatif', $alt->id_alternatif)
                ->get('hasil')
                ->row();

            $qi_awal = $hasil_db ? $hasil_db->nilai : 0;

            // =================================
            // VARIABEL WASPAS
            // =================================
            $ta_plus  = 0;
            $pa_plus  = 1;

            $ta_minus = 0;
            $pa_minus = 1;

            // =================================
            // LOOP KRITERIA
            // =================================
            foreach ($kriteria as $k) {

                $nilai = $this->Perhitungan_model
                    ->data_nilai(
                        $alt->id_alternatif,
                        $k->id_kriteria
                    );

                $minmax = $this->Perhitungan_model
                    ->get_max_min($k->id_kriteria);

                // =============================
                // NORMALISASI
                // =============================
                if ($minmax['jenis'] == 'Benefit') {

                    $r =
                        $nilai['nilai'] /
                        $minmax['max'];

                } else {

                    $r =
                        $minmax['min'] /
                        $nilai['nilai'];
                }

                // =============================
                // +10%
                // =============================
                $ta_plus +=
                    $r *
                    $bobot_plus[$k->id_kriteria];

                $pa_plus *=
                    pow(
                        $r,
                        $bobot_plus[$k->id_kriteria]
                    );

                // =============================
                // -10%
                // =============================
                $ta_minus +=
                    $r *
                    $bobot_minus[$k->id_kriteria];

                $pa_minus *=
                    pow(
                        $r,
                        $bobot_minus[$k->id_kriteria]
                    );
            }

            // =================================
            // HITUNG QI
            // =================================
            $qi_plus =
                (0.5 * $ta_plus) +
                (0.5 * $pa_plus);

            $qi_minus =
                (0.5 * $ta_minus) +
                (0.5 * $pa_minus);

            // =================================
            // SIMPAN HASIL
            // =================================
            $hasil_awal[] = [

                'nama'  => $alt->nama,

                'nilai' => $qi_awal
            ];

            $hasil_plus[] = [

                'nama'  => $alt->nama,

                'nilai' => $qi_plus
            ];

            $hasil_minus[] = [

                'nama'  => $alt->nama,

                'nilai' => $qi_minus
            ];
        }

        // =====================================
        // SORTING DESC
        // =====================================
        usort($hasil_awal, function($a, $b){

            return $b['nilai'] <=> $a['nilai'];

        });

        usort($hasil_plus, function($a, $b){

            return $b['nilai'] <=> $a['nilai'];

        });

        usort($hasil_minus, function($a, $b){

            return $b['nilai'] <=> $a['nilai'];

        });

        // =====================================
        // KIRIM DATA
        // =====================================
        $data = [

            'page'         => 'Sensitivity',

            'hasil_awal'   => $hasil_awal,

            'hasil_plus'   => $hasil_plus,

            'hasil_minus'  => $hasil_minus
        ];

        $this->load->view(
            'Perhitungan/sensitivity',
            $data
        );
    }
}