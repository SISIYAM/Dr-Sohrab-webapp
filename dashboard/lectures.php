<?php 
include './Admin/includes/dbcon.php';
include './includes/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
include 'includes/head.php';
?>
</head>

<body>

  <!-- Nav bar -->
  <?php include 'includes/nav.php'; ?>

  <!--**********************************
            Content body start
        ***********************************-->

  <!--**********************************
            Content body start
        ***********************************-->
  <div class="content-body">

    <div class="container-fluid">

      <div class="row">

        <?php 
      $courseCount = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND status='1'");
      if(mysqli_num_rows($courseCount) > 1){
        if(isset($_GET['Lectures'])){
          while($packageRow = mysqli_fetch_array($courseCount)){
            $package_id = $packageRow['package_id'];
            $searchPackage = mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id' AND status='1'");
            if(mysqli_num_rows($searchPackage) > 0){
              $courseRow = mysqli_fetch_array($searchPackage);
              ?>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">

                <div class="text-dark"
                  style="color:#000000; font-size:18px; text-align:justify; height:130px;font-weight:bold;">
                  <?=$courseRow['name']?> </div>
                <a href="lectures?CourseID=<?=$courseRow['package_id']?>"> <button class="btn btn-primary my-3">View
                    Lectures</button></a>
              </div>

            </div>
          </div>
        </div>
        
     
        
        
        
        
        <?php
            }
          }
        }elseif (isset($_GET['CourseID'])) {
          $courseID = $_GET['CourseID'];

          $checkDuration = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND package_id='$courseID'");
          if(mysqli_num_rows($checkDuration) > 0){
            $timeStamp = mysqli_fetch_array($checkDuration)['timestamp'];
          }
          $checkCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$courseID' AND status='1'");
          if(mysqli_num_rows($checkCourse) > 0){
            $durationCourse = mysqli_fetch_array($checkCourse)['duration'];
          }

          if((time() - $timeStamp) < $durationCourse){
            $search = mysqli_query($con, "SELECT * FROM lectures WHERE course_id='$courseID'");
            if(mysqli_num_rows($search) > 0){
            while($row = mysqli_fetch_array($search)){
            ?>
        <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">

                <div class="stat-digit"><?=$row['title']?></div>
                <a href="lectures?Watch=<?=$row['watch_id']?>"> <button class="btn btn-primary my-3">Watch
                    Now</button></a>
              </div>

            </div>
          </div>
        </div>


        <?php
            }
           }else{
            ?>
        <p class="alert alert-warning text-dark">Coming Soon!</p>
        <?php
           }
          }else{
            ?>
        <p class="alert alert-danger text-light">Course Expired!</p>
        <?php
          }

        }elseif (isset($_GET['Watch'])) {
          $watchID= $_GET['Watch'];
          ?>
        <?php 
        $select = mysqli_query($con, "SELECT * FROM lectures WHERE watch_id='$watchID'");
        if(mysqli_num_rows($select) > 0){
          $row = mysqli_fetch_array($select);
          $package_id = $row['course_id'];
          ?>
        <div class="col-xl-9">
          <h1>Lecture 1</h1>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?=$row['src']?>" allowfullscreen></iframe>
          </div>
        </div>

        <div class="col-xl-3">
          <h3><?php
            echo mysqli_fetch_array(mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id'"))['name'];
            ?></h3>
        </div>

        <?php 
         if($row['lectureSheet'] != NULL){
          ?>
        <div class="card-header">
          <a href="./Admin/<?=$row['lectureSheet']?>"> <button class="btn btn-primary btn-lg">Download Lecture
              Sheet</button></a>
        </div>
        <?php
         }
         ?>

        <?php
        }
        ?>
        <?php
         
        }
      }elseif(mysqli_num_rows($courseCount) == 1){
        if(isset($_GET['Lectures'])){
          $searchCourseForStudent = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND status='1'");
        if(mysqli_num_rows($searchCourseForStudent) > 0){
          $fetchPackage = mysqli_fetch_array($searchCourseForStudent);
          $studentPackage_id = $fetchPackage['package_id'];
        }else{
          $studentPackage_id = 0;
        }

        $checkDuration = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND package_id='$studentPackage_id'");
          if(mysqli_num_rows($checkDuration) > 0){
            $timeStamp = mysqli_fetch_array($checkDuration)['timestamp'];
          }
          $checkCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$studentPackage_id' AND status='1'");
          if(mysqli_num_rows($checkCourse) > 0){
            $durationCourse = mysqli_fetch_array($checkCourse)['duration'];
          }

          if((time() - $timeStamp) < $durationCourse){
            $search = mysqli_query($con, "SELECT * FROM lectures WHERE course_id='$studentPackage_id'");
            if(mysqli_num_rows($search) > 0){
            while($row = mysqli_fetch_array($search)){
            ?>
        <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">

                <div class="stat-digit"><?=$row['title']?></div>
                <a href="lectures?Watch=<?=$row['watch_id']?>"> <button class="btn btn-primary my-3">Watch
                    Now</button></a>
              </div>

            </div>
          </div>
        </div>


        <?php
            }
           }else{
            ?>
        <p class="alert alert-warning text-dark">Coming Soon!</p>
        <?php
           }
          }else{
            ?>
        <p class="alert alert-danger text-light">Course Expired!</p>
        <?php
          }

        }elseif (isset($_GET['Watch'])) {
          $watchID= $_GET['Watch'];
          ?>

        <?php 
        $select = mysqli_query($con, "SELECT * FROM lectures WHERE watch_id='$watchID'");
        if(mysqli_num_rows($select) > 0){
          $row = mysqli_fetch_array($select);
          $package_id = $row['course_id'];
          ?>
        <!--<div class="col-xl-9">-->
        <!--  <div class="embed-responsive embed-responsive-16by9">-->
            <!--<iframe class="embed-responsive-item" src="<?=$row['src']?>" allowfullscreen></iframe>-->
        <!--  </div>-->
        <!--</div>-->

        <!--<div class="col-xl-3">-->
        <!--  <h3><?php-->
        <!--    echo mysqli_fetch_array(mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id'"))['name'];-->
        <!--    ?></h3>-->
        <!--</div>-->

        <!--<div class="card-header">-->
        <!--  <h1>Lecture 1</h1>-->
        <!--</div>-->
       
  <style>
        .video-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .lecture-sheet-btn {
            background-color: #6f42c1;
            color: white;
            margin-top: 10px;
        }

        .lecture-sheet-btn:hover {
            background-color: #5a3699;
            color: white;
        }

        .viewer-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .viewer-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .lecture-list{
             height: 485px;
             overflow-y: scroll;
             border-radius: 5px;
             box-shadow: 0 5px 15px rgba(0,0,0,.1);
             background-color: #fff;
             padding:15px;
             margin-top: 20px;
        }
       
     
        .lecture-list img {
            margin-right: 2px;
            border-radius: 5px;
        }

        .lecture-list .lecture-item {
              display: flex;
            align-items:center;
            background-color: #888;
            color: white;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
        }
         .lecture-list .lecture-item:hover {
            background-color: #111;
            
        }
    </style>
   

   <div class="container mt-5">
    <div class="row">
        <!-- Video and description column -->
        <div class="col-md-8">
            <div class="video-container">
                <iframe width="100%" height="400" src="<?=$row['src']?>" frameborder="0"
                        allowfullscreen></iframe>
                <h5 class="mt-3">
                    <?php
           echo mysqli_fetch_array(mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id'"))['name'];
            ?>
        </h5>
                <p><small><i class="far fa-calendar-alt"></i> 2024-08-17 &nbsp;&nbsp; <i class="fas fa-heart"></i> 1 Likes</small></p>
                <button class="btn lecture-sheet-btn">Lecture Sheet</button>
               
            </div>
        </div>

        <!-- Viewer info and lecture list -->
        <div class="col-md-4">
            <!--<div class="viewer-info">-->
            <!--    <img src="https://via.placeholder.com/40" alt="Viewer Avatar">-->
            <!--    <div>-->
            <!--        <strong>Evangel Purification</strong>-->
            <!--        <p class="mb-0">1 People Are Watching</p>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="lecture-list">
                <div class="lecture-item">
                    <img src="https://via.placeholder.com/50x50" alt="Lecture Thumbnail">
                    <p class="mt-2">Lecture 2</p>
                </div>
             
            </div>
        </div>
    </div>
</div>
       
       
        
        <?php
        }
        ?>
        <?php
         
        }
      }else{
        ?>
        <P class="alert alert-danger text-white">No Courses Purchased Yet!</P>
        <?php
      }
      ?>
      </div>

    </div>
  </div>
  <!--**********************************
Content body end
***********************************-->

  <?php include("includes/footer.php"); ?>

</body>

</html>