<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Responden</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>

        body{
            background:#f1f3f4;
            font-family:Arial;
        }

        .form-container{
            max-width:900px;
            margin:30px auto;
        }

        .card-form{
            background:white;
            padding:30px;
            border-radius:10px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }

        .header-form{
            border-top:10px solid #673ab7;
        }

        .title{
            font-size:28px;
            font-weight:bold;
        }

        .question-title{
            font-size:18px;
            font-weight:bold;
        }

        .required{
            color:red;
        }

        .radio-group label{
            margin-right:20px;
        }

        .btn-submit{
            background:#673ab7;
            color:white;
            border:none;
            padding:10px 30px;
            border-radius:6px;
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

        <p>
            Silakan isi penilaian sesuai pengalaman Anda.
        </p>

    </div>

    <!-- FORM -->
    <form method="POST"
          action="<?= base_url('responden/simpan'); ?>">

        <!-- RESPONDEN -->
        <div class="card-form">

            <div class="form-group">

                <label>
                    Nama Responden
                    <span class="required">*</span>
                </label>

                <input type="text"
                       name="nama_responden"
                       class="form-control"
                       required>

            </div>

            <div class="form-group">

                <label>
                    Pilih Pondok Pesantren
                    <span class="required">*</span>
                </label>

                <select name="id_alternatif"
                        class="form-control"
                        required>

                    <option value="">
                        -- Pilih Pondok --
                    </option>

                    <?php foreach($alternatif as $a){ ?>

                        <option value="<?= $a->id_alternatif; ?>">
                            <?= $a->nama; ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

        </div>

        <!-- KRITERIA -->
        <?php foreach($kriteria as $k){ ?>

            <div class="card-form">

                <div class="question-title">
                    <?= $k->kode_kriteria; ?> -
                    <?= $k->keterangan; ?>
                </div>

                <!-- PETUNJUK -->
                <div class="mt-3 mb-3">

                    <b>Petunjuk Penilaian:</b>

                    <ul>

                        <?php foreach($sub_kriteria as $s){ ?>

                            <?php if($s->id_kriteria == $k->id_kriteria){ ?>

                                <li>
                                    <?= $s->deskripsi; ?> (Nilai: <?= $s->nilai; ?>)
                                </li>

                            <?php } ?>

                        <?php } ?>

                    </ul>

                </div>

                <!-- NILAI -->
                <div class="radio-group">

                    <?php foreach($sub_kriteria as $s){ ?>

                        <?php if($s->id_kriteria == $k->id_kriteria){ ?>

                            <label>
                                <input type="radio"
                                       name="nilai[<?= $k->id_kriteria; ?>]"
                                       value="<?= $s->id_sub_kriteria; ?>"
                                       required>
                                <?= $s->nilai; ?>
                            </label>

                        <?php } ?>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

        <!-- BUTTON -->
        <div class="text-center mb-5">

            <button type="submit"
                    class="btn-submit">

                Kirim Penilaian

            </button>

        </div>

    </form>

</div>

</body>
</html>
