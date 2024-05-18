<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Beranda - DailyLog</title>
        <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" />
        <script src="<?php echo base_url('assets/js/all.min.js'); ?>"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">DailyLog</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
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
                        <?php echo $_SESSION['nl']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Catatan Harian</h1>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Data Tabel Catatan</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                          <tr>
                                            <th>Tanggal</th>
                                            <th>Log Aktivitas</th>
                                            <th>Output</th>
                                            <th>Aksi</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Tanggal</th>
                                            <th>Log Aktivitas</th>
                                            <th>Output</th>
                                            <th>Aksi</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          <?php foreach ($data as $row ): ?>
                                            <tr>
                                              <td><?php echo $row->tgl; ?></td>
                                              <td><?php echo $row->aktivitas; ?></td>
                                              <td><?php echo $row->output; ?></td>
                                              <td>
                                                <a href="<?php echo base_url('log/update/').$row->id; ?>"><button class="btn btn-warning" title="Ubah"><span class="fas fa-edit"></span></button></a>
                                                <a href="<?php echo base_url('log/delete/').$row->id; ?>"><button class="btn btn-danger" title="Hapus"><span class="fas fa-minus"></span></button></a>
                                              </td>
                                            </tr>
                                          <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
        <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/datatables-demo.js'); ?>"></script>
    </body>
</html>
