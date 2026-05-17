<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">

        <i class="fas fa-chart-line"></i>

        Sensitivity Analysis

    </h1>

</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-dark">

            Hasil Sensitivity Analysis ±10%

        </h6>

    </div>

    <div class="card-body">

        <div class="alert alert-info">

            Pengujian dilakukan dengan menaikkan
            dan menurunkan bobot kriteria utama
            sebesar ±10%.

        </div>

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th>No</th>
                        <th>Alternatif</th>

                        <th>Qi Awal</th>

                        <th>Qi +10%</th>

                        <th>Qi -10%</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    foreach($hasil_awal as $i => $h):
                    ?>

                    <tr align="center">

                        <td><?= $no++ ?></td>

                        <td align="left">

                            <?= $h['nama'] ?>

                        </td>

                        <td>

                            <?= round($h['nilai'],5) ?>

                        </td>

                        <td>

                            <?= round($hasil_plus[$i]['nilai'],5) ?>

                        </td>

                        <td>

                            <?= round($hasil_minus[$i]['nilai'],5) ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <div class="alert alert-success mt-4">

            <b>Kesimpulan:</b><br>

            Jika ranking tidak berubah setelah
            perubahan bobot ±10% maka sistem
            dianggap stabil dan robust.

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>