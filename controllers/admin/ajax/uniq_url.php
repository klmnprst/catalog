<?php 
//print_r($_GET);
include($_SERVER['DOCUMENT_ROOT'] . '/libs/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/libs/function.php');
if (isset($_GET['product_url']) AND !empty($_GET['product_url'])) {
    $product_url = sanitize($_GET['product_url']);
    $query = "SELECT * FROM `product` WHERE `product_url` = '$product_url'";
        if (!$result = mysqli_query($db,$query)) {mysqli_error($db);}
        if (mysqli_num_rows($result) > 0) {
            echo '<span class="alert label">Данный URL уже занят!</span>';
        } else {
            echo '<i class="fi-check" style="color:green"></i>';
        }
}
    
