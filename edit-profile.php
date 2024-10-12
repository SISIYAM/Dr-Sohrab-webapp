<?php

session_start();
include ("includes/dp_config.php");

if (!isset($_COOKIE['student_id'])) {
//   header("location: login.php");
    ?>
    <script>alert("Please Login");
    window.location.replace("/");
    
    </script>
    <?php 
}


if (isset($_POST['submitDetails'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phn = $_POST['phone'];
  $inst = $_POST['inst'];
  $user = $_POST['userid'];
  $batch = $_POST['batch'];

 $insert = mysqli_query($db, "UPDATE `students` SET `full_name`='$name', `email`='$email', `mobile`='$phn', `college`='$inst', `hsc`='$batch' WHERE `student_id`='$user'");

  if ($insert) {
    echo "<script>alert('User Details Added Successfully!');window.location='profile.php'</script>";
    // include("includes/popup.php");
  } else {
    echo "<script>alert('User Details Faild!'); </script>";
  }
}






?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>Edit Profile - ASG Compressed Note</title>
  <meta name="title" content="ASG Compressed Note">
  <meta name="description"
    content="Read More And Make Success The Result Of Perfection. - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad harum quibusdam, assumenda quia explicabo.">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- 
    - preload image
  -->
  <link rel="preload" as="image" href="./assets/images/hero-banner.png">



</head>

<body>



  <!-- Header  -->
  <?php include ("includes/header.php"); ?>



  <main>
    <article>


      <section>

        <style>
          .edit-form {
            max-width: 500px;
            margin: 150px auto;
            font-family: Arial, sans-serif;
            padding: 15px 50px;
            border: 1px solid #444;
          }

          input[type="submit"]:hover {
            background-color: var(--go-green);
          }

          button.submit {
            display: block;
            margin-top: 20px;
            padding: 10px 30px;
            background-color: #F5EBE5;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
          }

          select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
          }

          input[type="text"],
          input[type="email"],
          input[type="tel"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
          }

          label {
            display: block;
            margin-top: 20px;
          }

          @media screen and (max-width: 800px) {
            .edit-form {
              max-width: 450px;
            }
          }
        </style>


        <form method="post" action="" class="edit-form">

          <?php
          if (isset($_COOKIE['student_id'])) {
            $user = $_COOKIE['student_id'];
          } else {
            $user = '';
          }

          $select = mysqli_query($db, "SELECT * FROM students WHERE student_id=$user LIMIT 1");
          while ($row = mysqli_fetch_array($select)) {


            ?>

            <input type="hidden" name="userid" value="<?php echo $_COOKIE['student_id']; ?>"><br>

            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?= $row['full_name'] ?>"><br>
            <label for="email">Email:</label><br>
            <input type="tel" id="email" name="email" value="<?= $row['email'] ?>"><br>

            <label for="phone">Phone Number:</label><br>
            <input type="tel" id="phone" name="phone" value="<?= $row['phone'] ?>"><br>

            <label for="inst">Institution:</label><br>
            <input type="text" id="inst" name="inst" value="<?= $row['institute'] ?>"><br>

            <!--<label for="batch">HSC Batch:</label><br>-->
            <!--<select id="batch" name="batch" value="<?= $row['batch'] ?>">-->
            <!--  <option value="24">HSC 24</option>-->
            <!--  <option value="25">HSC 25</option>-->
            <!--  <option value="26">HSC 26</option>-->

              <!-- Add more options as needed -->
            <!--</select><br>-->


          <?php } ?>

          <button class="submit" name="submitDetails">Submit</button>


        </form>
      </section>


















    </article>
  </main>







  <!-- Fooooteeer -->
  <?php include ("includes/footer.php"); ?>
 





</body>

</html>