<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ubah - SB Admin</title>
        <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" />
        <script src="<?php echo base_url('assets/js/all.min.js'); ?>"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url() ?>">DailyLog</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                          <div class="sb-sidenav-menu-heading">Core</div>
                          <a class="nav-link" href="<?php echo base_url(); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>Home
                          </a>
                          <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                              <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>Catatan Harian
                              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>
                          <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                              <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url('log/add'); ?>">
                                  <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>Tambah catatan
                                </a>
                              </nav>
                          </div>
                          <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>Logout
                          </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['nl'] ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Catatan Harian</h1>
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ubah Catatan</h3></div>
                                    <div class="card-body">
                                        <?php echo form_open("log/updateProcess/$data->id") ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="tanggal">Tanggal</label><input class="form-control py-4" id="tanggal" name="tgl" type="date" value="<?php echo $data->tgl; ?>" required/></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="small mb-1" for="aktifitas">Log Aktivitas</label><input class="form-control py-4" id="aktifitas" name="log" type="text" value="<?php echo $data->aktivitas; ?>" required/></div>
                                            <div class="form-group"><label class="small mb-1" for="output">Output</label><input class="form-control py-4" id="output" name="o" type="text" value="<?php echo $data->output; ?>" required/></div>
                                            <div class="form-group mt-4 mb-0"><button type="submit" class="btn btn-primary btn-block"><span class="fas fa-edit"></span> Ubah</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Rizal M. Yusuf 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
    </body>
</html>
