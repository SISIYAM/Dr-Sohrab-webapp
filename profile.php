<?php
require 'includes/dp_config.php';

// include ("Admin/includes/dbcon.php");
if (!isset($_COOKIE['student_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_COOKIE['student_id'];
$get_user = mysqli_query($db, "SELECT * FROM `students` WHERE `student_id`='$user_id'");
if (mysqli_num_rows($get_user) > 0) {
    $user = mysqli_fetch_assoc($get_user);

} else {
    header('Location: google-auth/logout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $user['full_name']; ?> - Exam Site
    </title>

    <!-- 
        - favicon
    -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">


    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

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


    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        /* body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7ff;
            padding: 10px;
            margin: 0;
        } */
        ._container {
            max-width: 400px;
            background-color: #ffffff;
            padding: 20px;
            margin: 0 auto;
            border: 1px solid #cccccc;
            border-radius: 2px;
        }

        .heading {
            text-align: center;
            color: #4d4d4d;
            text-transform: uppercase;
        }

        ._img {
            overflow: hidden;
            width: 100px;
            height: 100px;
            margin: 0 auto;
            border-radius: 50%;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        ._img>img {
            width: 100px;
            min-height: 100px;
        }

        ._info {
            text-align: center;
        }

        ._info h1 {
            margin: 10px 0;
            text-transform: capitalize;
        }

        ._info p {
            color: #555555;
        }

        ._info a {
            display: inline-block;
            background-color: #E53E3E;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 2px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .profile {
            margin-top: 60px;
            margin-bottom: -60px;
        }
    </style>
</head>

<body>

    <!-- Navabr -->
    <?php include ("includes/header.php"); ?>



    <section class="section profile">
        <div class="_container">
            <h2 class="heading">My Account</h2>
        </div>
        <div class="_container">
            <div class="_img">
                <img src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>">
            </div>
            <div class="_info">
                <h1>
                    <?php echo $user['name']; ?>
                </h1>
                <p>
                    Email:
                    <?php echo $user['email']; ?>
                </p>
                <p>
                    Phone:
                    <?php echo $user['phone']; ?>
                </p>
                <p>
                    Institution:
                    <?php echo $user['institute']; ?>
                </p>
                <p>
                    HSC BATCH:
                    <?php echo $user['batch']; ?>
                </p>
                <a href="logout.php">Logout</a>
                <a class="btn-outline" style="background-color: #F5EBE5; color: #333;" href="edit-profile.php">Edit
                    Profile</a>
            </div>
        </div>
    </section>





    <!-- Payment History -->

    <style>
        /*=============== GOOGLE FONTS ===============*/
        @import url("https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap");

        /*=============== VARIABLES CSS ===============*/
        :root {
            --header-height: 3.5rem;

            /*========== Colors ==========*/
            /*Color mode HSL(hue, saturation, lightness)*/
            --first-color: hsl(14, 98%, 50%);
            --black-color: hsl(0, 0%, 0%);
            --black-color-light: hsl(0, 0%, 40%);
            --white-color: hsl(0, 0%, 95%);
            --title-color: hsl(0, 0%, 0%);
            --text-color: hsl(0, 0%, 35%);
            --text-color-light: hsl(0, 0%, 64%);
            --body-color: hsl(0, 0%, 87%);
            --container-color: hsl(0, 0%, 83%);

            /*========== Font and typography ==========*/
            /*.5rem = 8px | 1rem = 16px ...*/
            --body-font: "Bai Jamjuree", sans-serif;
            --biggest-font-size: 2.5rem;
            --h1-font-size: 1.75rem;
            --h2-font-size: 1.25rem;
            --h3-font-size: 1.125rem;
            --normal-font-size: 0.938rem;
            --small-font-size: 0.813rem;
            --smaller-font-size: 0.75rem;

            /*========== Font weight ==========*/
            --font-regular: 400;
            --font-medium: 500;
            --font-semi-bold: 600;
            --font-bold: 700;

            /*========== z index ==========*/
            --z-tooltip: 10;
            --z-fixed: 100;
        }

        /*========== Responsive typography ==========*/
        @media screen and (min-width: 1150px) {
            :root {
                --biggest-font-size: 4.5rem;
                --h1-font-size: 3rem;
                --h2-font-size: 1.5rem;
                --h3-font-size: 1.25rem;
                --normal-font-size: 1rem;
                --small-font-size: 0.875rem;
                --smaller-font-size: 0.813rem;
            }
        }

        /*=============== BASE ===============*/
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }



        h1,
        h2,
        h3,
        h4 {
            color: var(--title-color);
            font-weight: var(--font-bold);
        }

        ul {
            list-style: none;
        }

        a {
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        /*=============== THEME ===============*/
        .nav__buttons {
            display: flex;
            align-items: center;
            column-gap: 1rem;
        }

        .change-theme {
            font-size: 1.25rem;
            color: var(--title-color);
            cursor: pointer;
            transition: color .3s;
        }

        /*=============== REUSABLE CSS CLASSES ===============*/
        .container {
            max-width: 1120px;
            margin-inline: 1.5rem;
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .section {
            padding-block: 4rem 2rem;
        }

        .section__title-1,
        .section__title-2 {
            position: relative;
            font-size: var(--h1-font-size);
            width: max-content;
            margin: 0.75rem auto 2rem;
        }

        .section__title-1 span,
        .section__title-2 span {
            z-index: 5;
            position: relative;
        }

        .section__title-1::after,
        .section__title-2::after {
            content: "";
            width: 40px;
            height: 28px;
            background-color: hsla(14, 98%, 50%, 0.2);
            position: absolute;
            top: -4px;
            right: -8px;
        }

        .section__title-2::after {
            top: initial;
            bottom: -4px;
        }

        .geometric-box {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: var(--first-color);
            rotate: -30deg;
        }

        .geometric-box::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            border: 3px solid var(--black-color);
            left: -5px;
            top: -5px;
        }

        .main {
            overflow: hidden;
            /* For animation ScrollReveal */
        }

        /*=============== BUTTON ===============*/
        .button {
            display: flex;
            align-items: center;
            justify-content: center;
            column-gap: 0.5rem;
        }

        .button {
            background-color: var(--black-color);
            padding: 1.1rem 1.5rem;
            color: var(--white-color);
            font-weight: var(--font-medium);
            border-radius: 0.75rem;
            transition: background-color 0.4s;
        }

        .button i {
            font-size: 1.25rem;
        }

        .button:hover {
            background-color: var(--first-color);
        }

        /*=============== PROJECTS ===============*/
        .projects {
           
            transition: background-color 0.4s;
        }

        .projects__container {
            row-gap: 2rem;
        }

        .projects__card {
            padding: 1rem 1rem 2rem;
            border-radius: 0.75rem;
            transition: background-color 0.4s;
            border: 1px solid #333;
        }

        .projects__image {
            position: relative;
            margin-bottom: 0.75rem;
        }

        .projects__img {
            border-radius: 0.75rem;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 24px;
        }

        .projects__button {
            position: absolute;
            right: 1rem;
            bottom: -1.5rem;
            padding: 1rem;
        }

        .projects__content {
            margin-bottom: 1.25rem;
        }

        .projects__subtitle {
            position: relative;
            display: inline-block;
            font-size: var(--small-font-size);
            font-weight: var(--font-medium);
            color: var(--text-color);
            margin-bottom: 0.75rem;
            padding-left: 1.75rem;
        }

        .projects__subtitle::after {
            content: "";
            width: 20px;
            height: 1px;
            background-color: var(--text-color);
            position: absolute;
            left: 0;
            top: 50%;
        }

        .projects__title {
            font-size: var(--h3-font-size);
            margin-bottom: 0.75rem;
        }

        .projects__buttons {
            display: flex;
            align-items: center;
            column-gap: 1rem;
        }

        .projects__link {
            display: flex;
            align-items: center;
            column-gap: 0.25rem;
            color: var(--text-color);
            font-size: 20px;
            font-weight: var(--font-medium);
            transition: color 0.4s;
        }

        .projects__link i {
            font-size: 1rem;
            color: var(--title-color);
            transition: color 0.4s;
        }

        .projects__link:hover,
        .projects__link:hover i {
            color: var(--first-color);
        }

        .projects__card:hover {
            background-color: var(--white-color);
            border-radius: 0.75rem;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 24px;
        }

        /*=============== MEDIA QUERIES ===============*/
        /* For small devices */
        @media screen and (max-width: 340px) {
            .container {
                margin-inline: 1rem;
            }
        }

        /* For medium devices */
        @media screen and (min-width: 576px) {
            .projects__container {
                grid-template-columns: 350px;
                justify-content: center;
            }
        }

        @media screen and (min-width: 768px) {
            .projects__container {
                grid-template-columns: repeat(2, 350px);
            }
        }

        /* For large devices */
        @media screen and (min-width: 1150px) {
            .container {
                margin-inline: auto;
            }

            .section {
                padding-block: 7rem 2rem;
            }

            .section__title-1::after,
            .section__title-2::after {
                width: 70px;
                height: 48px;
            }

            .projects__container {
                grid-template-columns: repeat(3, 352px);
                padding-block: 3rem 1rem;
            }

            .projects__card {
                padding: 1.25rem 1.25rem 2.5rem;
            }

            .projects__image {
                margin-bottom: 1rem;
            }

            .projects__content {
                margin-bottom: 2rem;
            }

            .projects__buttons {
                right: 1.25rem;
            }
        }
    </style>


  










    <!-- Fooooteeer -->
    <?php include ("includes/footer.php"); ?>





</body>

</html>