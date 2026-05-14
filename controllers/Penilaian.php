<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('Penilaian_model');

        if ($this->session->userdata('id_user_level') != "1") {

            ?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location='<?php echo base_url("Login/home"); ?>'
            </script>
            <?php

        }
    }

    public function index()
    {
        $data = [
            'page' => "Penilaian",
            'responden' => $this->Penilaian_model->get_responden(),
        ];

        $this->load->view('penilaian/index', $data);
    }

    public function detail($id)
    {
        $data = [
            'page' => 'Detail Penilaian',

            'detail' => $this->db
                ->where('asal_alternatif', $id)
                ->get('responden')
                ->result()
        ];

        $this->load->view('penilaian/detail', $data);
    }
}