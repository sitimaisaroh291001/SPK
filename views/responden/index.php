<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian Responden</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body{
            background:#f1f3f4;
            font-family: Arial, Helvetica, sans-serif;
        }

        .form-container{
            max-width:900px;
            margin:30px auto;
        }

        .card-form{
            background:white;
            border-radius:12px;
            padding:30px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }

        .header-form{
            border-top:10px solid #673ab7;
        }

        .title{
            font-size:30px;
            font-weight:bold;
        }

        .sub-title{
            color:#666;
            margin-top:10px;
        }

        .question-title{
            font-weight:bold;
            margin-bottom:15px;
            font-size:18px;
        }

        .radio-group label{
            margin-right:20px;
        }

        .required{
            color:red;
        }

        .btn-submit{
            background:#673ab7;
            color:white;
            padding:10px 30px;
            border:none;
            border-radius:6px;
        }

        .btn-submit:hover{
            background:#5a2ea6;
        }
    </style>
</head>
<body>

<div class="container form-container">

    <!-- HEADER -->
    <div class="card-form header-form">
        <div class="title">
            Kuesioner Penilaian Pondok Pesantren
        </div>

        <div class="sub-title">
            Silakan isi penilaian sesuai pengalaman dan pengetahuan Anda terhadap pondok pesantren yang dipilih.
        </div>
    </div>

    <!-- FORM -->
    <form method="POST" action="simpan_penilaian.php">

        <!-- DATA RESPONDEN -->
        <div class="card-form">

            <div class="form-group">
                <label>
                    Nama Responden <span class="required">*</span>
                </label>

                <input type="text"
                       name="nama_responden"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>
                    Pilih Pondok Pesantren yang Akan Dinilai
                    <span class="required">*</span>
                </label>

                <select name="id_alternatif"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Pondok --</option>

                    <?php
                    // koneksi database
                    $conn = mysqli_connect("localhost","root","","spk_ahp_waspas_ci_3");

                    $alternatif = mysqli_query($conn,"SELECT * FROM alternatif");

                    while($a = mysqli_fetch_assoc($alternatif)){
                    ?>

                        <option value="<?= $a['id_alternatif']; ?>">
                            <?= $a['nama_alternatif']; ?>
                        </option>

                    <?php } ?>

                </select>
            </div>

        </div>

        <!-- KRITERIA & SUBKRITERIA -->
        <?php

        $kriteria = mysqli_query($conn,"
            SELECT *
            FROM kriteria
            ORDER BY id_kriteria ASC
        ");

        while($k = mysqli_fetch_assoc($kriteria)){

        ?>

            <div class="card-form">

                <div class="question-title">
                    <?= $k['kode_kriteria']; ?> -
                    <?= $k['nama_kriteria']; ?>
                </div>

                <?php

                $id_kriteria = $k['id_kriteria'];

                $sub = mysqli_query($conn,"
                    SELECT *
                    FROM sub_kriteria
                    WHERE id_kriteria='$id_kriteria'
                ");

                while($s = mysqli_fetch_assoc($sub)){

                ?>

                    <div class="mb-4">

                        <label>
                            <?= $s['nama_sub_kriteria']; ?>
                            <span class="required">*</span>
                        </label>

                        <div class="radio-group mt-2">

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $id_kriteria; ?>][<?= $s['id_sub_kriteria']; ?>]"
                                       value="1"
                                       required>
                                1
                            </label>

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $id_kriteria; ?>][<?= $s['id_sub_kriteria']; ?>]"
                                       value="2">
                                2
                            </label>

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $id_kriteria; ?>][<?= $s['id_sub_kriteria']; ?>]"
                                       value="3">
                                3
                            </label>

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $id_kriteria; ?>][<?= $s['id_sub_kriteria']; ?>]"
                                       value="4">
                                4
                            </label>

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $id_kriteria; ?>][<?= $s['id_sub_kriteria']; ?>]"
                                       value="5">
                                5
                            </label>

                        </div>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

        <!-- BUTTON -->
        <div class="text-center mb-5">
            <button type="submit" class="btn-submit">
                Kirim Penilaian
            </button>
        </div>

    </form>

</div>

</body>
</html>