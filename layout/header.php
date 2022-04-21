<?php
session_start();
require_once "../../autoload/autoloader.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    <style>
        .nav{
            color:white;
            text-decoration:none;
            font-size:22px;
            font-weight: bold;
            margin-left:20px;
            transition: 0.5s;
        }
        .nav:hover{
            color:#d6d6d6;
        }
    </style>

    <?php 
        if ($_SESSION['email'] == false) { 
            header('location: signin.php?out=1'); 
        }
    ?>

    <div class="shadow-lg p-4 mb-5 bg-body fw-bold" style="background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(9,9,121,1) 0%, rgba(3,0,60,1) 89%); ">
        <ul class="nav justify-content-end" style="color:white;">
        
                <li class="nav-item" >
                    <a class="nav"  href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav" href="signin.php?out=1">Sign out</a>
                </li>
            
        </ul>
    </div>
    <?php
    