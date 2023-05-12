<?= doctype() ?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="shortcut icon" type="image/png" href=""/>-->

    <!-- Bootstrap CSS -->
    <?= link_tag(base_url('assets/bootstrap/css/bootstrap.min.css'), 'stylesheet', 'text/css') ?>

    <!--FontAwesome-->
    <?= link_tag(base_url('assets/fontawesome/css/all.css'), 'stylesheet', 'text/css') ?>

    <title>{app_title}</title>

    <style type="text/css">
        .app-content {
            margin-top: 70px;
        }

        .content-responsive {
            width: 200%;
        }

        input:disabled {
            cursor: not-allowed;
        }

        button:disabled {
            cursor: not-allowed;
            pointer-events: all !important;
        }

        input[readonly] {
            cursor: not-allowed;
        }

        .list-group-item {
            cursor: pointer;
        }

        .cursor-pointer {
            cursor: pointer !important;
        }

        .has-error .help-block {
            color: red;
        }

        @media only screen and (min-width: 768px) {
            .dropdown:hover .dropdown-menu {
                display: block;
            }
        }

        @media (min-width: 500px) {
            .content-responsive {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>"><i class="fas fa-fw fa-cash-register"></i> Mitrasinerji Test</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                if (is_user_id()) {
                ?>

                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= base_url() ?>"><i class="fas fa-fw fa-home"></i> Beranda <span class="sr-only">(current)</span></a>
                        </li>
                        <?php
                        if (is_super()) {
                        ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Manajemen
                                </a>
                                <div class="dropdown-menu mt-0" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?= site_url('barang') ?>">Barang</a>
                                    <a class="dropdown-item" href="<?= site_url('customer') ?>">Customer</a>
                                    <a class="dropdown-item" href="<?= site_url('user/manajemen') ?>">User</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= site_url('role/manajemen') ?>">Role</a>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Transaksi
                            </a>
                            <div class="dropdown-menu mt-0" aria-labelledby="navbarDropdown">

                                <?php
                                if (is_nota()) {
                                ?>
                                    <!-- <a class="dropdown-item" href="<!?= site_url('transaksi/penjualan') ?>">Sales / Penjualan</a> -->
                                    <a class="dropdown-item" href="<?= site_url('sales') ?>">Sales</a>
                                <?php
                                }

                                if (is_history()) {
                                ?>
                                    <!-- <a class="dropdown-item" href="<!?= site_url('riwayat_transaksi/riwayat_penjualan') ?>">Riwayat Penjualan</a> -->
                                    <a class="dropdown-item" href="<?= site_url('sales/daftar_transaksi') ?>">Daftar Transaksi</a>
                                <?php
                                }
                                ?>
                            </div>
                        </li>
                        <?php
                        if (is_user_id()) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" id="logout">Log out</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="app-content container">
        <h1 class="d-print-none">{app_heading}</h1>

        {app_content}
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small d-print-none">
        <p class="mb-1">&copy; 2023 H-Soft</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="mailto:g9.hofar.ismail@gmail.com"><i class="far fa-fw fa-envelope"></i> Email</a></li>
            <li class="list-inline-item"><a href="https://api.whatsapp.com/send?phone=6281226490344" target="_wa"><i class="fab fa-fw fa-whatsapp"></i> WhatsApp</a></li>
        </ul>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
        window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');
    </script>
    <script src="<?= base_url('assets/vendor/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/mask-number/jquery.masknumber.js') ?>"></script>

    <script>
        function logout() {
            var konfirm = confirm('Apakah anda yakin akan keluar ?');
            if (konfirm) {
                window.location.href = '<?= site_url('auth/logout') ?>';
            }
        }

        $(document).ready(function() {
            $('.dropdown-toggle').click(function(e) {
                if ($(document).width() > 768) {
                    e.preventDefault();

                    var url = $(this).attr('href');

                    if (url !== '#') {
                        window.location.href = url;
                    }
                }
            });
            $('#logout').click(function() {
                logout();
            });
        });
    </script>
</body>

</html>