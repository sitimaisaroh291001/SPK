<?php
if($this->session->status !== ('Logged'))
{
    redirect('login');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistem Pendukung Keputusan Metode AHP WASPAS</title>

    <!-- Font -->
    <link href="<?= base_url('assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/')?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="<?= base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/')?>img/favicon.ico">

    <style>

        :root{
            --main:#2ECC71;
            --dark:#27AE60;
        }

        body{
            font-family: Arial;
        }

        .bg-gradient-dark,
        .sidebar-dark{
            background:
            linear-gradient(
                180deg,
                #1ce63e 10%,
                #49b91d 100%
            ) !important;
        }

        .sidebar-dark .nav-link,
        .sidebar-dark .sidebar-brand,
        .sidebar-dark .sidebar-heading{
            color:white !important;
        }

        .sidebar-dark .nav-link span{
            font-weight:bold;
        }

        .sidebar .nav-item.active .nav-link{
            background:rgba(255,255,255,0.15);
            border-radius:5px;
        }

        .topbar{
            background:white !important;
        }

    </style>

</head>

<body id="page-top">

<div id="wrapper">

    <!-- SIDEBAR -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion"
        id="accordionSidebar">

        <!-- BRAND -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
           href="<?= base_url('Login/home'); ?>">

            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-database"></i>
            </div>

            <div class="sidebar-brand-text mx-3">
                SPK AHP WASPAS
            </div>

        </a>

        <hr class="sidebar-divider my-0">

        <!-- DASHBOARD -->
        <li class="nav-item <?php if($page=='Dashboard'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Login/home'); ?>">

                <i class="fas fa-fw fa-home"></i>

                <span>Dashboard</span>

            </a>

        </li>

        <hr class="sidebar-divider">

        <!-- MASTER DATA -->
        <div class="sidebar-heading">
            Master Data
        </div>

        <?php if($this->session->userdata('id_user_level') == '1'): ?>

        <!-- KRITERIA -->
        <li class="nav-item <?php if($page=='Kriteria'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Kriteria'); ?>">

                <i class="fas fa-fw fa-cube"></i>

                <span>Data Kriteria</span>

            </a>

        </li>

        <!-- SUB KRITERIA -->
        <li class="nav-item <?php if($page=='Sub Kriteria'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Sub_Kriteria'); ?>">

                <i class="fas fa-fw fa-cubes"></i>

                <span>Data Sub Kriteria</span>

            </a>

        </li>

        <!-- ALTERNATIF -->
        <li class="nav-item <?php if($page=='Alternatif'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Alternatif'); ?>">

                <i class="fas fa-fw fa-users"></i>

                <span>Data Alternatif</span>

            </a>

        </li>

        <!-- PENILAIAN -->
        <li class="nav-item <?php if($page=='Penilaian'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Penilaian'); ?>">

                <i class="fas fa-fw fa-edit"></i>

                <span>Data Penilaian</span>

            </a>

        </li>

        <!-- PERHITUNGAN -->
        <li class="nav-item <?php if($page=='Perhitungan'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Perhitungan'); ?>">

                <i class="fas fa-fw fa-calculator"></i>

                <span>Data Perhitungan</span>

            </a>

        </li>

        <!-- HASIL -->
        <li class="nav-item <?php if($page=='Hasil'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Perhitungan/hasil'); ?>">

                <i class="fas fa-fw fa-chart-area"></i>

                <span>Data Hasil Akhir</span>

            </a>

        </li>

        <?php endif; ?>

        <!-- USER LEVEL 2 -->
        <?php if($this->session->userdata('id_user_level') == '2'): ?>

        <li class="nav-item <?php if($page=='Hasil'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Perhitungan/hasil'); ?>">

                <i class="fas fa-fw fa-chart-area"></i>

                <span>Data Hasil Akhir</span>

            </a>

        </li>

        <?php endif; ?>

        <hr class="sidebar-divider">

        <!-- MASTER USER -->
        <div class="sidebar-heading">
            Master User
        </div>

        <?php if($this->session->userdata('id_user_level') == '1'): ?>

        <li class="nav-item <?php if($page=='User'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('User'); ?>">

                <i class="fas fa-fw fa-users-cog"></i>

                <span>Data User</span>

            </a>

        </li>

        <?php endif; ?>

        <!-- PROFILE -->
        <li class="nav-item <?php if($page=='Profile'){echo 'active';} ?>">

            <a class="nav-link"
               href="<?= base_url('Profile'); ?>">

                <i class="fas fa-fw fa-user"></i>

                <span>Data Profile</span>

            </a>

        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- TOGGLE -->
        <div class="text-center d-none d-md-inline">

            <button class="rounded-circle border-0"
                    id="sidebarToggle"></button>

        </div>

    </ul>
    <!-- END SIDEBAR -->

    <!-- CONTENT -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- TOPBAR -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- TOGGLE -->
                <button id="sidebarToggleTop"
                        class="btn btn-link d-md-none rounded-circle mr-3">

                    <i class="fa fa-bars"></i>

                </button>

                <ul class="navbar-nav ml-auto">

                    <!-- USER -->
                    <li class="nav-item dropdown no-arrow">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-toggle="dropdown">

                            <span class="mr-2 d-none d-lg-inline text-gray-600 small text-uppercase">

                                <?= $this->session->username; ?>

                            </span>

                            <img src="<?= base_url('assets/')?>img/user.png"
                                 class="img-profile rounded-circle">

                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                            <a class="dropdown-item"
                               href="<?= base_url('Profile'); ?>">

                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

                                Profile

                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item"
                               href="#"
                               data-toggle="modal"
                               data-target="#logoutModal">

                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                                Logout

                            </a>

                        </div>

                    </li>

                </ul>

            </nav>

            <!-- CONTAINER -->
            <div class="container-fluid">