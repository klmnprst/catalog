<?php 
protect_page();
print_arr($_GET);
print_arr($_POST);

/**
 * TODO 
 * если аттрибутов нет предложить форму через ajax
 * если есть то редактировать их
 * если есть предложить поменять группу (грохнуть существующие значения в существующей группе)
 * если меняем категорию перекинуть фотки в другую директорию
 * при заливке фотки добавить ее имя в БД
 * 
 * проверить вывод меню категорий
 * прикрутить бредкрампс
 * логотип подумать
 * поменять название фирмы
 * 
 * 
 * 
 * EW Live from NY hosted by Overfiend - facebook.com/louis.overfiend
 * Advert:Targetspot - Advert:TargetSpot
 * DLR & Script feat. Martyna Baker - Blue Room
 * Enrigh tBeats - Need You | RauteMusik.FM/d
 * Derrick - Love away
 * Hacienda - Sci-Fi Saloon
 * Brain Rock - Do That Shit (Club Mix)
 */


#################################################
#               del  product                    #
#################################################
if (isset($_GET['goods_del'])) {
	if (isset($_GET['goods_del']) AND !empty($_GET['goods_del'])) {
		$product_url = sanitize($_GET['goods_del']);
		$query = "SELECT * FROM `product` WHERE `product_url` = '$product_url'";
		$result = mysqli_query($db,$query);
		if (mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_assoc($result);
			$product_id = $row['product_id'];

			//delete from product_attribute
			$query = "DELETE FROM `product_attribute` WHERE `product_id` = '$product_id'";
			mysqli_query($db,$query);
			//delete from product
			$query = "DELETE FROM `product` WHERE `product_id` = '$product_id'";
			mysqli_query($db,$query);

			header("Location: /admin/goods");
  			exit();
		}
	}
}
#################################################
#               del  product                    #
#################################################






















#################################################
#               add  product                    #
#################################################


############### 1 ##################
if (isset($_GET['add'])) {
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
echo "<p>Выберете набор аттрибутов:</p><ul>";
while ($row = mysqli_fetch_assoc($result)) { ?>
	<li><a href="/admin/goods?attribute_group_id=<?php echo $row['attribute_group_id']; ?>"><?php echo $row['name']; ?></a></li>
<?php } ?>
</ul>
<p><a href="/admin/goods?attribute_group_id=0"  style="color:#c600ff">[ Не использовать набор ]</a></p>
<?php }




############### 2 ##################
if (isset($_GET['attribute_group_id'])) {
	$attribute_group_id = (int)$_GET['attribute_group_id'];
	?>

	<form method="post">
  	URL<br>
  	<input type="text" name="product_url" required>
  	Name<br>
  	<input type="text" name="name" required>
  	Title<br>
  	<input type="text" name="title" required>
  	Keywords<br>
  	<input type="text" name="keywords">
  	Description<br>
  	<input type="text" name="description">
	
	  	Категория<br>
	  	<select name="cat_id">
	  	<?php 
	  	$query = "SELECT `id`,`name` FROM `main` WHERE `catalog` = '1'";
	  	$result = mysqli_query($db,$query);
	  	while ($row2 = mysqli_fetch_assoc($result)) { ?>
	  	<option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
	  	<?php  }  ?>
	  	</select>

	  	Page text<br>
	  	<textarea name="pagetext" style="height:100px;"></textarea>
	  	Аттрибуты:<br>
		<?php 
		$query = "SELECT * FROM `attribute` WHERE `attribute_group_id` = $attribute_group_id";
		$result = mysqli_query($db,$query);
		if (mysqli_num_rows($result)>0) {
			while ($row3 = mysqli_fetch_assoc($result)) { 
				echo $row3['name']; ?><br>
				<input type="text" name="attribute[<?php echo $row3['attribute_id']; ?>]">
			<?php }	
		}
		
		?>
	  	<input type="submit" name="goods_add" class="button" value="Добавить">
  	<br />
	</form>
<?php }


############### 3 ##################
if (isset($_POST['goods_add'])) {
  $product_url = sanitize($_POST['product_url']);
  $cat_id = (int)($_POST['cat_id']);
  $name = sanitize($_POST['name']);
  $pagetext = sanitize($_POST['pagetext']);
  $title = sanitize($_POST['title']);
  $keywords = sanitize($_POST['keywords']);
  $description = sanitize($_POST['description']);
  $time = time();


  //проверить url дубль

  $query = "INSERT INTO product (`product_url`,`cat_id`,`name`,`pagetext`,`title`,`keywords`,`description`,`time`) 
  VALUES ('$product_url','$cat_id','$name','$pagetext','$title','$keywords','$description','$time')";
  $result = mysqli_query($db,$query);
  $product_id = mysqli_insert_id($db);

  if (isset($product_id) AND !empty($product_id)) {
  		if (isset($_POST['attribute']) && !empty($_POST['attribute'])) {
  			foreach ($_POST['attribute'] as $key => $val) {
  				$query = "INSERT INTO `product_attribute` (`product_id`,`attribute_id`,`value`) VALUES ('$product_id','$key','$val')";
  				mysqli_query($db,$query);
  		}
  	}
  }
  header("Location: /admin/goods");
  exit();
}
#################################################
#               add  product                    #
#################################################



















#################################################
#              edit  product                    #
#################################################



############### 1 ##################
if (isset($_GET['goods_edit'])) {
	if (isset($_GET['goods_edit']) AND !empty($_GET['goods_edit'])) {
		$product_url = sanitize($_GET['goods_edit']);
		$query = "SELECT * FROM `product` WHERE `product_url` = '$product_url'";
		$result = mysqli_query($db,$query);
		if (mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_assoc($result);
			$product_id = $row['product_id']; ?>

			<form method="post">
  				URL<br>
  				<input type="text" name="url" value="<?php echo $row['product_url']; ?>">
  				Name<br>
  				<input type="text" name="name" value="<?php echo $row['name']; ?>">
  				Категория<br>
  				<select name="cat_id" id="cat_id">
  				<?php 
  				$query = "SELECT `id`,`name` FROM `main` WHERE `catalog` = '1'";
  				$result = mysqli_query($db,$query);
  				while ($row2 = mysqli_fetch_assoc($result)) { 
  				  if ($row2['id'] == $row['cat_id']) { ?>
  				    <option selected value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
  				<?php  } else { ?>
  				  <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
  				<?php  } } ?>
  				</select>
  				Keywords<br>
  				<input type="text" name="keywords" value="<?php echo $row['keywords']; ?>">
  				Description<br>
  				<input type="text" name="description" value="<?php echo $row['description']; ?>">
  				Title<br>
  				<input type="text" name="title" value="<?php echo $row['title']; ?>">
  				Page text<br>
  				<textarea name="pagetext" style="height:100px;"><?php echo $row['pagetext']; ?></textarea>
          <?php 
          //Аттрибуты если есть 
          $query = "SELECT * FROM `attribute` LEFT JOIN `product_attribute` USING(`attribute_id`) WHERE `product_id` = '$product_id'";
          //echo $query;
          $result = mysqli_query($db,$query);
          if (mysqli_num_rows($result)>0) {
            echo '<form>';
            while ($row3 = mysqli_fetch_assoc($result)) {
              //print_arr($row3); ?>
              <?php echo $row3['an']; ?><br>
              <input type="text" name="attribute[<?php echo $row3['attribute_id']; ?>]" value="<?php echo $row3['value']; ?>">
            <?php }
            echo '</form>';
          }
          

          ?>
          
          

  				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
  				<input type="submit" name="goods_change" class="button" value="Изменить">
          <input type="file" name="file" id="file">
  				<div id="info2"></div>
  				<div id="preloader" style="display: none;"><img src="/template/img/preloader.gif" alt="loader"></div>
  				  <br />
			</form>
		<?php }
	}
}

############### 2 ##################
if (isset($_POST['goods_change'])) {
	echo "sxsx";
}





#################################################
#              edit  product                    #
#################################################








if (empty($_GET) AND empty($_POST)) { ?> 
	<p class="panel"><a href="/admin/goods?add" style="color:#659900">Добавить товар <i class="fi-plus"></i></a></p>
	Редактировать товар: <i class="fi-widget"></i>
	<form action="">
		<input type="text" name="goods_edit"  placeholder="Введите url товара">
		<input type="submit" value="Изменить" class="button">
	</form>
	Удалить товар: <i class="fi-minus"></i>
	<form action="">
		<input type="text" name="goods_del"  placeholder="Введите url товара">
		<input type="submit" value="Удалить" class="button" onclick="return confirm('Уверены?')">
	</form>
<?php } ?>








<!-- for download pics -->
<script>
$(document).ready(function(){
    $('#file').bind('change', function(){
    var category_id = $('#cat_id option:selected').val();
    //alert('cat: ' + category_id);

    var data = new FormData();
    data.append('category_id', category_id);
    var error = '';
    jQuery.each($('#file')[0].files, function(i, file) {
 
            if(file.name.length < 1) {               
               error = error + ' Файл имеет неправильный размер! ';             
            } //Проверка на длину имени             
            if(file.size > 3000000) {
                error = error + ' File ' + file.name + ' is to big.';
            } //Проверка размера файла
            if(file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg' ) {
                error = error + 'File  ' + file.name + '  doesnt match png, jpg or gif';
            } //Проверка типа файлов
        data.append('file-'+i, file);
    });

if (error != '') {$('#info').html(error);} else {
 
        $.ajax({
            url: '/controllers/admin/ajax/upload_edit.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function() {
                $('#preloader').show();
            },
            success: function(data){
                $('#info').html(data);
                $('#info2').html(data).css('display', 'inline-block');
                $('#preloader').hide();
            }
        });
         }
    })
});
</script>
<!-- for download pics -->


