<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Projects - PjBL <?php if($_SESSION['rl']=='t'){echo "Teacher";}elseif($_SESSION['rl']=='sg'){echo "Student";} ?></title>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url(); ?>assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">PjBL <?php if($_SESSION['rl']=='t'){echo "Teacher";}elseif($_SESSION['rl']=='sg'){echo "Student";} ?></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="">Settings</a>
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
                            <a class="nav-link" href="<?php echo base_url(); ?>">
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
                        <h1 class="mt-4"><i class="fas fa-user-cog"></i> Profile</h1>
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
                        <?php if ($_SESSION['rl']=='administrator'): ?>
                          <form action="<?php echo base_url('admin/profile/'.$_SESSION['un'].'/all'); ?>" method="post">
                        <?php elseif($_SESSION['rl']=='t'): ?>
                          <form action="<?php echo base_url('t/profile/'.$_SESSION['un'].'/all'); ?>" method="post">
                        <?php elseif($_SESSION['rl']=='sg'): ?>
                          <form action="<?php echo base_url('sg/profile/'.$_SESSION['un'].'/all'); ?>" method="post">
                        <?php endif; ?>
                          <div class="form-group">
                            <label class="mb-1" for="un"><i class="fas fa-user"></i> Username</label>
                            <input value="<?php echo $account->username; ?>" class="form-control py-4" id="un" type="text" name="un" placeholder="Your student group username for login..." required/>
                          </div>
                          <div class="form-group">
                            <label class="mb-1" for="pw"><i class="fas fa-user-lock"></i> Password</label><br>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalResetPassword">Reset Password</button>
                          </div>
                          <div class="form-group">
                            <label class="mb-1" for="fn"><i class="<?php if($_SESSION['rl']=='sg'){echo 'fas fa-user-friends';}else{echo 'fas fa-user';} ?>"></i> <?php if($_SESSION['rl']=='sg'){echo 'Group Name';}else{echo 'Fullname';} ?></label>
                            <input value="<?php echo $account->fullname; ?>" class="form-control py-4" id="fn" type="text" name="fn" placeholder="Your fullname..." required/>
                          </div>
                          <?php if ($_SESSION['rl']=='sg'): ?>
                            <div class="form-group">
                              <label class="mb-1" for="member"><i class="fas fa-users"></i> Member</label>
                              <textarea class="form-control" id="member" type="text" name="member" placeholder="Your fullname..." required rows="5" cols="80"><?php echo $account->member; ?></textarea>
                            </div>
                          <?php endif; ?>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-user-edit"></i> Edit</button>
                          </div>
                        </form>
                        <div class="modal fade" id="modalResetPassword" tabindex="-1" role="dialog" aria-labelledby="modalResetPasswordTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php if ($_SESSION['rl']=='administrator'): ?>
                                <form action="<?php echo base_url('admin/profile/'.$_SESSION['un'].'/pwd'); ?>" method="post">
                              <?php elseif($_SESSION['rl']=='t'): ?>
                                <form action="<?php echo base_url('t/profile/'.$_SESSION['un'].'/pwd'); ?>" method="post">
                              <?php elseif($_SESSION['rl']=='sg'): ?>
                                <form action="<?php echo base_url('sg/profile/'.$_SESSION['un'].'/pwd'); ?>" method="post">
                              <?php endif; ?>
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalResetPasswordTitle"><i class="fas fa-redo-alt"></i> Reset Password</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label class="mb-1" for="oldPwd"><i class="fas fa-user-lock"></i> Old Password</label>
                                    <input class="form-control py-4" id="oldPwd" type="password" name="oldPwd" placeholder="Your old password for login..." required/>
                                  </div>
                                  <div class="form-group">
                                    <label class="mb-1" for="newPwd"><i class="fas fa-user-lock"></i> New Password</label>
                                    <input class="form-control py-4" id="newPwd" type="password" name="newPwd" placeholder="Your new password for login..." required/>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary"><i class="fas fa-redo-alt"></i> Reset</button>
                                </div>
                              </form>
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
