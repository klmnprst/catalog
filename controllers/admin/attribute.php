<?php
protect_page();
print_arr($_GET);
print_arr($_POST);


/**
 * Adding attribute values
 */
if (isset($_POST['add_attr']) && isset($_GET['add_attributes'])) {
$error = false;
$attribute_group_id = (int)$_GET['add_attributes'];		

	foreach ($_POST['attribute_name'] as $key => $value) {
		if (empty($value)) {
			continue;
		} else {
			//echo $value;
			$sort_order = (int)$_POST['sort_order'][$key];
			$query = "INSERT INTO `attribute` (`attribute_group_id`,`name`,`sort_order`) VALUES ('$attribute_group_id','$value','$sort_order')";
			//echo $query;
			
			$result = mysqli_query($db,$query);
			if (!$result) {
				$error = true;
			} 
		}
		
	}
	if ($error === false) {
		header("Location: /admin/attribute");
		exit();
	}
}
/**
 * Adding attribute values
 */






?>

<p class="panel">Существующие группы аттрибутов:</p>
<?php 
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
?>
<div class="row" style="padding: 0 15px;">
	<div class="large-8 columns" style="background: #C4EAF2;">Группа аттрибутов</div>
	<div class="large-2 columns" style="background: #7EBFD9;">Сортировка</div>
	<div class="large-2 columns" style="background: #C4EAF2;">Действие</div>
</div>
<?php	
while ($row = mysqli_fetch_assoc($result)) {

?>
	<div class="row" style="padding: 0 15px;">
		<div class="large-8 columns" style="background: #C4EAF2;"><a href="/admin/attribute?edit_group='<?php echo $row['attribute_group_id']; ?>"><?php echo $row['name']; ?></a></div>
		<div class="large-2 columns" style="background: #7EBFD9;"><?php echo $row['sort_order']; ?></div>
		<div class="large-2 columns" style="background: #C4EAF2;">
			<a href="/admin/attribute?edit_attributes=<?php echo $row['attribute_group_id']; ?>"><i class="fi-widget large"></i></a>
			<a href="/admin/attribute?add_attributes=<?php echo $row['attribute_group_id']; ?>"><i class="fi-plus large"></i></a>
		</div>
	</div>
<?php
	
}

if (isset($_GET['edit_group'])) {
	$attribute_group_id = (int)$_GET['edit_group'];
	echo $attribute_group_id;
}

if (isset($_GET['attribute_name'])) {
	$name = sanitize($_GET['attribute_name']);
	$sort_order = isset($_GET['sort_order']) ? (int)$_GET['sort_order'] : 0;
	$query = "INSERT INTO `attribute_group` (`name`,`sort_order`) VALUES ('$name', '$sort_order')";
	$result = mysqli_query($db,$query);
	if ($result) {
		header("Location: /admin/attribute");
		exit();
	} else {
		echo 'Error in writing DB!';
	}
}
/**
 * Edit attributes
 */
if (isset($_GET['edit_attributes'])) {
	$attribute_group_id = (int)$_GET['edit_attributes'];
	$query = "SELECT * FROM `attribute` WHERE `attribute_group_id` = '$attribute_group_id'";
	$result = mysqli_query($db,$query);
	while ($row = mysqli_fetch_assoc($result)) {
		echo $row['name']. '<br>';
	}
	
}



?>

<p class="panel">Добавить группу аттрибутов</p>
<form>
<input type="text" name="attribute_name" placeholder="Название группы">
<input type="text" name="sort_order" placeholder="Порядок сортировки" value="0">
<input type="submit" name="attr_add" class="button" value="Добавить">
</form>

<br>
<?php
/**
 * Add atributes
 */
if (isset($_GET['add_attributes'])) {
	$attribute_group_id = (int)$_GET['add_attributes'];
	$query = "SELECT * FROM `attribute_group` WHERE `attribute_group_id` = '$attribute_group_id'";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($result);
	$name = $row['name'];
 ?>
<p class="panel">Добавить аттрибуты для группы <?php echo $name; ?></p>
<form method="post">
	<?php for ($i=0; $i < 10; $i++) { ?>
	<div class="row">
		<div class="large-10 columns">
			<input type="text" name="attribute_name[]" placeholder="Название параметра">
		</div>
		<div class="large-2 columns">
			<input type="text" name="sort_order[]" placeholder="Порядок сортировки" value="0">
		</div>
	</div>	

	<?php } ?>



<input type="submit" name="add_attr" class="button" value="Добавить">
</form>
<?php } ?>







