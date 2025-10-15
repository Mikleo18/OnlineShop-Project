<?php
session_start(); // Oturumu başlat
$message="Cart is empty";
include("ConnectionLink.php");

if(isset($_POST["geri"]))
{
    header("location:Exit.php");
}



// Sepete ürün ekle
if (isset($_POST["satin"])) {
    $urunid = $_POST["satin"];

    $connectionlink->begin_transaction();

    try {
        // Fetch the product details to check quantity
        $stmt = $connectionlink->prepare("SELECT urunadi, urunfiyati, urunsayisi FROM urunler WHERE urunid = ?");
        $stmt->bind_param("i", $urunid);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && $product['urunsayisi'] > 0) {
            // Add the product to the cart session
            if (!isset($_SESSION['cart'][$urunid])) {
                $_SESSION['cart'][$urunid] = [
                    "urunadi" => $product['urunadi'],
                    "urunfiyati" => $product['urunfiyati'],
                    'quantity' => 1
                ];
            } else {
                $_SESSION['cart'][$urunid]['quantity']++;
            }

            // Update the product quantity
            $updateStmt = $connectionlink->prepare("UPDATE urunler SET urunsayisi = urunsayisi - 1 WHERE urunid = ?");
            $updateStmt->bind_param("i", $urunid);
            $updateStmt->execute();
            $updateStmt->close();
        }

        // Commit the transaction
        $connectionlink->commit();
    } catch (Exception $e) {
        $connectionlink->rollback();
        throw $e;
    }
}

// Sepetten ürün kaldır
if (isset($_POST["remove_from_cart"])) {
    $urunid = $_POST["remove_from_cart"];
    // Kaldırılan ürün miktarını sepetten çıkar
    if (isset($_SESSION['cart'][$urunid])) {
        $productQuantity = $_SESSION['cart'][$urunid]['quantity'];
        unset($_SESSION['cart'][$urunid]);

        // Ürün miktarını geri ekleyerek güncelle
        $updateStmt = $connectionlink->prepare("UPDATE urunler SET urunsayisi = urunsayisi + ? WHERE urunid = ?");
        $updateStmt->bind_param("ii", $productQuantity, $urunid);
        $updateStmt->execute();
        $updateStmt->close();
    }
}

// Sepet içeriğini temizle
if (isset($_POST["clear_cart"])) {
    // Sepet içeriğini sıfırla
    unset($_SESSION['cart']);
}

// Siparişi onayla
if (isset($_POST["confirm_order"])) {
    
    unset($_SESSION['cart']);
    $message ="Sipariş Onaylandı";

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDRVN Shop</title>
    <link rel="shortcut icon" type="x-icon" href="icons/SDRVN.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div>
    <form action="" method="POST" class="form-container">
        <?php 
        if(isset($_SESSION["username"]))
        {
          echo "<h3>".$_SESSION["username"]." Welcome </h3>";
        }
        else
        {
            echo " ";
        }
        ?>
        
    <button type="submit" name= "geri" class ="button button-red">Log Out</button>
        <table border="3">
            <tr>
                <th>Product id</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Add Cart</th>
            </tr>
            <?php
            $sonuc = $connectionlink->query("SELECT * FROM urunler");
            if ($sonuc->num_rows > 0) {
                while ($cek = $sonuc->fetch_assoc()) {
                    echo "<tr>
                          <td>{$cek['urunid']}</td>
                          <td>{$cek['urunadi']}</td>
                          <td>{$cek['urunfiyati']}</td>
                          <td>{$cek['urunsayisi']}</td>
                          <td>
                              <button type='submit' class='buttongreen' name='satin' value='{$cek['urunid']}'>Add to Cart</button>
                          </td>
                      </tr>";
                }
            }
            ?>
        </table>
    </form>

    <h1>Shopping Cart</h1>
    <?php if (!empty($_SESSION['cart'])): ?>
    <form action="ShoppingCart" method="POST">
            <table border="3">
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Remove Product</th>
                </tr>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $urunid => $productInfo):
                    $urunadi = $productInfo['urunadi'];
                    $urunfiyati = $productInfo['urunfiyati'];
                    $quantity = $productInfo['quantity'];
                    $totalProductPrice = $urunfiyati * $quantity;
                    $totalPrice += $totalProductPrice;
                    ?>
                    <tr>
                        <td><?php echo $urunadi; ?></td>
                        <td><?php echo $urunfiyati; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $totalProductPrice; ?></td>
                        <td>
                            <button type='submit' name='remove_from_cart' class='button button-red' value='<?php echo $urunid; ?>'>Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Toplam Fiyat:</strong></td>
                    <td colspan="2"><?php echo $totalPrice; ?></td>
                </tr>
            </table>
            <button type="submit" name="clear_cart" class="button button-red">Clear Cart</button>
            <button type="submit" name="confirm_order" class="button button-green">Order</button>
        </form>
    <?php else: ?>
        <p>
            <?php
             echo "<div class='alert alert-success' role='alert'>
                $message
            </div>"; 
            ?>
        </p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
