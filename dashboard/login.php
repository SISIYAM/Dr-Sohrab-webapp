<?php 
session_start();
include './Admin/includes/dbcon.php';
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <?php include 'includes/head.php'; ?>

</head>

 <script src="https://accounts.google.com/gsi/client" async></script>
    <script>
        // Credential response handler function
        function handleCredentialResponse(response) {

            // Post JWT token to server-side
            fetch("../includes/auth_init.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ request_type: 'user_auth', credential: response.credential }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 1) {
                        let responsePayload = data.pdata;

                        // Display the user account data
                        // let profileHTML = '<h3>Welcome ' + responsePayload.given_name + '! <a href="javascript:void(0);" onclick="signOut(' + responsePayload.sub + ');">Sign out</a></h3>';
                        // profileHTML += '<img src="' + responsePayload.picture + '"/><p><b>Auth ID: </b>' + responsePayload.sub + '</p><p><b>Name: </b>' + responsePayload.name + '</p><p><b>Email: </b>' + responsePayload.email + '</p>';
                        // document.getElementsByClassName("pro-data")[0].innerHTML = profileHTML;

                        // document.querySelector("#btnWrap").classList.add("hidden");
                        // document.querySelector(".pro-data").classList.remove("hidden");
                        window.location.href = "../edit-profile";
                        
                        // location.reload();


                    } else {
                        alert(data.msg);
                    }

                })
                .catch(console.error);

                
        }

        // Sign out the user
        function signOut(authID) {
            document.getElementsByClassName("pro-data")[0].innerHTML = '';
            document.querySelector("#btnWrap").classList.remove("hidden");
            document.querySelector(".pro-data").classList.add("hidden");
        }

    </script>

<body class="h-100">
  <div class="authincation h-100">
    <div class="container-fluid h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
          <div class="authincation-content">
            <div class="row no-gutters">
              <div class="col-xl-12">
                <?php 
                if(isset($_GET['login'])){
                  ?>
                <div class="auth-form col-md-12">
                  <h4 class="text-center mb-4">Sign in your account</h4>
                  <!--<form action="" method="post">-->
                  <!--  <div class="form-group">-->
                  <!--    <label><strong>Username</strong></label>-->
                  <!--    <input type="text" class="form-control" placeholder="Enter username" name="username">-->
                  <!--  </div>-->
                  <!--  <div class="form-group">-->
                  <!--    <label><strong>Password</strong></label>-->
                  <!--    <input type="password" class="form-control" placeholder="Password" name="password">-->
                  <!--  </div>-->
                  <!--  <div class="form-row d-flex justify-content-between mt-4 mb-2">-->

                  <!--    <div class="form-group">-->
                  <!--      <a href="forgot-password">Forgot Password?</a>-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--  <div class="text-center">-->
                  <!--    <button type="submit" name="LoginBtn" class="btn btn-primary btn-block">Sign me in</button>-->
                  <!--  </div>-->
                  <!--</form>-->
                  <!--<div class="new-account mt-3">-->
                  <!--  <p>Don't have an account? <a class="text-primary" href="login.php?register">Sign up</a></p>-->
                  <!--</div>-->
                  
                   <!-- Sign In With Google button with HTML data attributes API -->
                        <div id="g_id_onload" data-client_id="328918012143-776b4m4i6tr212i0nrnvtcp0pcsugb36.apps.googleusercontent.com"
                            data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse" data-auto_prompt="true">
                        </div>

                <div class="g_id_signin" data-type="standard" data-shape="circle" data-theme="outline" data-text="signin_with"
                            data-size="large" data-logo_alignment="left">
                        </div>
                  
                  
                  
                </div>
                <?php
                }elseif(isset($_GET['register'])){
                  ?>
                <div class="auth-form">
                  <h4 class="text-center mb-4">Sign up your account</h4>
                  <form action="" method="post">
                    <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" class="form-control" id="exampleInputFirstName" name="full_name"
                        placeholder="Enter Full Name" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="exampleInputLastName"
                        placeholder="Enter Unique Username" required>
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="exampleInputEmail"
                        aria-describedby="emailHelp" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" id="exampleInputPassword"
                        placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password"
                        id="exampleInputPasswordConfirm" placeholder="Confirm Password" required>
                    </div>
                    <div class="text-center mt-4">
                      <button type="submit" name="registerBtn" class="btn btn-primary btn-block">Sign me up</button>
                    </div>
                  </form>
                  <div class="new-account mt-3">
                    <p>Already have an account? <a class="text-primary" href="login.php?login">Sign in</a></p>
                  </div>
                </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php include './includes/code.php'; ?>

</body>

</html>