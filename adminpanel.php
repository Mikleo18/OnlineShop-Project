<?php

if (isset($_POST["ekle"])) 
{
    header("location:ProductAdd.php");
}

if (isset($_POST["sil"])) 
{
    header("location:ProductDelete.php");
}

if (isset($_POST["guncel"])) 
{
    header("location:ProductUpdate.php");
}

if(isset($_POST["geri"]))
{
    header("location:index.php");
}


?>


<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Paneli</title>
    <link rel="shortcut icon" type="x-icon" href="icons\homeicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    
  </head>
  <body>
    <div class="container p-5">
        <div class="card p-5">
            <form action="adminpanel.php" method="POST">
            <h1>Hoşgeldiniz</h1>

            <div class="col-md-12 text-center">
                <button type="submit" name= "ekle" class="button button-green ">Ürün Ekleme </button>
                <button type="submit" name= "guncel" class="button button-blue">Ürün Güncelleme</button>
                <button type="submit" name= "sil" class="button button-red">Ürün Silme</button>
                <button type="submit" name= "geri" class="button button-red">Geri Dön</button>
            </div>

            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  </body>
</html>


