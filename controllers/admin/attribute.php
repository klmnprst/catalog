<?php
protect_page();
print_arr($_GET);
?>

<p class="panel">Существующие группы аттрибутов:</p>
<?php 
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
	echo '<li>Группа аттрибутов | Сортировка</li>';
while ($row = mysqli_fetch_assoc($result)) {
	echo '<li><a href="/admin/attribute?edit_group=' . $row['attribute_group_id'] . ' ">' . $row['name'] . '</a> | ' . $row['sort_order'] . '</li>';
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
		echo 'ok';
	} else {
		echo 'bad';
	}
}

?>

<p class="panel">Добавить группу аттрибутов</p>
<form>
<input type="text" name="attribute_name" placeholder="Название группы">
<input type="text" name="sort_order" placeholder="Порядок сортировки" value="0">
<input type="submit" name="attr_add" value="Добавить">
</form>