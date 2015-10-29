<?php

protect_page();
print_arr($_GET);
print_arr($_POST);
/**
 * TODO: добавить варнинги при удалении
 */
?>



<p class="panel">Существующие категории:</p>
<p><a href="/admin/category?add"  style="color:orangered">Добавить категорию</a></p>
<div class="row"  data-equalizer>
  <div class="large-1 columns" style="background:#e4f7b6" data-equalizer-watch>&nbsp;</div>
  <div class="large-2 columns" style="background:#e4f7b6" data-equalizer-watch>URL</div>
  <div class="large-2 columns" style="background:#d1fc6a" data-equalizer-watch>Имя</div>
  <div class="large-1 columns" style="background:#e4f7b6" data-equalizer-watch>Родитель</div>
  <div class="large-1 columns" style="background:#d1fc6a" data-equalizer-watch>Флаг каталог</div>
  <div class="large-1 columns" style="background:#e4f7b6" data-equalizer-watch>Флаг топ меню</div>
  <div class="large-4 columns" style="background:#d1fc6a" data-equalizer-watch>Title</div>
</div>
<?php

$query = "SELECT * FROM main";
$result = mysqli_query($db,$query);
while ($row = mysqli_fetch_assoc($result)) { ?>


<div class="row">
  
  <div class="large-1 columns">
  	<span data-tooltip aria-haspopup="true" class="has-tip" title="Редактировать категорию">
		<a href="/admin/category?edit_category=<?php echo $row['id']; ?>"><i class="fi-widget large"></i></a>
	</span>
	<span data-tooltip aria-haspopup="true" class="has-tip" title="Удалить категорию">
		<a href="/admin/category?del_category=<?php echo $row['id']; ?>"><i class="fi-x large"></i></a>
	</span>

  </div>

  <div class="large-2 columns"><?php echo $row['url']; ?></div>
  <div class="large-2 columns"><?php echo $row['name']; ?></div>
  <div class="large-2 columns"><?php echo $row['parent_id']; ?></div>
  <div class="large-1 columns"><?php echo $row['catalog']; ?></div>
  <div class="large-1 columns"><?php echo $row['top_menu']; ?></div>
  <div class="large-4 columns"><?php echo $row['title']; ?></div>
</div>




<?php } 