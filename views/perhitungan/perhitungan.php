<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-calculator"></i> Data Perhitungan AHP WASPAS
    </h1>

</div>

<div class="alert alert-danger text-justify">

    Bobot kriteria didapatkan dari perhitungan menggunakan metode <b>AHP</b>.
    Silahkan menuju ke halaman

    <a href="<?= base_url('Kriteria/prioritas') ?>" class="btn btn-info btn-sm">
        Kriteria
    </a>

    untuk melihat proses perhitungan.

</div>

<!-- BOBOT KRITERIA -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Bobot Kriteria (W)
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <?php foreach ($kriteria as $key): ?>

                            <th>
                                <?= $key->kode_kriteria ?>
                                (<?= $key->jenis ?>)
                            </th>

                        <?php endforeach ?>

                    </tr>

                </thead>

                <tbody>

                    <tr align="center">

                        <?php foreach ($kriteria as $key): ?>

                            <td>
                                <?= $key->bobot ?>
                            </td>

                        <?php endforeach ?>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MATRIX KEPUTUSAN -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Matrix Keputusan (X)
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th width="5%">No</th>
                        <th>Alternatif</th>

                        <?php foreach ($kriteria as $key): ?>

                            <th><?= $key->kode_kriteria ?></th>

                        <?php endforeach ?>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    foreach ($alternatif as $keys):
                    ?>

                    <tr align="center">

                        <td><?= $no ?></td>

                        <td align="left">
                            <?= $keys->nama ?>
                        </td>

                        <?php foreach ($kriteria as $key): ?>

                            <?php
                            $data_pencocokan =
                            $this->Perhitungan_model->data_nilai(
                                $keys->id_alternatif,
                                $key->id_kriteria
                            );
                            ?>

                            <td>

                                <strong>
                                    <?= $data_pencocokan['nilai']; ?>
                                </strong>

                            </td>

                        <?php endforeach ?>

                    </tr>

                    <?php
                    $no++;
                    endforeach;
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MATRIX NORMALISASI -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Matrix Normalisasi (R)
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th width="5%">No</th>
                        <th>Alternatif</th>

                        <?php foreach ($kriteria as $key): ?>

                            <th><?= $key->kode_kriteria ?></th>

                        <?php endforeach ?>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    foreach ($alternatif as $keys):
                    ?>

                    <tr align="center">

                        <td><?= $no ?></td>

                        <td align="left">
                            <?= $keys->nama ?>
                        </td>

                        <?php foreach ($kriteria as $key): ?>

                            <?php

                            $data_pencocokan =
                            $this->Perhitungan_model->data_nilai(
                                $keys->id_alternatif,
                                $key->id_kriteria
                            );

                            $min_max =
                            $this->Perhitungan_model->get_max_min(
                                $key->id_kriteria
                            );

                            if ($data_pencocokan['nilai'] == 0) {

                                $normalisasi = 0;

                            } else {

                                if ($min_max['jenis'] == 'Benefit') {

                                    $normalisasi =
                                    $data_pencocokan['nilai'] /
                                    $min_max['max'];

                                } else {

                                    $normalisasi =
                                    $min_max['min'] /
                                    $data_pencocokan['nilai'];
                                }
                            }

                            ?>

                            <td>

                                <?= number_format($normalisasi, 4); ?>

                            </td>

                        <?php endforeach ?>

                    </tr>

                    <?php
                    $no++;
                    endforeach;
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- PERHITUNGAN QI -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Perhitungan Nilai Qi
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th width="5%">No</th>
                        <th>Alternatif</th>
                        <th width="20%">Nilai Qi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $this->Perhitungan_model->hapus_hasil();

                    $no = 1;

                    foreach ($alternatif as $keys):

                    ?>

                    <tr align="center">

                        <td><?= $no ?></td>

                        <td align="left">
                            <?= $keys->nama ?>
                        </td>

                        <?php

                        $ta = 0;
                        $pa = 1;

                        foreach ($kriteria as $key){

                            $data_pencocokan =
                            $this->Perhitungan_model->data_nilai(
                                $keys->id_alternatif,
                                $key->id_kriteria
                            );

                            $min_max =
                            $this->Perhitungan_model->get_max_min(
                                $key->id_kriteria
                            );

                            if ($data_pencocokan['nilai'] == 0) {

                                $p = 0;

                            } else {

                                if ($min_max['jenis'] == 'Benefit') {

                                    $p =
                                    $data_pencocokan['nilai'] /
                                    $min_max['max'];

                                } else {

                                    $p =
                                    $min_max['min'] /
                                    $data_pencocokan['nilai'];
                                }
                            }

                            $bobot = $key->bobot;

                            $ta += $p * $bobot;

                            $pa *= pow($p, $bobot);
                        }

                        $total_hasil =
                        (0.5 * $ta) + (0.5 * $pa);

                        $hasil_akhir = [

                            'id_alternatif' => $keys->id_alternatif,

                            'nilai' => $total_hasil
                        ];

                        $this->Perhitungan_model
                        ->insert_nilai_hasil($hasil_akhir);

                        ?>

                        <td>

                            <strong>
                                <?= number_format($total_hasil, 6); ?>
                            </strong>

                        </td>

                    </tr>

                    <?php
                    $no++;
                    endforeach;
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>