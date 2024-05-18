<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Projects - PjBL Student</title>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url(); ?>assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">PjBL Student</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('sg/profile/').$_SESSION['un'] ?>">Settings</a>
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
                        <h1 class="mt-4">
                          <i class="fas fa-project-diagram"></i> Projects
                          <?php if ($proj->completed==1): ?>
                            <i class="text-success float-right mr-3"><span class="fas fa-check"></span> Completed</i>
                          <?php endif; ?>
                        </h1>
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item">Projects</li>
                            <li class="breadcrumb-item active">Phase</li>
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
                          if ($this->session->userdata('pw')!=NULL) {
                            ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                              <strong>Information!</strong> Complete the existing phase first to proceed to the next phase.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }else{
                            ?>
                              <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Information!</strong> For see phases, you must complete your pretest file.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>
                            <?php
                          }
                        ?>
                        <div class="card bg-light mb-3">
                          <div class="card-header"><i class="fas fa-project-diagram"></i> <?php echo $proj->name ?></div>
                          <div class="card-body py-3">
                            <?php echo $proj->desc ?>
                            <div class="row justify-content-between">
                              <div class="alert alert-secondary my-2 py-2" role="alert">
                                <i class="fas fa-file"></i> Pretest file: <a href="<?php echo base_url('uploads/t/pretest/').$proj->pretest ?>" target="_blank"><?php echo $proj->pretest ?></a>
                              </div>
                              <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalUpload"><i class="fas fa-paper-plane"></i> Answer</button>
                              <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUploadTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <form action="<?php echo base_url("sg/upload/$proj->name") ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalUploadTitle"><i class="fas fa-paper-plane"></i> Send answer of pretest</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label class="mb-1" for="uf">Upload File</label><span class="text-secondary float-right">*.pdf|zip|docx|jpg, Max: 2MB</span><br>
                                        <input type="hidden" name="dl" value="<?php echo $proj->deadline ?>">
                                        <?php
                                          if($_SESSION['pw']){
                                            echo anchor(base_url('uploads/sg/pretest/').$_SESSION['pw'],$_SESSION['pw'],"target='_blank'");
                                          }
                                        ?>
                                        <input class="form-control py-1" id="uf" type="file" name="uf" required>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
                                    </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer">
                              <i class="fas fa-stopwatch"></i> Deadline: <?php echo $proj->deadline ?>
                          </div>
                        </div>
                        <?php
                          if ($_SESSION['pw']) {
                            ?>
                            <div class="accordion" id="pj">
                              <?php foreach ($morePhase as $phase): ?>
                                <div class="card">
                                  <div class="card-header" id="h<?php echo $phase->id; ?>">
                                    <h5 class="mb-0">
                                      <i class="fas fa-tasks"></i>
                                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#c<?php echo $phase->id; ?>" aria-expanded="true" aria-controls="c<?php echo $phase->id; ?>" <?php if($phase->prev_phase!=NULL AND $phase->prev_phase['passed']==0){echo "disabled";} ?>><?php echo $phase->name; ?></button>
                                      <?php if ($phase->passed==1): ?>
                                        <small class="text-success float-right py-2">Lulus | <?php if($phase->point==NULL){echo 0;}else{echo $phase->point;}?>/100</small>
                                      <?php else:?>
                                        <small class="text-danger float-right py-2">Belum Lulus | <?php if($phase->point==NULL){echo 0;}else{echo $phase->point;}?>/100</small>
                                      <?php endif; ?>
                                    </h5>
                                  </div>
                                  <div id="c<?php echo $phase->id; ?>" class="collapse" aria-labelledby="h<?php echo $phase->id; ?>" data-parent="#pj">
                                    <div class="card-body py-2">
                                      <?php echo $phase->desc; ?> <br>
                                      <div class="row justify-content-between">
                                        <div class="alert alert-secondary my-2 py-2" role="alert">
                                          <i class="fas fa-stopwatch"></i> <?php echo "Deadline: ".$phase->deadline; ?>
                                        </div>
                                        <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalPhase<?php echo $phase->id ?>"><i class="fas fa-info-circle"></i> Detail</button>
                                        <div class="modal fade" id="modalPhase<?php echo $phase->id ?>" tabindex="-1" role="dialog" aria-labelledby="modalPhase<?php echo $phase->id ?>Title" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content"><form action="<?php echo base_url("sg/upload/$proj->name/$phase->id/$phase->name") ?>" method="post" enctype="multipart/form-data">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="modalPhase<?php echo $phase->id ?>Title"><i class="fas fa-tasks"></i> <?php echo $phase->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              </div>
                                              <div class="modal-body">
                                                <input type="hidden" name="dl" value="<?php echo $phase->deadline ?>">
                                                <?php echo $phase->desc ?><br>
                                                <div class="row px-2">
                                                  <div class="alert alert-secondary my-2 py-2" role="alert">
                                                    <i class="fas fa-file"></i> <a href="<?php echo base_url('uploads/t/phase/').$phase->file ?>" target="_blank"><?php echo $phase->file ?></a>
                                                  </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                  <label class="mb-1" for="uf">Upload Task</label><span class="text-secondary float-right">*.pdf|zip|docx|jpg, Max: 2MB</span><br>
                                                  <?php
                                                    if($phase->fileA){
                                                      echo anchor(base_url('uploads/sg/phase/').$phase->fileA,$phase->fileA,"target='_blank'");
                                                    }
                                                  ?>
                                                  <input class="form-control py-1" id="ut" type="file" name="uf" required>
                                                  <input type="hidden" name="idA" value="<?php echo $phase->idA ?>">
                                                  <input type="hidden" name="oldFile" value="<?php echo $phase->fileA ?>">
                                                </div>
                                                <?php if ($phase->comment): ?>
                                                  <hr>
                                                  <div class="form-group">
                                                    <label class="mb-1" for="c"> Comment</label><br>
                                                    <textarea id="c" class="form-control" rows="5" cols="80"><?php echo $phase->comment ?></textarea>
                                                  </div>
                                                <?php endif; ?>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-file-upload"></i> Upload</button>
                                              </div>
                                            </form></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach; ?>
                            </div>
                            <?php
                          }
                        ?>
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
