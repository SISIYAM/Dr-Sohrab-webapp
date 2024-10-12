<?php 

session_start();
include '../Admin/includes/dbcon.php';

// Clear the cookie
if (isset($_COOKIE['student_id'])) {
    setcookie('student_id', '', time() - 3600, "/"); 
}

// Destroy the session
if (session_destroy()) {
    ?>
    <script>
        location.replace("../login.php?login");
    </script>
    <?php 
}
?>
