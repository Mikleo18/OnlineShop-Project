<?php
include("ConnectionLink.php");

$username_err = "";
$parola_err="";

if(isset($_POST["geri"]))
{
    header("location:index.php");
}

if(isset($_POST["giris"]))
{
    //Kullanıcı adı 
    if (empty($_POST["kullaniciadi"])) 
    {
        $username_err ="Kullanıcı adı boş geçilmez";
    }
    else
    {
        $username = $_POST["kullaniciadi"];
    }

   
 //Parola Doğrulama
    if(empty($_POST["sifre"]))
    {
        $parola_err ="Parola kısmı boş geçilmez";
     
    }
    else
    {
     $parola=$_POST["sifre"];
    }



    if(isset($username) && isset($parola))
    {
        $secim ="SELECT * FROM users WHERE username = '$username'";
        $calistir = mysqli_query($connectionlink,$secim);
        $kayittsayisi = mysqli_num_rows($calistir);

        if ($kayittsayisi>0) 
        {
            $ilgilikayit = mysqli_fetch_assoc($calistir);
            $haslisifre=$ilgilikayit["passwordxd"];
            
            if(password_verify($parola,$haslisifre))
            {
                session_start();
                $_SESSION["username"]=$ilgilikayit["username"];
                $_SESSION["email"]=$ilgilikayit["email"];
                header("location:ShoppingCart.php");



            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">Şifre yanlış</div>';
            }



        }
        else
        {
        echo '<div class="alert alert-danger" role="alert">Kullanıcı adı yanlış</div>';
        }
   

    mysqli_close($connectionlink);

     }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Üye Giriş </title>
    <link rel="shortcut icon" type="x-icon" href="icons\loginicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
    <div class="container p-5">
        <div class="card p-5">
            <form action="Login.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı:</label>
                    <input type="text" class="form-control       <?php 
                    if (!empty($username_err))
                    {
                        echo "is-invalid";
                    }
                    
                    ?>
                    " id="exampleInputEmail1" name = "kullaniciadi" >
              
                    <div class="invalid-feedback">
                     <?php echo $username_err; ?>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Şifre:</label>
                    <input type="password" class="form-control       <?php 
                    if ( !empty($parola_err))
                    {
                        echo "is-invalid";
                    }
                    
                    ?>
                    " id="exampleInputPassword1" name = "sifre">
                    <div class="invalid-feedback">
                     <?php echo $parola_err ?>
                    </div>
                </div>


                <button type="submit" name= "giris" class="btn btn-primary">Giriş Yap</button>
                <button type="submit" name= "geri" class="btn btn-primary">Geri Dön</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>