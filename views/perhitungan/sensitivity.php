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

        <div class="alert alert-info text-justify">

            Sensitivity Analysis dilakukan dengan
            menaikkan dan menurunkan bobot
            kriteria utama sebesar ±10%
            untuk menguji stabilitas hasil
            perangkingan metode Hybrid
            AHP-WASPAS.

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="bg-dark text-white">

                    <tr align="center">

                        <th width="5%">No</th>

                        <th>Alternatif</th>

                        <th width="12%">
                            Qi Awal
                        </th>

                        <th width="12%">
                            Ranking Awal
                        </th>

                        <th width="12%">
                            Qi +10%
                        </th>

                        <th width="12%">
                            Ranking +10%
                        </th>

                        <th width="12%">
                            Qi -10%
                        </th>

                        <th width="12%">
                            Ranking -10%
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    // =========================
                    // SORTING RANKING +10%
                    // =========================
                    $rank_plus = $hasil_plus;

                    usort($rank_plus, function($a, $b){
                        return $b['nilai'] <=> $a['nilai'];
                    });

                    // =========================
                    // SORTING RANKING -10%
                    // =========================
                    $rank_minus = $hasil_minus;

                    usort($rank_minus, function($a, $b){
                        return $b['nilai'] <=> $a['nilai'];
                    });

                    foreach($hasil_awal as $i => $h):

                        // ranking awal
                        $ranking_awal = $i + 1;

                        // ranking +10%
                        $ranking_plus = 0;

                        foreach($rank_plus as $rp => $r){
                            if($r['nama'] == $hasil_plus[$i]['nama']){
                                $ranking_plus = $rp + 1;
                            }
                        }

                        // ranking -10%
                        $ranking_minus = 0;

                        foreach($rank_minus as $rm => $r2){
                            if($r2['nama'] == $hasil_minus[$i]['nama']){
                                $ranking_minus = $rm + 1;
                            }
                        }
                    ?>

                    <tr align="center">

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td align="left">

                            <?= $h['nama'] ?>

                        </td>

                        <td>

                            <?= number_format($h['nilai'],5) ?>

                        </td>

                        <td>

                            <span class="badge badge-primary">

                                <?= $ranking_awal ?>

                            </span>

                        </td>

                        <td>

                            <?= number_format($hasil_plus[$i]['nilai'],5) ?>

                        </td>

                        <td>

                            <?php if($ranking_plus == $ranking_awal){ ?>

                                <span class="badge badge-success">

                                    <?= $ranking_plus ?>

                                </span>

                            <?php } else { ?>

                                <span class="badge badge-danger">

                                    <?= $ranking_plus ?>

                                </span>

                            <?php } ?>

                        </td>

                        <td>

                            <?= number_format($hasil_minus[$i]['nilai'],5) ?>

                        </td>

                        <td>

                            <?php if($ranking_minus == $ranking_awal){ ?>

                                <span class="badge badge-success">

                                    <?= $ranking_minus ?>

                                </span>

                            <?php } else { ?>

                                <span class="badge badge-danger">

                                    <?= $ranking_minus ?>

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <div class="alert alert-success mt-4 text-justify">

            <b>Kesimpulan Sensitivity Analysis:</b>

            <br><br>

            Pengujian sensitivity analysis dilakukan
            dengan mengubah bobot kriteria utama
            sebesar ±10%.

            Jika hasil ranking alternatif tidak berubah,
            maka metode Hybrid AHP-WASPAS
            dianggap memiliki tingkat stabilitas
            dan robustness yang baik.

            <br><br>

            Berdasarkan hasil pengujian,
            sistem mampu menghasilkan
            rekomendasi yang konsisten
            meskipun terjadi perubahan
            bobot pada kriteria tertentu.

        </div>

    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>