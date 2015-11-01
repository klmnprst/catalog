<?php 
if (isset($_POST['category_id']) AND !empty($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    foreach ($_FILES as $key => $value) { //перемещение файлов в /img/cat
    //echo $value['tmp_name'];
    $catpath = $_SERVER['DOCUMENT_ROOT'].'/img/cat/'.$category_id; //создаем папку с номером категории если ее еще нет
    if (!is_dir($catpath)) {
        mkdir($catpath);
    }

    $path = $_SERVER['DOCUMENT_ROOT'].'/img/cat/'.$category_id.'/'.$value['name'];
    move_uploaded_file($value['tmp_name'], $path);
    }
    echo 'Картинки залиты';
} else {
    echo 'Не передано category_id';
}