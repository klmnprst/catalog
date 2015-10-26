<?php
protect_page();
?>

<p class="panel">Существующие группы аттрибутов:</p>
<?php 
$query = "SELECT * FROM `attribute_group`";
$result = mysqli_query($db,$query);
while ($row = mysqli_fetch_assoc($result)) {
	echo '<li>' . $row['name'] . '</li>';
}