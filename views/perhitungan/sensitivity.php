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

Sensitivity Analysis dilakukan dengan
menaikkan dan menurunkan bobot
kriteria utama sebesar ±10%
untuk menguji stabilitas hasil
perangkingan Hybrid AHP-WASPAS.

</div>

<div class="table-responsive">

<table class="table table-bordered table-striped">

<thead class="bg-dark text-white">

<tr align="center">

<th>No</th>

<th>Alternatif</th>

<th>Qi Awal</th>

<th>Rank Awal</th>

<th>Qi +10%</th>

<th>Rank +10%</th>

<th>Qi -10%</th>

<th>Rank -10%</th>

</tr>

</thead>

<tbody>

<?php

$no=1;


// buat mapping ranking

$rank_awal=[];

foreach($hasil_awal as $i=>$r){

$rank_awal[
$r['nama']
]=$i+1;

}


$rank_plus=[];

foreach($hasil_plus as $i=>$r){

$rank_plus[
$r['nama']
]=$i+1;

}


$rank_minus=[];

foreach($hasil_minus as $i=>$r){

$rank_minus[
$r['nama']
]=$i+1;

}



// mapping data +10

$data_plus=[];

foreach($hasil_plus as $h){

$data_plus[
$h['nama']
]=$h['nilai'];

}



// mapping data -10

$data_minus=[];

foreach($hasil_minus as $h){

$data_minus[
$h['nama']
]=$h['nilai'];

}



foreach($hasil_awal as $h):

?>

<tr align="center">

<td><?= $no++ ?></td>

<td align="left">

<?= $h['nama'] ?>

</td>

<td>

<?= number_format($h['nilai'],5) ?>

</td>

<td>

<span class="badge badge-primary">

<?= $rank_awal[$h['nama']] ?>

</span>

</td>

<td>

<?= number_format(
$data_plus[$h['nama']],
5
) ?>

</td>

<td>

<?php
if(
$rank_plus[$h['nama']]
==
$rank_awal[$h['nama']]
){
?>

<span class="badge badge-success">

<?= $rank_plus[$h['nama']] ?>

</span>

<?php } else { ?>

<span class="badge badge-danger">

<?= $rank_plus[$h['nama']] ?>

</span>

<?php } ?>

</td>

<td>

<?= number_format(
$data_minus[$h['nama']],
5
) ?>

</td>

<td>

<?php
if(
$rank_minus[$h['nama']]
==
$rank_awal[$h['nama']]
){
?>

<span class="badge badge-success">

<?= $rank_minus[$h['nama']] ?>

</span>

<?php } else { ?>

<span class="badge badge-danger">

<?= $rank_minus[$h['nama']] ?>

</span>

<?php } ?>

</td>

</tr>

<?php endforeach;?>

</tbody>

</table>

</div>


<div class="alert alert-success mt-4">

<b>Kesimpulan Sensitivity Analysis:</b>

<br><br>

Jika ranking tidak berubah
maka sistem memiliki
stabilitas yang baik.

</div>

</div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>