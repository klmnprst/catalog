<?php
protect_page();
?>

<p class="panel">Существующие группы аттрибутов:</p>
<?php 
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
	echo '<li>Группа аттрибутов | Сортировка</li>';
while ($row = mysqli_fetch_assoc($result)) {
	echo '<li><a href="/admin/atrribute?edit_group=' . $row['attribute_group_id'] . ' ">' . $row['name'] . '</a> | ' . $row['sort_order'] . '</li>';
}