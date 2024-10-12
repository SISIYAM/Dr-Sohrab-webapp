<!-- Header START -->

    <script src="https://accounts.google.com/gsi/client" async></script>
    <script>
        // Credential response handler function
        function handleCredentialResponse(response) {

            // Post JWT token to server-side
            fetch("includes/auth_init.php", {
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

<header class="navbar-light navbar-sticky header-static">
  <!-- Logo Nav START -->
  <nav class="navbar navbar-expand-xl">
    <div class="container">
      <!-- Logo START -->
      <a class="navbar-brand" href="<?php if(isset($_SESSION['student_id'])){
        echo "home";
      }else{
        echo "index";
      } ?>">
        <b class="">SEI INNOVATIONS</b>
      </a>
      <!-- Logo END -->



      <!-- Main navbar START -->
      <div class="navbar-collapse w-100 collapse" id="navbarCollapse">

      </div>
      <!-- Main navbar END -->

      <!-- Profile START -->
      <div class="dropdown ms-1 ms-lg-0">
          
          
        <?php 
       if(isset($_COOKIE['student_id'])){
        ?>
        <a href="dashboard/"> <button class="btn btn-primary">GO Exam Site</button></a>
        <?php
       } else{  ?>
        <!--<a href="login.php?login"> <button class="btn btn-primary">Login </button></a>-->
         <!-- Sign In With Google button with HTML data attributes API -->
                        <div id="g_id_onload" data-client_id="328918012143-776b4m4i6tr212i0nrnvtcp0pcsugb36.apps.googleusercontent.com"
                            data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse" data-auto_prompt="true">
                        </div>

                <div class="g_id_signin" data-type="standard" data-shape="circle" data-theme="outline" data-text="signin_with"
                            data-size="large" data-logo_alignment="left">
                        </div>

        <?php 
       }
       ?>
      </div>
      <!-- Profile START -->
    </div>
  </nav>
  <!-- Logo Nav END -->
</header>
<!-- Header END -->