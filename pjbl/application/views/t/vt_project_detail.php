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
                          <i class="fas fa-project-diagram"></i> Project
                          <a class="btn btn-lg btn-danger float-right" href="<?php echo base_url('t/deleteConfirm/projects/'.$proj->id) ?>" onclick="return confirm('Are you sure? This will be delete all student groups and phases in this project permanently.')" title="Delete this project" role="button"><i class="fas fa-trash"></i></a>
                          <?php if ($proj->completed!=1): ?>
                            <a class="btn btn-lg btn-success float-right mr-1" href="<?php echo base_url('t/updateProjConfirm/'.$proj->id.'/1') ?>" onclick="return confirm('Are you sure? Have all groups completed the tasks in each phase?')" title="Complete this project" role="button"><i class="fas fa-check"></i></a>
                          <?php else: ?>
                            <i class="text-success float-right mr-3"><span class="fas fa-check"></span> Completed</i>
                          <?php endif; ?>
                        </h1>
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('t'); ?>">Projects</a></li>
                            <li class="breadcrumb-item active">Detail</li>
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
                          if (!$moreGroup) {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>Warning!</strong> Student group have not been made, don't forget to make student group.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }if (!$morePhase) {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>Warning!</strong> Phase have not been added, don't forget to add phase.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php
                          }
                        ?>
                        <ul class="nav nav-tabs" id="projTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="g-tab" data-toggle="tab" href="#g" role="tab" aria-controls="g" aria-selected="true"><i class="fas fa-home"></i> General</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="sg-tab" data-toggle="tab" href="#sg" role="tab" aria-controls="sg" aria-selected="false"><i class="fas fa-users"></i> Student Groups</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="p-tab" data-toggle="tab" href="#p" role="tab" aria-controls="p" aria-selected="false"><i class="fas fa-tasks"></i> Phases</a>
                          </li>
                        </ul>
                        <div class="tab-content" id="projTabContent">
                          <div class="tab-pane fade show active" id="g" role="tabpanel" aria-labelledby="g-tab">
                            <div class="modal fade" id="modalEditProject" tabindex="-1" role="dialog" aria-labelledby="modalEditProjectTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php echo base_url('t/updateProjConfirm/').$proj->id ?>" method="post" enctype="multipart/form-data">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalEditProjectTitle"><i class="fas fa-edit"></i> Edit General Project Info</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label class="mb-1" for="pn"><i class="fas fa-project-diagram"></i> Project Name</label>
                                        <input class="form-control py-4" value="<?php echo $proj->name ?>" id="pn" type="text" name="proj_name" placeholder="Your project name..." required/>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="desc"><i class="fas fa-info-circle"></i> Description</label>
                                        <textarea class="form-control" name="desc" id="desc" rows="5" placeholder="Description here..." required><?php echo $proj->desc ?></textarea>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="deadline"><i class="fas fa-stopwatch"></i> Project Deadline</label>
                                        <input class="form-control" value="<?php echo $proj->deadline ?>" name="dl" id="deadline" type="date" required>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="preEdit"><i class="fas fa-file-upload"></i> Pretest File</label><span class="text-secondary float-right">*.pdf|zip|docx, Max: 2MB</span><br>
                                        <a href="<?php echo base_url('uploads/t/pretest/').$proj->pretest ?>" target="_blank"><?php echo $proj->pretest ?></a>
                                        <input class="form-control py-1" id="preEdit" type="file" name="pre">
                                        <input type="hidden" name="oldPre" value="<?php echo $proj->pretest ?>">
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
                            <div class="card mt-2">
                              <div class="card-header"><i class="fas fa-project-diagram"></i> <?php echo $proj->name; ?></div>
                              <div class="card-body">
                                <?php echo $proj->desc; ?>
                                <div class="row justify-content-between">
                                  <div class="alert alert-secondary my-2 py-2" role="alert">
                                    <i class="fas fa-file"></i> Pretest file: <a href="<?php echo base_url('uploads/t/pretest/').$proj->pretest ?>" target="_blank"><?php echo $proj->pretest ?></a>
                                  </div>
                                  <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalEditProject"><i class="fas fa-edit"></i> Edit</button>
                                </div>
                              </div>
                              <div class="card-footer">
                                <i class="fas fa-stopwatch"></i> <?php echo "Deadline: ".$proj->deadline; ?>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="sg" role="tabpanel" aria-labelledby="sg-tab">
                            <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalMakeGroup"><i class="fas fa-user-plus"></i> Make a student group</button><br>
                            <div class="modal fade" id="modalMakeGroup" tabindex="-1" role="dialog" aria-labelledby="modalMakeGroupTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content"><form action="<?php echo base_url("t/makeGroupConfirm/$proj->id"); ?>" method="post">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalMakeGroupTitle"><i class="fas fa-user-plus"></i> Make a new student group</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label class="mb-1" for="un"><i class="fas fa-user"></i> Username</label>
                                      <input class="form-control py-4" id="un" type="text" name="un" placeholder="Your student group username for login..." required/>
                                    </div>
                                    <div class="form-group">
                                      <label class="mb-1" for="pw"><i class="fas fa-user-lock"></i> Password</label>
                                      <input class="form-control py-4" id="pw" type="password" name="pw" placeholder="Your student group password for login..." required/>
                                    </div>
                                    <div class="form-group">
                                      <label class="mb-1" for="gn"><i class="fas fa-users"></i> Group Name</label>
                                      <input class="form-control py-4" id="gn" type="text" name="gn" placeholder="Your student group name..." required/>
                                    </div>
                                    <div class="form-group">
                                      <label class="mb-1" for="mCreate"><i class="fas fa-user-friends"></i> Group Member</label>
                                      <textarea class="form-control" name="m" id="mCreate" rows="5" placeholder="This student group member..." required></textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Create</button>
                                  </div>
                                </form></div>
                              </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Group Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php if (!$moreGroup): ?>
                                        <tr>
                                          <td class="text-secondary text-center">No data available in table</td>
                                        </tr>
                                      <?php else:
                                        foreach ($moreGroup as $group ): ?>
                                          <tr>
                                            <td>
                                              <i class="fas fa-users"></i> <a class="my-2" href="#modalGroupId<?php echo $group->id; ?>" data-toggle="modal"><?php echo $group->fullname; ?></a>
                                              <a class="btn btn-danger btn-sm float-right" href="<?php echo base_url('t/deleteConfirm/student_groups/').$proj->id.'/'.$group->id ?>" onclick="return confirm('Are you sure? This will be delete this student work permanently.')" title="Delete" role="button"><i class="fas fa-trash"></i></a>
                                            </td>
                                            <div class="modal fade" id="modalGroupId<?php echo $group->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalGroupId<?php echo $group->id; ?>Title" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <form action="<?php echo base_url("t/editGroupConfirm/$proj->id/$group->id"); ?>" method="post">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="modalGroupId<?php echo $group->id; ?>Title"><i class="fas fa-users"></i> <?php echo $group->fullname; ?></h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <input type="hidden" name="unOld" value="<?php echo $group->username; ?>" />
                                                      <div class="form-group">
                                                        <label class="mb-1" for="unId<?php echo $group->id ?>"><i class="fas fa-user"></i> Username</label>
                                                        <input class="form-control py-4" id="unId<?php echo $group->id ?>" type="text" name="un" value="<?php echo $group->username; ?>" required/>
                                                      </div>
                                                      <div class="form-group">
                                                        <label class="mb-1" for="pwdId<?php echo $group->id ?>"><i class="fas fa-user-lock"></i> Password</label>
                                                        <input type="hidden" name="oldPwd" value="<?php echo $group->password; ?>">
                                                        <input class="form-control py-4" id="pwdId<?php echo $group->id ?>" type="password" name="pwd" placeholder="Fill this input for reset password..."/>
                                                      </div>
                                                      <div class="form-group">
                                                        <label class="mb-1" for="gnId<?php echo $group->id ?>"><i class="fas fa-user"></i> Group Name</label>
                                                        <input class="form-control py-4" id="gnId<?php echo $group->id ?>" type="text" name="gn" value="<?php echo $group->fullname; ?>" required/>
                                                      </div>
                                                      <div class="form-group">
                                                        <label class="mb-1" for="mId<?php echo $group->id ?>"><i class="fas fa-user-friends"></i> Group Member</label>
                                                        <textarea class="form-control" name="m" id="mId<?php echo $group->id ?>" rows="5" required><?php echo $group->member; ?></textarea>
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
                                          </tr>
                                        <?php endforeach;
                                      endif; ?>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="p" role="tabpanel" aria-labelledby="p-tab">
                            <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalAddPhase"><i class="fas fa-plus-circle"></i> Add phase</button><br>
                            <div class="modal fade" id="modalAddPhase" tabindex="-1" role="dialog" aria-labelledby="modalAddPhaseTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalAddPhaseTitle"><i class="fas fa-plus"></i> Add a new phase</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php echo form_open_multipart("t/addPhaseConfirm/$proj->id") ?>
                                      <input type="hidden" name="projName" value="<?php echo $proj->name; ?>">
                                      <?php if ($morePhase): ?>
                                        <div class="form-group">
                                          <label class="mb-1" for="addAfter"><i class="fas fa-tasks"></i> Add After</label>
                                          <select class="form-control" id="addAfter" name="aa" required>
                                            <option value="NULL">First</option>
                                            <?php foreach ($morePhase as $phase): ?>
                                              <option value="<?php echo $phase->id; ?>" selected><?php echo $phase->name; ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                      <?php endif; ?>
                                      <div class="form-group">
                                        <label class="mb-1" for="pnAdd"><i class="fas fa-tasks"></i> Phase Name</label>
                                        <input class="form-control py-4" id="pnAdd" type="text" name="pn" placeholder="Your project name..." required/>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="descPhase"><i class="fas fa-info-circle"></i> Description</label>
                                        <textarea class="form-control" name="desc" id="descPhase" rows="5" placeholder="Description here..." required></textarea>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="dlPhase"><i class="fas fa-stopwatch"></i> Phase Deadline</label>
                                        <input class="form-control" name="dl" id="dlPhase" type="datetime-local" required>
                                      </div>
                                      <div class="form-group">
                                        <label class="mb-1" for="pretest"><i class="fas fa-file-upload"></i> File</label><span class="text-secondary float-right">*.pdf|zip|docx|pptx, Max: 2MB</span>
                                        <input class="form-control py-1" id="pretest" type="file" name="file" required>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="accordion" id="pj">
                              <?php foreach ($morePhase as $phase): ?>
                                <div class="card">
                                  <div class="card-header" id="h<?php echo $phase->id; ?>">
                                    <h5 class="mb-0">
                                      <i class="fas fa-tasks"></i>
                                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#c<?php echo $phase->id; ?>" aria-expanded="true" aria-controls="c<?php echo $phase->id; ?>"><?php echo $phase->name; ?></button>
                                    </h5>
                                  </div>
                                  <div id="c<?php echo $phase->id; ?>" class="collapse" aria-labelledby="h<?php echo $phase->id; ?>" data-parent="#pj">
                                    <div class="card-body py-3">
                                      <?php echo $phase->desc; ?> <br>
                                      <div class="row justify-content-between">
                                        <div class="alert alert-secondary my-2 py-2" role="alert">
                                          <i class="fas fa-stopwatch"></i> <?php echo "Deadline: ".$phase->deadline; ?>
                                        </div>
                                        <a class="btn btn-primary my-2" href="<?php echo base_url("t/detail/$proj->id/$phase->id") ?>" role="button"><i class="fas fa-info-circle"></i> Detail</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach; ?>
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
