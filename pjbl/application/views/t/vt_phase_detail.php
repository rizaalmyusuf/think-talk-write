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
                        <h1 class="mt-4">
                          <i class="fas fa-tasks"></i> Phase
                          <a class="btn btn-lg btn-danger float-right" href="<?php echo base_url('t/deleteConfirm/phases/').$proj->id.'/'.$phase->id ?>" onclick="return confirm('Are you sure? This will be delete all student work in this phase permanently.')" title="Delete" role="button"><i class="fas fa-trash"></i></a>
                        </h1>
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('t'); ?>">Projects</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url("t/detail/$proj->id"); ?>">Detail</a></li>
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
                        ?>
                        <div class="card">
                          <div class="card-header"><i class="fas fa-tasks"></i> <?php echo $phase->name; ?></div>
                          <div class="card-body py-3">
                            <?php echo $phase->desc; ?>
                            <div class="row justify-content-between">
                              <div class="alert alert-secondary my-2 py-2" role="alert">
                                <i class="fas fa-file"></i> Pretest file: <a href="<?php echo base_url('uploads/t/phase/').$phase->file ?>" target="_blank"><?php echo $phase->file ?></a>
                              </div>
                              <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalEditPhase"><i class="fas fa-edit"></i> Edit</button>
                              <div class="modal fade" id="modalEditPhase" tabindex="-1" role="dialog" aria-labelledby="modalEditPhaseTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <form action="<?php echo base_url("t/updatePhaseConfirm/$proj->id/$proj->name/$phase->id") ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditPhaseTitle"><i class="fas fa-edit"></i> Edit Phase</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="hidden" name="oldPrevPhase" value="<?php echo $phase->prev_phase ?>">
                                        <input type="hidden" name="oldNextPhase" value="<?php echo $phase->next_phase ?>">
                                        <?php if ($morePhase): ?>
                                          <div class="form-group">
                                            <label class="mb-1" for="movePhase"><i class="fas fa-tasks"></i> Move Phase</label>
                                            <select class="form-control" id="movePhase" name="mp" required>
                                              <option value="NULL" selected>First</option>
                                              <?php foreach ($morePhase as $movePhase):
                                                if ($movePhase->id==$phase->id): continue;
                                                else: ?>
                                                <option value="<?php echo $movePhase->id; ?>" <?php if($movePhase->id==$phase->prev_phase){echo "selected";} ?>><?php echo $movePhase->name; ?></option>
                                                <?php endif;
                                              endforeach; ?>
                                            </select>
                                          </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                          <label class="mb-1" for="pn"><i class="fas fa-tasks"></i> Phase Name</label>
                                          <input class="form-control py-4" value="<?php echo $phase->name ?>" id="pn" type="text" name="pn" placeholder="Your project name..." required/>
                                        </div>
                                        <div class="form-group">
                                          <label class="mb-1" for="desc"><i class="fas fa-info-circle"></i> Description</label>
                                          <textarea class="form-control" name="desc" id="desc" rows="5" placeholder="Description here..." required><?php echo $phase->desc ?></textarea>
                                        </div>
                                        <div class="form-group">
                                          <label class="mb-1" for="deadline"><i class="fas fa-stopwatch"></i> Phase Deadline</label>
                                          <input class="form-control" value="<?php echo date('Y-m-d\TH:i',strtotime($phase->deadline)) ?>" name="dl" id="deadline" type="datetime-local" required>
                                        </div>
                                        <div class="form-group">
                                          <label class="mb-1" for="preEdit"><i class="fas fa-file-upload"></i> File</label><span class="text-secondary float-right">*.pdf|zip|docx|pptx, Max: 2MB</span><br>
                                          <a href="<?php echo base_url('uploads/t/phase/').$phase->file ?>" target="_blank"><?php echo $phase->file ?></a>
                                          <input class="form-control py-1" id="preEdit" type="file" name="file">
                                          <input type="hidden" name="oldFile" value="<?php echo $phase->file ?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer">
                            <i class="fas fa-stopwatch"></i> <?php echo "Deadline: ".$phase->deadline; ?>
                          </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Group Name</th>
                                        <th scope="col">Student Group Work</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if (!$moreGroup): ?>
                                    <tr>
                                      <td class="text-secondary text-center" colspan="2">No data available in table</td>
                                    </tr>
                                  <?php else:
                                    foreach ($moreGroup as $group ): ?>
                                      <tr>
                                        <form action="<?php echo base_url('t/confirmGroupWork/').$group->idA ?>" method="post">
                                          <input type="hidden" name="ProjId" value="<?php echo $proj->id ?>">
                                          <input type="hidden" name="PhaseId" value="<?php echo $phase->id; ?>">
                                          <td><?php echo $group->fullname; ?></a></td>
                                          <td>
                                            <a href="<?php echo base_url('uploads/sg/phase/').$group->fileA ?>"><?php echo $group->fileA; ?></a>
                                            <button type="button" class="btn btn-sm btn-primary float-right" data-target="#modalGroupId<?php echo $group->id; ?>" data-toggle="modal"><i class="fas fa-user-edit"></i></button>
                                          </td>
                                        <div class="modal fade" id="modalGroupId<?php echo $group->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalGroupId<?php echo $group->id; ?>Title" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="modalGroupId<?php echo $group->id; ?>Title"><i class="fas fa-users"></i> <?php echo $group->fullname; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              </div>
                                              <div class="modal-body">
                                                <div class="form-group">
                                                  <label class="mb-1" for="m"><i class="fas fa-user-friends"></i> Group Member</label>
                                                  <textarea class="form-control" id="m" rows="5" readonly><?php echo $group->member; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                  <label class="mb-1" for="passId<?php echo $group->id; ?>"><i class="fas fa-clipboard-check"></i> Passed</label>
                                                  <input class="form-control float-right" id="passId<?php echo $group->id; ?>" onchange="able(<?php echo $group->id; ?>)" type="checkbox" name="pass" value="1" <?php if($group->passed==1){echo "checked";}?>>
                                                </div>
                                                <div class="form-group">
                                                  <label class="mb-1" for="ptsId<?php echo $group->id; ?>"><i class="fas fa-sort-numeric-up-alt"></i> Point</label>
                                                  <input class="form-control form-control-sm" id="ptsId<?php echo $group->id; ?>" type="number" min="0" max="100" name="point" value="<?php echo $group->point; ?>" <?php if($group->passed==0){echo "disabled";} ?> required>
                                                </div>
                                                <div class="form-group">
                                                  <label class="mb-1" for="m"><i class="fas fa-comment"></i> Comment</label>
                                                  <textarea class="form-control" name="comment" id="c" rows="5" required><?php echo $group->comment; ?></textarea>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-edit"></i> Edit</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                      </tr>
                                    <?php endforeach;
                                  endif; ?>
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
        <script>
          function able(id){
            var x = document.getElementById("passId"+id).checked;
            if(x==true){document.getElementById("ptsId"+id).removeAttribute("disabled");}
            else{document.getElementById("ptsId"+id).setAttribute("disabled","disabled");}
          }
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/datatables-demo.js"></script>
    </body>
</html>
