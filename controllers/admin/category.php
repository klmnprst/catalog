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














#################################################
#               add  category                   #
#################################################
if (isset($_POST['cat_add'])) {
  $url = sanitize($_POST['url']);
  $name = sanitize($_POST['name']);
  $catalog = isset($_POST['catalog']) ? '1' : '0';
  $top_menu = isset($_POST['top_menu']) ? '1' : '0';
  $parent_id = sanitize($_POST['parent_id']);
  $keywords = sanitize($_POST['keywords']);
  $description = sanitize($_POST['description']);
  $title = sanitize($_POST['title']);
  $pagetext = sanitize($_POST['pagetext']);
  $time = time();

  $query = "INSERT INTO main (`url`,`name`,`catalog`,`top_menu`,`parent_id`,`keywords`,`description`,`title`,`pagetext`,`time`) 
  VALUES ('$url','$name','$catalog','$top_menu','$parent_id','$keywords','$description','$title','$pagetext','$time')";
  $result = mysqli_query($db,$query);
  if ($result) {
    header("Location: /admin/category");
    exit();
  }
}


if (isset($_GET['add'])) { ?>
  
<form method="post">
  URL<br>
  <input type="text" name="url" required>
  Name<br>
  <input type="text" name="name" required>
  <input type="checkbox" name="catalog" value="1" /> Catalog
  <input type="checkbox" name="top_menu" value="1" /> Top menu<br />
  Parent_id<br>
  <select name="parent_id">
  <?php 
  $query = "SELECT `id`,`name`,`parent_id` FROM `main` WHERE `id` <> '$id'";
  $result = mysqli_query($db,$query);
  while ($row2 = mysqli_fetch_assoc($result)) { ?>
  <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
  <?php  }  ?>
  </select>
  Keywords<br>
  <input type="text" name="keywords">
  Description<br>
  <input type="text" name="description">
  Title<br>
  <input type="text" name="title" required>
  Page text<br>
  <textarea name="pagetext" style="height:100px;"></textarea>
  <input type="submit" name="cat_add" class="button" value="Добавить">
  <br />
</form>

<?php }
#################################################
#               add  category                   #
#################################################













#################################################
#               edit category                   #
#################################################
if (isset($_POST['cat_change'])) {
  $id           = (int)$_POST['cat_id'];
  $url          = sanitize($_POST['url']);
  $name         = sanitize($_POST['name']);
  $catalog      = isset($_POST['catalog']) ? '1' : '0';
  $top_menu     = isset($_POST['top_menu']) ? '1' : '0';
  $parent_id    = (int)$_POST['parent_id'];
  $keywords     = sanitize($_POST['keywords']);
  $description  = sanitize($_POST['description']);
  $title        = sanitize($_POST['title']);
  $pagetext     = sanitize($_POST['pagetext']);
  $time         = time();

  $query = "UPDATE `main` SET 
  `url`         ='$url', 
  `name`        ='$name', 
  `catalog`     ='$catalog',
  `top_menu`    ='$top_menu', 
  `parent_id`   ='$parent_id', 
  `keywords`    ='$keywords',
  `description` ='$description',
  `title`       ='$title',
  `pagetext`    ='$pagetext',
  `time`        ='$time'
  WHERE `id`    = '$id'";
  //echo $query;
  $result = mysqli_query($db,$query);
  if ($result) {
    header("Location: /admin/category?edit_category=$id");
    exit();
  }
}










if (isset($_GET['edit_category'])) {
  $id = (int)$_GET['edit_category'];
  $query = "SELECT * FROM `main` WHERE `id` = '$id'";
  $result = mysqli_query($db,$query);
  $row = mysqli_fetch_assoc($result);
  $parent_id = $row['parent_id'];

?>
<form method="post" action="/admin/category">
  URL<br>
  <input type="text" name="url" value="<?php echo $row['url']; ?>">
  Name<br>
  <input type="text" name="name" value="<?php echo $row['name']; ?>">
  Catalog 
  <input type="checkbox" name="catalog" <?php echo $row['catalog']==='1' ? 'checked' : ''; ?>>
  Top menu
  <input type="checkbox" name="top_menu" <?php echo $row['top_menu']==='1' ? 'checked' : ''; ?>><br>
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
  <input type="text" name="keywords" value="<?php echo $row['keywords']; ?>">
  Description<br>
  <input type="text" name="description" value="<?php echo $row['description']; ?>">
  Title<br>
  <input type="text" name="title" value="<?php echo $row['title']; ?>">
  Page text<br>
  <textarea name="pagetext" style="height:100px;"><?php echo $row['pagetext']; ?></textarea>
  <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $id; ?>">
  <input type="submit" name="cat_change" class="button" value="Изменить">
  <input type="file" name="file" id="file">
  <div id="info2"></div>
  <div id="preloader" style="display: none;"><img src="/template/img/preloader.gif" alt="loader"></div>
    <br />
</form>

<?php  }
#################################################
#               edit category                   #
#################################################













#################################################
#                del category                   #
#################################################
if (isset($_GET['del_category'])) {
  $id = (int)$_GET['del_category'];
  $query = "DELETE FROM `main` WHERE `id` = '$id'";
  $result = mysqli_query($db,$query);
  if ($result) {
    header("Location: /admin/category");
    exit();
  }
}
#################################################
#                del category                   #
#################################################






#########################################################
###                 ACTION PLACE                      ###
#########################################################
?>






































<?php 
#########################################################
###               CATEGORY LIST                       ###
#########################################################

if (empty($_GET) && empty($_POST)) { ?>
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
          <a href="/admin/category?del_category=<?php echo $row['id']; ?>"  onclick="return confirm('Уверены?')"><i class="fi-x large"></i></a>
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

<?php 
#########################################################
###               CATEGORY LIST                       ###
#########################################################
} ?>











<!-- for download pics -->
<script>
$(document).ready(function(){
    $('#file').bind('change', function(){
    var category_id = $('#cat_id').val();
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