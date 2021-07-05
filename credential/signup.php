<?php
  $alert=false;
  $clr=false;
    if(isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $err=false;

    
        if(empty($fname)){
        $error_msg['fname']="First Name is Mandatory";
        $err=true;
        } elseif(!preg_match("/^[a-zA-Z ]*$/",$fname)){
        $error_msg['fname']="Only letters and white space allowed";
        $err=true;
        }

        if(empty($lname)){
        $error_msg['lname']="Last Name is Mandatory";
        $err=true;
        } elseif(!preg_match("/^[a-zA-Z ]*$/",$lname)){
        $error_msg['lname']="Only letters and white space allowed";
        $err=true;
        }   

        if(empty($email)){
        $error_msg['email']="E-mail is Mandatory";
        $err=true;
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error_msg['email']="Invalid Email Format";
            $err=true;
        }

        if(empty($password)){
            $error_msg['password']="Password is Mandatory";
            $err=true;
        } elseif((strlen($password)<8)){
            $error_msg['password']="Minimum 8 character required";
            $err=true;
        } 
        if(empty($c_password)){
            $error_msg['c_password']="Confirm the Password";
            $err=true;
        } 

        if ($password != $c_password) {
            $error_msg['c_password']="passwords should match";
            $err=true;
        }

        if($err==false){
            $alert=true;
            $connent = mysqli_connect("remotemysql.com", "F8I3FAjxrT", "chD6vtoVGP", "F8I3FAjxrT");
            // $connect=mysqli_connect("localhost","root","","to-do list");
            $sql= "INSERT INTO `users` (`First Name`, `Last Name`, `E-mail`, `Password`, `todoArray`) VALUES ('$fname', '$lname', '$email',
             '$password', '[]')";

             if($connect->query($sql)){
                 header("location: login.php");
                 exit;
             } else{
                 $msg= "Email is already Registered. Please try to login";
                 $clr=false;
             }
             $connect->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIGN-UP</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/328f9238c7.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/common.css">
    <?php
    if($clr==true) {
    ?>
    <style>
        .alert{
            display: flex;
            background-color: #4afdd4;
        }
    </style>
    <?php
     }elseif($clr==false){
    ?>
     <style>
        .alert{
            display: flex;
            background-color: #ffaed5;
        }
    </style>
    <?php
     }
     ?>
</head>

<body>
  <header>

  </header>
  <main>
    <nav class="navbar navbar-expand-lg navbar-light bg-light static-top ">
      <div class="container">
        <div class="navbar-brand brand">
          <img src="../asset/laptop.svg" alt="logo" class="hearder-img">
          <p class="header-title">TaskiTO</p>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link header-title" href="../index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link header-title " href="./login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link header-title active current" href="#">Signup
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
      if($alert==true){
          ?>
          <div class="alert">
              <?php
              echo $msg;
              ?>
              <div class="closebtn" onclick="this.parentElement.style.display='none';"> &times; </div>
          </div>
          <?php
      }                   
    ?>
    <section class="container">
      <div id="login-row" class="row all-center align-items-center">
        <div id="login-column" class="col-md-12 all-center">
          <div id="login-box" class="col-md-12 ">
            <form id="login-form" class="form" action="" method="post">
              <h3 class="text-center text-info-c">Sign-Up</h3>
              <div class="wrapper">
                <div class="form-group one">
                  <label for="name" class="text-info-c">First Name:</label><br>
                  <input type="text" name="fname" id="fname" class="form-control">
                  <?php
                    if(isset($error_msg['fname'])){
                        echo "<div class='error'>" .$error_msg['fname']. "</div>";
                    }
                  ?>
                  <label for="name" class="text-info-c">Last Name:</label><br>
                  <input type="text" name="lname" id="lname" class="form-control">
                  <?php
                    if(isset($error_msg['lname'])){
                        echo "<div class='error'>" .$error_msg['lname']. "</div>";
                    }
                  ?>
                  </div>
                <div class="form-group two">
                  <label for="email" class="text-info-c">Email:</label><br>
                  <input type="email" name="email" id="email" class="form-control">
                  <?php
                    if(isset($error_msg['email'])){
                        echo "<div class='error'>" .$error_msg['email']. "</div>";
                    }
                  ?>
                </div>
                <div class="form-group three">
                  <label for="password" class="text-info-c">Password:</label><br>
                  <input type="password" name="password" id="password" class="form-control">
                  <?php
                    if(isset($error_msg['password'])){
                        echo "<div class='error'>" .$error_msg['password']. "</div>";
                    }
                  ?>
                  <label for="confirm-password" class="text-info-c">Confirm Password:</label><br>
                  <input type="password" name="c_password" id="c_password" class="form-control">
                  <?php
                    if(isset($error_msg['c_password'])){
                        echo "<div class='error'>" .$error_msg['c_password']. "</div>";
                    }
                  ?>
                </div>
              </div>
              <div class="form-group ">
                <button class="button" type="submit" name="submit"><span>Register</span></button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="contact" id="contact">
      <div class="contact-item">
          <a href="mailto:sumanguptamenu@gmail.com" target="_blank">
            <i class="icon-2 e-mail far fa-envelope fa-2x"></i></a>
      </div>
      <div class="contact-item">
          <a href="https://www.linkedin.com/in/suman-gupta-b27a27190/" target="_blank">
          <i class="icon-2 linkdin fab fa-linkedin-in fa-2x"></i></a>
      </div>
      <div class="contact-item">
          <a href="https://www.instagram.com/hatersluver/" target="_blank">
          <i class="icon-2 instagram fab fa-instagram fa-2x"></i></a>
      </div>
      <div class="made-by">
        <p class="made-by-me">
          © Suman Gupta | All Rights Reserved.
        </p>
      </div>
  </div>
  </footer>
</body>
</html>