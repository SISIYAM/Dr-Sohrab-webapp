<?php 
include './Admin/includes/dbcon.php';
include './includes/login_required.php';
function getYouTubeVideoId($url) {
  
  $urlParts = parse_url($url);
  
  // Check if the host is a valid YouTube domain
  if (isset($urlParts['host'])) {
      // Handle youtu.be links
      if ($urlParts['host'] === 'youtu.be') {
       
          return ltrim($urlParts['path'], '/');
      }
      
      // Handle www.youtube.com or youtube.com links
      if ($urlParts['host'] === 'www.youtube.com' || $urlParts['host'] === 'youtube.com') {
          // Extract the query string
          parse_str($urlParts['query'], $query);
          
      
          if (isset($query['v'])) {
              return $query['v'];
          }
      }

      // Handle youtube.com/embed links
      if (strpos($urlParts['path'], '/embed/') === 0) {
          // Extract the video ID from the /embed/ path
          return trim(str_replace('/embed/', '', $urlParts['path']));
      }

      // Handle youtube.com/v/ links
      if (strpos($urlParts['path'], '/v/') === 0) {
          
          return trim(str_replace('/v/', '', $urlParts['path']));
      }
  }


  return null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
include 'includes/head.php';
?>
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
        
        .lecture-list {
    max-height: 485px;
    overflow-y: auto;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
    background-color: #fff;
    padding: 15px;
    margin-top: 20px;
}


.lecture-list .lecture-item {
    display: flex;
    align-items: center;
    background-color: #888; 
    color: white;
    border-radius: 5px;
    margin-bottom: 10px;
    padding: 10px;
    transition: background-color 0.3s ease;
}


.lecture-list .lecture-item:hover {
    background-color: #111;
}


.lecture-list .lecture-item a {
    display: flex;
    flex-direction: column;
    color: white;
    text-decoration: none; 
    flex: 1; 
    margin: 5px;
    padding: 10px 15px; 
    border: none; 
    border-radius: 5px; 
    background-color: #888; 
    transition: background-color 0.3s ease, transform 0.2s;
}

/* Styling for the active link */
.lecture-list .lecture-item a.active {
    font-weight: bold; 
    background-color: #ffcc00; 
    color: #111; 
    text-decoration: none; 
}

/* Hover effect for anchor buttons */
.lecture-list .lecture-item a:hover {
    background-color: #444; 
    transform: translateY(-2px);
}

/* Additional styling for the text within anchor tags */
.lecture-list .lecture-item p {
    margin: 0; 
    flex: 1; 
    padding-left: 10px;
}
    </style>
 
 <style>
      .content {
            display: flex;
            flex-direction: column;
            width: 100%;
          }
          #video-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: auto;
            aspect-ratio: 16 / 9;
          }
          #ytplayer {
            width: 100%;
            height: 100%;
            pointer-events: none;
          }
          #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
          }
          #pause-button {
            border:none;
            background-color:transparent;
            transform:scale(2.5);
            display:none;
            margin-top:-1px;
            color:#0075FF;
            cursor: pointer;
          }
          #play-button{
            border:none;
            transform:scale(2.5);
            background-color:transparent; 
            margin-top:-1px;
            color:#0075FF;
            cursor: pointer;
          }
          #play-loop{
            border:none;
            background-color:transparent;
            transform:scale(1.5);
            color:#0075FF;
            cursor: pointer;
          }
          #stop-loop {
            border:none;
            background-color:transparent;
            transform:scale(1.5);
            display: none;
            color:#0075FF;
            cursor: pointer;
          }
          #muteBtn{
            border:none;
            background-color:transparent;
            transform:scale(2);
            color:red;
            cursor: pointer;
          }
    
          #unmuteBtn {
            border:none;
            background-color:transparent;
            transform:scale(2);
            display: none;
            color:red;
            cursor: pointer;
          }
          #fullscreen-button {
            border:none;
            background-color:transparent;
            transform:scale(1.6);
            cursor: pointer;
          }
          #rewind-button{
            border:none;
            cursor: pointer;
          }
          #forward-button{
            border:none;
            cursor: pointer;
          }
          .time-controls{
            display:flex; align-items:center; justify-content:center;
            margin-bottom:40px;
          }
          .slider-container {
            width: 100%;
            max-width:100%;
          }
          .control-buttons{
            display:flex;
            
          }
          .control-buttons button,
          .time-controls button,
          .slider-container input {
            margin: 0 5px;
          }
          .time-display-count {
            margin-left: 20px;
            text-align: center;
            color:#000000;
          }
          .slider-container {
            margin-top: 2px;
          }
          .slider-container input[type="range"] {
            width: 100%;
            cursor: pointer;
          }
          .time-controls{
            margin-top:-30px;
          }
          #volume-slider {
            width: 100%;
            max-width: 70px;
            cursor: pointer;
          }
          .voulume-section {
            display: flex;
            flex-direction: row;
          }
          .right-control{
            display: flex;
            flex-direction: row;
            gap:10px;
          }
    
          .bottom-content{
            display:flex;
            justify-content:space-between;
            margin:10px;
            align-items:center;
            
          }
          .control-container{
            margin-top:10px;
          }
          
          .speed-controls{
           display:flex;
           justify-content:center;
           align-items:center;
           color:#000000;
          }
          .form-select{
            color:#000000;
          }
          @media (max-width: 768px) {
            #video-container {
              max-width: 100%;
            }
          }
          @media (max-width: 576px) { 
    
          .control-container{
            display:flex;
            flex-direction:column;
            gap:20px;
          }
          .bottom-content{
            display:flex;
            flex-direction:column;
          }
          .time-controls{
            margin-top:0;
          }
          }
          
    </style>
 
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
          $video_id = getYouTubeVideoId($row['src']);
          ?>
           <div class="container mt-5">
    <div class="row">
    <input type="hidden" name="" id="videoIDYT" value="<?=$video_id?>">

        <!-- Video and description column -->
        <div class="col-md-8">
            <div class="video-container">
            <div class="content">
    <div id="video-container">
      <div id="ytplayer"></div>
      <div id="overlay"></div>
    </div>

    <div class="control-container">
      <div class="slider-container">
        <input
          id="time-slider"
          type="range"
          min="0"
          max="100"
          value="0"
          step="1"
        />
      </div>
      <div class="bottom-content">
        <div class="control-buttons">
          <button id="play-button"><i class="bi bi-play-fill"></i></button>
          <button id="pause-button"><i class="bi bi-pause-fill"></i></button>
          <button id="play-loop"><i class="fa-solid fa-repeat"></i></button>
          <button id="stop-loop"><i class="fa-solid fa-ban"></i></button>
          <div class="volume-controls">
            <div class="voulume-section">
              <button id="muteBtn">
                <i class="bi bi-volume-down-fill"></i>
              </button>
              <button id="unmuteBtn">
                <i class="bi bi-volume-mute-fill"></i>
              </button>
              <input
                id="volume-slider"
                type="range"
                min="0"
                max="100"
                value="100"
                step="1"
              />
            </div>
          </div>
          <div class="time-display-count">
            <span id="current-time">00:00</span> /
            <span id="duration">00:00</span>
          </div>
        </div>
        <div class="right-control">
          <div class="speed-controls">
            <span>Playback Speed: </span>
            <select id="speed-select" class="form-select form-select-sm">
              <option value="0.25">0.25x</option>
              <option value="0.5">0.5x</option>
              <option value="1" selected>1x (Normal)</option>
              <option value="1.5">1.5x</option>
              <option value="2">2x</option>
            </select>
          </div>
          <button id="fullscreen-button">
            <i class="fa-solid fa-expand"></i>
          </button>
        </div>
      </div>
      <div class="time-controls">
        <button id="rewind-button" class="badge bg-primary">-5s</button>
        <button id="forward-button" class="badge bg-primary">+5s</button>
      </div>
    </div>
  </div>
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
        <div class="p-2">
            <?php
            // Get the 'Watch' ID from the URL
            $currentWatchId = isset($_GET['Watch']) ? $_GET['Watch'] : null;

            if (!empty($purchasedCoursesIds)) {
                $quotedIds = array_map(function ($id) {
                    return "'" . mysqli_real_escape_string($GLOBALS['con'], $id) . "'";
                }, $purchasedCoursesIds);
                $idsString = implode(",", $quotedIds);
                $searchRelatedLecture = mysqli_query($con, "SELECT * FROM lectures WHERE course_id IN ($idsString)");

                if (mysqli_num_rows($searchRelatedLecture) > 0) {
                    while ($lectureRowFilter = mysqli_fetch_assoc($searchRelatedLecture)) {
                        // Check if the current watch ID matches the lecture's watch ID
                        $isActive = ($lectureRowFilter['watch_id'] == $currentWatchId);
                        ?>
                        <a href="lectures?Watch=<?=$lectureRowFilter['watch_id']?>" 
                           class="<?= $isActive ? 'active' : '' ?>"> <!-- Add 'active' class if matched -->
                            <p><?= $lectureRowFilter['title'] ?></p>
                        </a>
                        <?php
                    }
                }
            }
            ?>
        </div>
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
          $video_id = getYouTubeVideoId($row['src']);
          ?>
      
       
          <input type="hidden" name="" id="videoIDYT" value="<?=$video_id?>">

   <div class="container mt-5">
    <div class="row">
        <!-- Video and description column -->
        <div class="col-md-8">
            <div class="video-container">
            <div class="content">
    <div id="video-container">
      <div id="ytplayer"></div>
      <div id="overlay"></div>
    </div>

    <div class="control-container">
      <div class="slider-container">
        <input
          id="time-slider"
          type="range"
          min="0"
          max="100"
          value="0"
          step="1"
        />
      </div>
      <div class="bottom-content">
        <div class="control-buttons">
          <button id="play-button"><i class="bi bi-play-fill"></i></button>
          <button id="pause-button"><i class="bi bi-pause-fill"></i></button>
          <button id="play-loop"><i class="fa-solid fa-repeat"></i></button>
          <button id="stop-loop"><i class="fa-solid fa-ban"></i></button>
          <div class="volume-controls">
            <div class="voulume-section">
              <button id="muteBtn">
                <i class="bi bi-volume-down-fill"></i>
              </button>
              <button id="unmuteBtn">
                <i class="bi bi-volume-mute-fill"></i>
              </button>
              <input
                id="volume-slider"
                type="range"
                min="0"
                max="100"
                value="100"
                step="1"
              />
            </div>
          </div>
          <div class="time-display-count">
            <span id="current-time">00:00</span> /
            <span id="duration">00:00</span>
          </div>
        </div>
        <div class="right-control">
          <div class="speed-controls">
            <span>Playback Speed: </span>
            <select id="speed-select" class="form-select form-select-sm">
              <option value="0.25">0.25x</option>
              <option value="0.5">0.5x</option>
              <option value="1" selected>1x (Normal)</option>
              <option value="1.5">1.5x</option>
              <option value="2">2x</option>
            </select>
          </div>
          <button id="fullscreen-button">
            <i class="fa-solid fa-expand"></i>
          </button>
        </div>
      </div>
     
    </div>
  </div>
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
        <div class="p-2">
            <?php
            // Get the 'Watch' ID from the URL
            $currentWatchId = isset($_GET['Watch']) ? $_GET['Watch'] : null;

            if (!empty($purchasedCoursesIds)) {
                $quotedIds = array_map(function ($id) {
                    return "'" . mysqli_real_escape_string($GLOBALS['con'], $id) . "'";
                }, $purchasedCoursesIds);
                $idsString = implode(",", $quotedIds);
                $searchRelatedLecture = mysqli_query($con, "SELECT * FROM lectures WHERE course_id IN ($idsString)");

                if (mysqli_num_rows($searchRelatedLecture) > 0) {
                    while ($lectureRowFilter = mysqli_fetch_assoc($searchRelatedLecture)) {
                        // Check if the current watch ID matches the lecture's watch ID
                        $isActive = ($lectureRowFilter['watch_id'] == $currentWatchId);
                        ?>
                        <a href="lectures?Watch=<?=$lectureRowFilter['watch_id']?>" 
                           class="<?= $isActive ? 'active' : '' ?>"> <!-- Add 'active' class if matched -->
                            <p><?= $lectureRowFilter['title'] ?></p>
                        </a>
                        <?php
                    }
                }
            }
            ?>
        </div>
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

  <script>
  // Ensure the YouTube API script is loaded
  if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {
    const script = document.createElement("script");
    script.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(script);
  }

  let player;
  let isLooping = false;
  let currentVolume = 100;

  document.addEventListener("DOMContentLoaded", function () {
    const videoID = document.getElementById("videoIDYT")?.value || "YOUR_DEFAULT_VIDEO_ID";

    console.log("Initializing Player with Video ID:", videoID);

    function createPlayer() {
      player = new YT.Player("ytplayer", {
        height: "100%",
        width: "100%",
        videoId: videoID,
        events: {
          onReady: onPlayerReady,
          onStateChange: onPlayerStateChange,
        },
      });
    }

    // Ensure onYouTubeIframeAPIReady is accessible globally
    window.onYouTubeIframeAPIReady = function () {
      console.log("YouTube Iframe API Ready");
      createPlayer();
    };

    function onPlayerReady() {
      console.log("Player Ready");
      updateDuration();
      setInterval(updateTime, 1000);
      player.setPlaybackQuality("hd1080");
      player.setVolume(100);
      document.getElementById("volume-slider").value = 100;
    }

    function onPlayerStateChange(event) {
      if (event.data === YT.PlayerState.ENDED && isLooping) {
        player.seekTo(0);
        player.playVideo();
      }
    }

    function updateTime() {
      if (player && player.getCurrentTime) {
        const currentTime = player.getCurrentTime();
        const duration = player.getDuration();
        document.getElementById("current-time").textContent = formatTime(currentTime);
        document.getElementById("duration").textContent = formatTime(duration);
        document.getElementById("time-slider").value = (currentTime / duration) * 100;
      }
    }

    function updateDuration() {
      const duration = player.getDuration();
      document.getElementById("duration").textContent = formatTime(duration);
      document.getElementById("time-slider").max = 100;
    }

    function formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = Math.floor(seconds % 60);
      return `${minutes < 10 ? "0" : ""}${minutes}:${remainingSeconds < 10 ? "0" : ""}${remainingSeconds}`;
    }

    document.getElementById("play-button").addEventListener("click", function () {
      player.playVideo();
      this.style.display = "none";
      document.getElementById("pause-button").style.display = "inline";
    });

    document.getElementById("pause-button").addEventListener("click", function () {
      player.pauseVideo();
      this.style.display = "none";
      document.getElementById("play-button").style.display = "inline";
    });

    document.getElementById("rewind-button").addEventListener("click", function () {
      const currentTime = player.getCurrentTime();
      player.seekTo(Math.max(currentTime - 5, 0));
    });

    document.getElementById("forward-button").addEventListener("click", function () {
      const currentTime = player.getCurrentTime();
      const duration = player.getDuration();
      player.seekTo(Math.min(currentTime + 5, duration));
    });

    document.getElementById("time-slider").addEventListener("input", function () {
      const duration = player.getDuration();
      const newTime = (this.value / 100) * duration;
      player.seekTo(newTime);
    });

    document.getElementById("volume-slider").addEventListener("input", function () {
      player.setVolume(this.value);
    });

    document.getElementById("muteBtn").addEventListener("click", function () {
      currentVolume = player.getVolume();
      player.mute();
      this.style.display = "none";
      document.getElementById("unmuteBtn").style.display = "inline";
    });

    document.getElementById("unmuteBtn").addEventListener("click", function () {
      player.unMute();
      player.setVolume(currentVolume);
      this.style.display = "none";
      document.getElementById("muteBtn").style.display = "inline";
    });

    document.getElementById("play-loop").addEventListener("click", function () {
      isLooping = true;
      this.style.display = "none";
      document.getElementById("stop-loop").style.display = "inline";
    });

    document.getElementById("stop-loop").addEventListener("click", function () {
      isLooping = false;
      this.style.display = "none";
      document.getElementById("play-loop").style.display = "inline";
    });

    document.getElementById("fullscreen-button").addEventListener("click", function () {
      if (player && player.getIframe()) {
        if (document.fullscreenElement) {
          document.exitFullscreen();
        } else {
          player.getIframe().requestFullscreen();
        }
      }
    });
  });
</script>

</body>

</html>