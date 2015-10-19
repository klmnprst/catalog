<?php

/**
 * user_exist проверка существования юзера по имени
 */
function user_exist($username) {
  global $db;

  $username = sanitize($username);
  $query = "SELECT * FROM  `users` WHERE `username` = '$username'";
  $result = mysqli_query($db, $query);
  return (mysqli_num_rows($result) == 1) ? true : false;
}

/**
 * user_active проверка флага active
 */
function user_active($username) {
  global $db;

  $username = sanitize($username);
  $query = "SELECT * FROM  `users` WHERE `username` = '$username' AND `active` = 1";
  $result = mysqli_query($db, $query);
  return (mysqli_num_rows($result) == 1) ? 0 : false;
}
/**
 *user_id_from_username бесполезная херь
 */
function user_id_from_username($username) {
  global $db;

  $username = sanitize($username);
  $query = "SELECT `user_id` FROM  `users` WHERE `username` = '$username'";
  $result = mysqli_query($db, $query);
  return (mysqli_fetch_row($result));
}


/**
 * login returned user_id
 */
function login($username,$password) {
  global $db;
  //$user_id = user_id_from_username($username);
  $username = sanitize($username);
  $password = md5($password);

  $query = "SELECT * FROM  `users` WHERE `username` = '$username' AND `password` = '$password'";
  $result = mysqli_query($db, $query);
  if (mysqli_num_rows($result) == 0) {
    return false;
  } else {
    $row = mysqli_fetch_assoc($result);
    return $row['user_id'] . ',' . $row['first_name'];
  }
  
}

/**
 * logged_in
 */
 function logged_in() {
  return (isset($_SESSION['user_id'])) ? true : false;
 }



 /**
  * output_errors()
  * formating errors
  */
  function output_errors($errors) {
    $output = array();
    foreach ($errors as $error) {
      $output[] = '<li>' . $error . '</li>';
    }
    return '<h2>Возникли следующие ошибки...</h2><ul>' . implode('', $output) . '</ul>';
  }