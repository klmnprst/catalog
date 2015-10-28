<?php
/**
 * TODO: delete attribute
 */

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



/**
 * Editing attributes
 */
if (isset($_POST['edit_attr'])) {
	$error = false;
	$attribute_group_id = (int)$_POST['attribute_group_id'];
	foreach ($_POST['attr'] as $key => $val) {
		$attribute_id = (int)$key;
		$name = sanitize($val['name']);
		$sort_order = (int)$val['sort_order'];

		$query = "UPDATE `attribute` SET `name` = '$name', `sort_order` = '$sort_order' WHERE `attribute_id` = '$attribute_id'";
		$result = mysqli_query($db,$query);
			if (!$result) {
				$error = true;
			} 

	}
	if ($error === false) {
		header("Location: /admin/attribute?edit_attributes=$attribute_group_id");
		exit();
	}
}


/**
 * Editing group attributes
 */
if (isset($_POST['edit_group_attr'])) {
	$attribute_group_id = (int)$_POST['attribute_group_id'];
	$sort_order = (int)$_POST['sort_order'];
	$name = sanitize($_POST['name']);
	$query = "UPDATE `attribute_group` SET `name`='$name', `sort_order`='$sort_order' WHERE `attribute_group_id` = '$attribute_group_id' LIMIT 1";
	//echo $query;
	$result = mysqli_query($db,$query);
	if ($result) {
		header("Location: /admin/attribute");
		exit();
	}
	
}



/**
 * Delete group attributes
 */
if (isset($_GET['del_group_attr'])) {
	$attribute_group_id = (int)$_GET['del_group_attr'];
	$query = "SELECT * FROM `attribute` WHERE `attribute_group_id` = '$attribute_group_id'";
	$result = mysqli_query($db,$query);
	if (mysqli_num_rows($result)>0) {
		?>
		<p><span class="alert label">Внимание, группа аттрибутов не пустая, вначале удалите аттрибуты из группы!</span></p>
		<?php
	} else {
		$query = "DELETE FROM `attribute_group` WHERE `attribute_group_id` = '$attribute_group_id' LIMIT 1";
		$result = mysqli_query($db,$query);
		if ($result) {
			header("Location: /admin/attribute");
			exit();
		}
	}
}
/**
 * Delete group attributes
 */







?>

<p class="panel">Существующие группы аттрибутов:</p>
<?php 
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
?>
<p><a href="/admin/attributes?add_group_attr" style="color:orangered">Добавить группу аттрибутов</a></p>
<div class="row" style="padding: 0 15px;">
	<div class="large-8 columns" style="background: palegoldenrod">Группа аттрибутов</div>
	<div class="large-2 columns" style="background: orange;">Сортировка</div>
	<div class="large-2 columns" style="background: palegoldenrod">Действие</div>
</div>

<?php	
while ($row = mysqli_fetch_assoc($result)) {
?>
	
	<div class="row" style="padding: 0 15px;">
		<div class="large-8 columns" style="background: #C4EAF2;"><a href="/admin/attribute?edit_group='<?php echo $row['attribute_group_id']; ?>"><?php echo $row['name']; ?></a></div>
		<div class="large-2 columns" style="background: #7EBFD9;"><?php echo $row['sort_order']; ?></div>
		<div class="large-2 columns" style="background: #C4EAF2;">
			<span data-tooltip aria-haspopup="true" class="has-tip" title="Редактировать аттрибуты">
				<a href="/admin/attribute?edit_attributes=<?php echo $row['attribute_group_id']; ?>"><i class="fi-list-thumbnails large"></i></a>
			</span>
			<span data-tooltip aria-haspopup="true" class="has-tip" title="Редактировать группу">
					<a href="/admin/attribute?edit_group_attr=<?php echo $row['attribute_group_id']; ?>"><i class="fi-wrench large"></i></a>
			</span>
			<span data-tooltip aria-haspopup="true" class="has-tip" title="Добавить аттрибуты для группы">
					<a href="/admin/attribute?add_attributes=<?php echo $row['attribute_group_id']; ?>"><i class="fi-plus large"></i></a>
			</span>
			<span data-tooltip aria-haspopup="true" class="has-tip" title="Удалить!">
					<a href="/admin/attribute?del_group_attr=<?php echo $row['attribute_group_id']; ?>"><i class="fi-x large"></i></a>
			</span>

		</div>
	</div>
<?php
	
}

if (isset($_GET['edit_group'])) {
	$attribute_group_id = (int)$_GET['edit_group'];
	//echo $attribute_group_id;
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
	$count = mysqli_num_rows($result);
	if ($count>0) {
		echo '<br><form method="post">';
		while ($row = mysqli_fetch_assoc($result)) { ?>
			
			<div class="row">
				<div class="large-8 columns">
					<input type="text" name="attr[<?php echo $row['attribute_id']; ?>][name]" value='<?php echo $row['name']; ?>'>
				</div>
				<div class="large-2 columns">
					<input type="text" name="attr[<?php echo $row['attribute_id']; ?>][sort_order]" value='<?php echo $row['sort_order']; ?>'>
				</div>
				<div class="large-2 columns">
					<span data-tooltip aria-haspopup="true" class="has-tip" title="Удалить!">
						<a href="/admin/attribute?del_attr=<?php echo $row['attribute_id']; ?>"><i class="fi-x large"></i></a>
					</span>
				</div>
			</div>	
			
			
			<?php	
		}
		echo '<input type="hidden" name="attribute_group_id" value="' . $attribute_group_id . '">';
		echo '<input type="submit" name="edit_attr" class="button" value="Изменить">';
		echo '</form>';
	}
}
/**
 * Edit attributes
 */















/**
 * 	Editing group attributes
 */
if (isset($_GET['edit_group_attr'])) {
	$attribute_group_id = (int)$_GET['edit_group_attr'];
	$query = "SELECT * FROM `attribute_group` WHERE `attribute_group_id` = '$attribute_group_id'";
	$result = mysqli_query($db,$query);
	if (mysqli_num_rows($result)>0) { 
		$row = mysqli_fetch_assoc($result);
		?>
	<br>
	<p class="panel">Редактировать группу аттрибутов</p>
	<form method="post" action="/admin/attribute">
		<input type="text" name="name" value="<?php echo $row['name']; ?>">
		<input type="text" name="sort_order" value="<?php echo $row['sort_order']; ?>">
		<input type="hidden" name="attribute_group_id" value="<?php echo $attribute_group_id; ?>">
		<input type="submit" name="edit_group_attr"  class="button" value="Изменить">
	</form>

	<?php }

}
/**
 * 	Editing group attributes
 */



if (isset($_GET['add_group_attr'])) { ?>
<br>
<p class="panel">Добавить группу аттрибутов</p>
<form>
<input type="text" name="attribute_name" placeholder="Название группы">
<input type="text" name="sort_order" placeholder="Порядок сортировки" value="0">
<input type="submit" name="attr_add" class="button" value="Добавить">
</form>
<br>
<?php
}





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
<br>
<p class="panel">Добавить аттрибуты для группы <span style="color:orangered"><?php echo $name; ?></span></p>
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







