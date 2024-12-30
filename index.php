<?php
require 'koneksi.php';
?>

<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets/css/styles.css">

      <title>Login form</title>
   </head>
   <body>
      <div class="login">
         
         <img src="assets/img/login-bg.jpg" alt="image" class="login__bg" height="100px">

         <form  method="POST" class="login__form">
            <img  class="logo" src="cihuy.png" alt="" width="323px" height="198px">

            <div class="login__inputs">
               <div class="login__box">
                  <label for="username">
                  <input for="username" type="username" placeholder="username" name="uname" required class="login__input" ></label>
                  <i class="ri-mail-fill"></i>
               </div>

               <div class="login__box">
                  <label for="password">
                  <input for="password" type="password" placeholder="Password" name="psw" required class="login__input"></label>
                  <i class="ri-lock-2-fill"></i>
               </div>
            </div>

            <button type="submit" name="login" class="login__button">Login</button>


         </form>
      </div>
   </body>
</html>