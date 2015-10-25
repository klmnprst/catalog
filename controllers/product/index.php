<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  
echo "\n<!-- ################ product ################### -->\n";


//echo $action; //это url
$product_url = $params['product_url'];


if (isset($product_url) AND !empty($product_url)) { //Ищем категорию

$query = "SELECT product.*, main.name AS cat_name, main.url AS cat_url, img.name AS img_name FROM product LEFT JOIN main ON product.cat_id = main.id LEFT JOIN img USING(product_id) WHERE product.product_url='$product_url'";
$result = mysqli_query($db, $query);
  if (mysqli_num_rows($result)>0) {
      $row = mysqli_fetch_assoc($result);

      $img = '/img/cat/'.$row['cat_id'].'/'.$row['img_name'];
      $text = $row['pagetext'];
      $title = $row['title'];
      $keywords = $row['keywords'];
      $description = $row['description'];
      $cat_url = $row['cat_url'];
      $cat_name = $row['cat_name'];

      echo "<h1 class=\"first\">".$title."</h1>";
      echo '<p><a href="/cat/'.$cat_url.'">'.$cat_name.'</a></p>';


      build_product($row['name'],$img,$action,$row['product_id'],$text);
      build_product_character($row['product_id']);



  } else {
      header('Location: /404.html');
    exit;
  }
} 