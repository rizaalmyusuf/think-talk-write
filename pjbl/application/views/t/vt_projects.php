<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Projects - PjBL Teacher</title>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url(); ?>assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">PjBL Teacher</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('t/profile/').$_SESSION['un'] ?>">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('login/logout'); ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link active" href="<?php echo base_url(); ?>">
                              <div class="sb-nav-link-icon"><i class="fas fa-project-diagram"></i></div>Projects
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['fn']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><i class="fas fa-project-diagram"></i> Projects</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                        <?php
                          if ($this->session->flashdata('err')) {
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Failed!</strong> <?php echo $this->session->flashdata('err')?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }else if ($this->session->flashdata('warn')) {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>Warning!</strong> <?php echo $this->session->flashdata('warn')?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }else if ($this->session->flashdata('succ')) {
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <strong>Success!</strong> <?php echo $this->session->flashdata('succ')?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }
                        ?>
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCreateProject"><i class="fas fa-asterisk"></i> Create a new project</button><br>
                        <div class="table-responsive">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Deadline</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  <?php foreach ($dataProj as $row ): ?>
                                    <tr>
                                      <td><a href="<?php echo base_url("t/detail/$row->id"); ?>" title="Click for details..."><?php echo $row->name; ?></a></td>
                                      <td><?php echo $row->desc; ?></td>
                                      <td>
                                        <?php echo $row->deadline; ?>
                                        <?php if ($row->completed==1): ?>
                                          <i class="text-success float-right"><span class="fas fa-check"></span> Completed</i>
                                        <?php endif; ?>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="modalCreateProject" tabindex="-1" role="dialog" aria-labelledby="modalCreateProjectTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalCreateProjectTitle"><i class="fas fa-asterisk"></i> Create a new project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>
                              <div class="modal-body">
                                <?php echo form_open_multipart('t/createProjConfirm') ?>
                                  <div class="form-group">
                                    <label class="mb-1" for="pn"><i class="fas fa-project-diagram"></i> Project Name</label>
                                    <input class="form-control py-4" id="pn" type="text" name="proj_name" placeholder="Your project name..." required/>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="desc"><i class="fas fa-info-circle"></i> Description</label>
                                    <textarea class="form-control" name="desc" id="desc" rows="5" placeholder="Description here..." required></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="deadline"><i class="fas fa-stopwatch"></i> Project Deadline</label>
                                    <input class="form-control" name="dl" id="deadline" type="date" required>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="pretest"><i class="fas fa-file-upload"></i> Pretest File</label><span class="text-secondary float-right">*.pdf|zip|docx, Max: 2MB</span>
                                    <input class="form-control py-1" id="pretest" type="file" name="pre" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-asterisk"></i> Create</button>
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
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/datatables-demo.js"></script>
    </body>
</html>
