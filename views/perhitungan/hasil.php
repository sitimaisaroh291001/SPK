<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir
    </h1>

    <a href="<?= base_url('Laporan'); ?>" class="btn btn-primary">
        <i class="fa fa-print"></i> Cetak Data
    </a>

</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Hasil Akhir Perankingan WASPAS
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th width="10%">Ranking</th>

                        <th>Nama Pondok Pesantren</th>

                        <th width="25%">Nilai Qi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($hasil)) : ?>

                        <?php
                        $ranking = 1;

                        foreach ($hasil as $keys):
                        ?>

                        <tr align="center">

                            <td>
                                <span class="badge badge-success p-2">
                                    <?= $ranking ?>
                                </span>
                            </td>

                            <td align="left">
                                <?= $keys->nama ?>
                            </td>

                            <td>

                                <strong>
                                    <?= number_format($keys->nilai, 4) ?>
                                </strong>

                            </td>

                        </tr>

                        <?php
                        $ranking++;
                        endforeach;
                        ?>

                    <?php else : ?>

                        <tr>

                            <td colspan="3" align="center">

                                <div class="alert alert-warning mb-0">

                                    Data hasil perhitungan belum tersedia.

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>