<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-edit"></i> Data Penilaian
    </h1>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa fa-table"></i> Daftar Monitoring Penilaian Responden
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead class="bg-dark text-white">

                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Nama Pondok Pesantren</th>
                        <th width="20%">Jumlah Responden</th>
                        <th width="15%">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;
                    foreach ($responden as $data):
                    ?>

                    <tr align="center">

                        <td><?= $no++ ?></td>

                        <td align="left">
                            <?= $data->nama ?>
                        </td>

                        <td>
                            <?= $data->jumlah_responden ?>
                        </td>

                        <td>

                            <a href="<?= base_url('penilaian/detail/'.$data->id_alternatif) ?>"
                               class="btn btn-info btn-sm">

                                <i class="fa fa-eye"></i> Detail

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>