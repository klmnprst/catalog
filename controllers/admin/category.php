<?php

protect_page();
print_arr($_GET);
print_arr($_POST);
/**
 * TODO: добавить варнинги при удалении
 */

#########################################################
###                 ACTION PLACE                      ###
#########################################################


//edit category
if (isset($_GET['edit_category'])) {
  $id = (int)$_GET['edit_category'];
  $query = "SELECT * FROM `main` WHERE `id` = '$id'";
  $result = mysqli_query($db,$query);
  $row = mysqli_fetch_assoc($result);
  $parent_id = $row['parent_id'];
}
?>
<form>
  URL<br>
  <input type="text" value="<?php echo $row['url']; ?>">
  Name<br>
  <input type="text" value="<?php echo $row['name']; ?>">
  Catalog?<br>
  <input type="text" value="<?php echo $row['catalog']; ?>">
  Top menu?<br>
  <input type="text" value="<?php echo $row['top_menu']; ?>">
  Parent_id<br>


  <select name="parent_id">
  <?php 
  $query = "SELECT `id`,`name`,`parent_id` FROM `main` WHERE `id` <> '$id'";
  $result = mysqli_query($db,$query);
  while ($row2 = mysqli_fetch_assoc($result)) { 
    if ($row2['id'] == $parent_id) { ?>
      <option selected value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
  <?php  } else { ?>
    <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
  <?php  } } ?>
  </select>



  Keywords<br>
  <input type="text" value="<?php echo $row['keywords']; ?>">
  Description<br>
  <input type="text" value="<?php echo $row['description']; ?>">
  Title<br>
  <input type="text" value="<?php echo $row['title']; ?>">
  Page text<br>
  <textarea style="height:100px;"><?php echo $row['pagetext']; ?></textarea>
  <input type="hidden" value="<?php echo $id; ?>">
  <input type="submit" name="cat_change" class="button" value="Изменить">
</form>



<?php
#########################################################
###                 ACTION PLACE                      ###
#########################################################
?>



<p class="panel">Существующие категории:</p>
<p><a href="/admin/category?add"  style="color:orangered">Добавить категорию</a></p>


<table>
  <thead>
    <tr>
      <th width="70px;">&nbsp;</th>
      <th>URL</th>
      <th>Имя</th>
      <th>Родитель</th>
      <th>Каталог?</th>
      <th>Топ меню?</th>
      <th>Title</th>
    </tr>
  </thead>
  <tbody>


<?php

$query = "SELECT * FROM main";
$result = mysqli_query($db,$query);
while ($row = mysqli_fetch_assoc($result)) { ?>


    <tr>
      <td>
        <span data-tooltip aria-haspopup="true" class="has-tip" title="Редактировать категорию">
          <a href="/admin/category?edit_category=<?php echo $row['id']; ?>"><i class="fi-widget large"></i></a>
        </span>
        <span data-tooltip aria-haspopup="true" class="has-tip" title="Удалить категорию">
          <a href="/admin/category?del_category=<?php echo $row['id']; ?>"><i class="fi-x large"></i></a>
        </span>
      </td>
      <td><?php echo $row['url']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['parent_id']; ?></td>
      <td><?php echo $row['catalog']; ?></td>
      <td><?php echo $row['top_menu']; ?></td>
      <td><?php echo $row['title']; ?></td>
    </tr>





<?php } ?>

  </tbody>
</table>