<!--*******************
        Preloader start
    ********************-->
<div id="preloader">
  <div class="sk-three-bounce">
    <div class="sk-child sk-bounce1"></div>
    <div class="sk-child sk-bounce2"></div>
    <div class="sk-child sk-bounce3"></div>
  </div>
</div>
<!--*******************
        Preloader end
    ********************-->


<!--**********************************
        Main wrapper start
    ***********************************-->
<div id="main-wrapper">

  <!--**********************************
            Nav header start
        ***********************************-->
  <div class="nav-header">
    <a href="index" class="brand-logo">
      <img class="logo" src="https://seiinnovations.com/assets/logo/footer-logo.png" alt="" height="50px">
      
    </a>
    

    <div class="nav-control">
      <div class="hamburger">
        <span class="line"></span><span class="line"></span><span class="line"></span>
      </div>
    </div>
  </div>
  <!--**********************************
            Nav header end
        ***********************************-->

  <!--**********************************
            Header start
        ***********************************-->
  <div class="header">
    <div class="header-content">
      <nav class="navbar navbar-expand">
        <div class="collapse navbar-collapse justify-content-between">
          <div class="header-left">
            <div class="search_bar dropdown">
              <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                <i class="mdi mdi-magnify"></i>
              </span>
              <div class="dropdown-menu p-0 m-0">
                <form>
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                </form>
              </div>
            </div>
          </div>

          <ul class="navbar-nav header-right">
            <li class="nav-item dropdown header-profile">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                <i class="mdi mdi-account"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="details?Profile" class="dropdown-item">
                  <i class="icon-user"></i>
                  <span class="ml-2">Profile </span>
                </a>

                <a href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal" class="dropdown-item">
                  <i class="icon-key"></i>
                  <span class="ml-2">Logout </span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

  <!--**********************************
            Sidebar start
        ***********************************-->
  <div class="quixnav">
    <div class="quixnav-scroll">
      <ul class="metismenu" id="menu">

        <li><a href="all-exam?Exams" aria-expanded="false"><i class="icon icon-globe-2"></i><span class="nav-text">All
              Exams</span></a></li>
        <?php
              $count = 0;
              $checkCustomExam = mysqli_query($con,"SELECT * FROM package_record WHERE student_id='$student_id' AND status = '1'");
              if(mysqli_num_rows($checkCustomExam) > 0){
                while($customRow = mysqli_fetch_array($checkCustomExam)){
                  $package_id = $customRow['package_id'];
                  $matchCustomExam = mysqli_query($con,"SELECT * FROM package WHERE package_id='$package_id' AND status = '1'");
                  if(mysqli_num_rows($matchCustomExam) > 0){
                    $fetchCustomExam = mysqli_fetch_array($matchCustomExam);
                    if($fetchCustomExam['custom_exam'] == 1){
                        $count++;
                    }
                  }
                }
              }

              if($count > 0){
                ?>
        <li><a href="create-exam" aria-expanded="false"><i class="icon icon-globe-2"></i><span class="nav-text">Create a
              New Exam</span></a></li>
        <?php
              }

               ?>

        <li><a href="all-exam?Given-Exams" aria-expanded="false"><i class="icon icon-globe-2"></i><span
              class="nav-text">Given Exams</span></a></li>
        <li><a href="lectures?Lectures" aria-expanded="false"><i class="icon icon-globe-2"></i><span
              class="nav-text">Lectures</span></a></li>
        <li><a href="result?Bookmark" aria-expanded="false"><i class="icon icon-globe-2"></i><span
              class="nav-text">Bookmarks</span></a></li>

      </ul>
    </div>


  </div>
  <!--**********************************
            Sidebar end
        ***********************************-->

  <!-- Modal Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-dark">Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
          <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal PassWord Change -->
  <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelPassword"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelPassword">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Old Password:</label>
              <input type="text" class="form-control" id="recipient-name" name="old_password"
                placeholder="Enter Old Password">
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">New Password:</label>
              <input type="text" class="form-control" id="recipient-name" name="new_password"
                placeholder="Enter New Password">
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Confirm Password:</label>
              <input type="text" class="form-control" id="recipient-name" name="confirm_password"
                placeholder="Enter Confirm Password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" name="changePassword" class="btn btn-primary">Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>