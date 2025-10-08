<?php
include("ConnectionLink.php");

$username_err = "";
$email_err="";
$parola_err="";
$parolatkr_err="";
$message="";


if(isset($_POST["geri"]))
{
    header("location:index.php");
}

if(isset($_POST["kaydet"]))
{
  
    //Kullanıcı adı 
    if (empty($_POST["kullaniciadi"])) 
    {
        $username_err ="Kullanıcı adı boş geçilmez";
    }
    else if (strlen($_POST["kullaniciadi"])<6)
    {
        $username_err="Kullanıcı adı en az 6 karakterden oluşmalıdır";
    }
    else if (!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["kullaniciadi"]))
    {
        $username_err ="Kullanıcı adı büyük harf ve rakamdan oluşmalıdır";
    }
    else
    {
        $username = $_POST["kullaniciadi"];
    }



    //Email Doğrulama

    if (empty($_POST["email"])) 
    {
        $email_err = "Email alanı boş bırakılamaz";
    }
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
    {
        $email_err = "Geçersiz email formatı";
    }
    else
    {
        $email = $_POST["email"];
    }

   
 //Parola Doğrulama
    if(empty($_POST["sifre"]))
    {
        $parola_err ="Parola kısmı boş geçilmez";
     
    }
    else
    {
     $parola=password_hash($_POST["sifre"],PASSWORD_DEFAULT);
    }

    // Parola Tekrar
    if(empty($_POST["sifretkr"]))
    {
      $parolatkr_err ="Parola tekrar boş bırakılmaz";
    }
    else if ($_POST["sifre"]!=$_POST["sifretkr"])
    {
      $parolatkr_err ="Parolalar eşleşmiyor";
      $parola_err="Parolalar eşleşmiyor";
    }
    else
    {
        $parolatkr = $_POST["sifretkr"];
    }


    if(isset($username) && isset($email) && isset($parola))
    {
        
   

    
    $add = "INSERT INTO users (username,email,passwordxd) VALUES ('$username','$email','$parola')";
    $execute_add=mysqli_query($connectionlink,$add);
   
    
   

    if ($execute_add) 
    {
        $message=
        '<div class="alert alert-success" role="alert">
        Kayıt başarılı bir şekilde eklendi
        </div>';
    }
    else 
    {
        $message =
        '<div class="alert alert-danger" role="alert">
        Kayıt eklenirken problem oluştu
        </div>';
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
    <title>Üye Kayıt </title>
    <link rel="shortcut icon" type="x-icon" href="icons\loginicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
    <div class="container p-5">
        <div>
            <form action="Membership.php" method="POST" class="form-container">
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
                    <label for="exampleInputEmail1" class="form-label">Email adresi:</label>
                    <input type="text" class="form-control       <?php 
                    if (!empty($email_err))
                    {
                        echo "is-invalid";
                    }
                    
                    ?>
                    " id="exampleInputEmail1" name ="email">
                    <div class="invalid-feedback">
                     <?php echo $email_err;?>
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

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Şifre tekrar:</label>
                    <input type="password" class="form-control       <?php 
                    if ( !empty($parolatkr_err))
                    {
                        echo "is-invalid";
                    }
                    
                    ?>
                    " id="exampleInputPassword1" name = "sifretkr">
                    <div class="invalid-feedback">
                    <?php echo $parolatkr_err ?>
                    </div>
                </div>

                <button type="submit" name= "kaydet" class="btn btn-primary">Kayıt Ol</button>
                <button type="submit" name= "geri" class="btn btn-primary">Geri Dön</button>
                <?php 
                echo $message;
                ?>
                
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>