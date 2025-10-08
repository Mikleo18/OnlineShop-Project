<?php
if (isset($_POST["signin"])) 
{
    header("location:Membership.php");
}

if (isset($_POST["login"])) 
{
    header("location:Login.php");
}

if (isset($_POST["admin"])) 
{
    header("location:adminpanel.php");
}


?>

<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş</title>
    <link rel="shortcut icon" type="x-icon" href="icons\homeicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    
  </head>
  <body>
    <div class="container p-5">
        <div class="card p-5">
            <form action="ilk.php" method="POST">
            <h1>Hoşgeldiniz</h1>

            <div class="col-md-12 text-center">
                <button type="submit" name= "signin" class="button button-green ">Sign In</button>
                <button type="submit" name= "login" class="button button-blue">Log In</button>
                <button type="submit" name= "admin" class="button button-red">Admin</button>
            </div>
            </form>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
