<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-eye"></i> Detail Penilaian Responden
    </h1>

    <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Data Responden
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th>No</th>
                        <th>Nama Responden</th>

                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>F</th>
                        <th>G</th>

                        <th>Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    $total_a = 0;
                    $total_b = 0;
                    $total_c = 0;
                    $total_d = 0;
                    $total_e = 0;
                    $total_f = 0;
                    $total_g = 0;

                    $jumlah = count($detail);

                    foreach($detail as $d):

                    $total_a += $d->nilai_a;
                    $total_b += $d->nilai_b;
                    $total_c += $d->nilai_c;
                    $total_d += $d->nilai_d;
                    $total_e += $d->nilai_e;
                    $total_f += $d->nilai_f;
                    $total_g += $d->nilai_g;

                    ?>

                    <tr align="center">

                        <td><?= $no++ ?></td>

                        <td align="left">
                            <?= $d->nama_responden ?>
                        </td>

                        <td><?= $d->nilai_a ?></td>
                        <td><?= $d->nilai_b ?></td>
                        <td><?= $d->nilai_c ?></td>
                        <td><?= $d->nilai_d ?></td>
                        <td><?= $d->nilai_e ?></td>
                        <td><?= $d->nilai_f ?></td>
                        <td><?= $d->nilai_g ?></td>

                        <td>
                            <?= date('d-m-Y H:i', strtotime($d->created_at)) ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

                <tfoot class="bg-light font-weight-bold">

                    <tr align="center">

                        <td colspan="2">
                            Rata-rata
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_a / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_b / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_c / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_d / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_e / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_f / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            <?= ($jumlah > 0) ? round($total_g / $jumlah, 2) : 0 ?>
                        </td>

                        <td>
                            -
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>