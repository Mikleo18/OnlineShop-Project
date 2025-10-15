<?php
include("ConnectionLink.php");


$urunismi_err="";
$urunfiyati_err="";
$urunsayisi_err ="";
$olmus ="";
$olmamis="";


if(isset($_POST["geri"]))
{
    header("location:adminpanel.php");
}


if(isset($_POST["sil"]))
{


    if (empty($_POST["urunfiyati2"])) 
    {
        $urunfiyati_err = "Ürün id boş bırakılamaz";
    }
    else
    {
        $urunfiyati = $_POST["urunfiyati2"];
    }




    if( isset($urunfiyati))
    {
    $stmt = $connectionlink->prepare("CALL Urun_Silme(?)");
    $stmt->execute([$urunfiyati]);

    if ($stmt) 
    {
        $olmus="Ürün Başarıyla Silindi";
        $_POST=array();
    }
    else 
    {
        $olmamis ="Error".mysqli_error($connectionlink);
    }
   

    mysqli_close($connectionlink);

     }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <style>
        .buttonred {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 40px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
    background-color: #FF0000;
}
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ürün sil</title>
    <link rel="shortcut icon" type="x-icon" href="icons\packicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
    <div class="container">
        
            <form action="ProductDelete.php" method="POST" class="form-container">
               

                <div>
                    <label for="exampleInputEmail1" class="form-label">Product Id:</label>
                    <input type="number" class="form-control       <?php 
                    if (!empty($urunfiyati_err))
                    {
                        echo "is-invalid";
                    }
                    
                    ?>
                    " id="exampleInputEmail1" name ="urunfiyati2">
                    <div class="invalid-feedback">
                     <?php echo $urunfiyati_err;?>
                    </div>
                </div>

            

                <button type="submit" name= "sil" class ="buttonred">Delete</button>
                <button type="submit" name= "geri" class ="button button-red">Go Back</button>
            </form>
            <?php if($olmus): ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?php echo $olmus;?>
                </div>
                <?php endif;?>
            <?php if($olmamis): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $olmamis;?>
            </div>
                <?php endif;?>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>