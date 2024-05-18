<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Projects - PjBL Administrator</title>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url(); ?>assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">PjBL Administrator</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('admin/profile/').$_SESSION['un'] ?>">Settings</a>
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
                              <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Teacher Users
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
                        <h1 class="mt-4"><i class="fas fa-users"></i> Teacher Users</h1>
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
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCreateTeacher"><i class="fas fa-asterisk"></i> Create a new one</button><br>
                        <div class="modal fade" id="modalCreateTeacher" tabindex="-1" role="dialog" aria-labelledby="modalCreateTeacherTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <form action="<?php echo base_url('admin/createTeacherConfirm'); ?>" method="post">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalCreateTeacherTitle"><i class="fas fa-asterisk"></i> Create a new user</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label class="mb-1" for="unId"><i class="fas fa-user"></i> Username</label>
                                    <input class="form-control py-4" id="unId" type="text" name="un" placeholder="New teacher username..." required/>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="pwdId"><i class="fas fa-user-lock"></i> Password</label>
                                    <input class="form-control py-4" id="pwdId" type="password" name="pwd" placeholder="New teacher password..." required/>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="fnId"><i class="fas fa-user"></i> Fullname</label>
                                    <input class="form-control py-4" id="fnId" type="text" name="fn" placeholder="New teacher fullname..." required/>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Create</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  <?php foreach ($dataUserT as $row ): ?>
                                    <tr>
                                      <td><a href="#modalTeacherId<?php echo $row->id; ?>" data-toggle="modal" title="Click for details..."><?php echo $row->username; ?></a></td>
                                      <td>
                                        <?php echo $row->fullname; ?>
                                        <a class="btn btn-danger btn-sm float-right" href="<?php echo base_url('admin/deleteTeacherConfirm/').$row->id ?>" onclick="return confirm('Are you sure? This will be delete projects, student groups and phases in this account.')" title="Delete" role="button"><i class="fas fa-trash"></i></a>
                                      </td>
                                      <div class="modal fade" id="modalTeacherId<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTeacherId<?php echo $row->id; ?>Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                          <form action="<?php echo base_url("admin/editTeacherConfirm/$row->id"); ?>" method="post">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="modalTeacherId<?php echo $row->id; ?>Title"><i class="fas fa-user-cog"></i> <?php echo $row->fullname; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              </div>
                                              <div class="modal-body">
                                                <input type="hidden" name="unOld" value="<?php echo $row->username; ?>" />
                                                <div class="form-group">
                                                  <label class="mb-1" for="unId<?php echo $row->id ?>"><i class="fas fa-user"></i> Username</label>
                                                  <input class="form-control py-4" id="unId<?php echo $row->id ?>" type="text" name="un" value="<?php echo $row->username; ?>" required/>
                                                </div>
                                                <div class="form-group">
                                                  <label class="mb-1" for="pwdId<?php echo $row->id ?>"><i class="fas fa-user-lock"></i> Password</label>
                                                  <input type="hidden" name="oldPwd" value="<?php echo $row->password; ?>">
                                                  <input class="form-control py-4" id="pwdId<?php echo $row->id ?>" type="password" name="pwd" placeholder="Fill this input for reset password..."/>
                                                </div>
                                                <div class="form-group">
                                                  <label class="mb-1" for="fnId<?php echo $row->id ?>"><i class="fas fa-user"></i> Group Name</label>
                                                  <input class="form-control py-4" id="fnId<?php echo $row->id ?>" type="text" name="fn" value="<?php echo $row->fullname; ?>" required/>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Edit</button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table>
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
