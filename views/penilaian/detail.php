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
                    foreach($detail as $d):
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
                            Modus
                        </td>

                        <td><?= $modus['nilai_a'] ?></td>
                        <td><?= $modus['nilai_b'] ?></td>
                        <td><?= $modus['nilai_c'] ?></td>
                        <td><?= $modus['nilai_d'] ?></td>
                        <td><?= $modus['nilai_e'] ?></td>
                        <td><?= $modus['nilai_f'] ?></td>
                        <td><?= $modus['nilai_g'] ?></td>

                        <td>-</td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>