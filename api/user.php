<?php

require '../db/Broker.php';

if (!isset($_POST['akcija'])) {
  exit;
}
$akcija = $_POST['akcija'];


if ($akcija == 'get') {
  echo json_encode($broker->loadData("select * FROM user"));
  exit;
}

if ($akcija == 'delete' && isset($_POST['id'])) {
  $id = $_POST['id'];
  echo $broker->persistData("delete FROM user WHERE id=" . $id);
  exit;
}
if ($akcija == 'create') {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  echo $broker->persistData("insert INTO `user`(first_name, last_name, email, phone) VALUES " .
    "('" . $first_name . "','" . $last_name . "','" . $email . "','" . $phone . "')");
  exit;
}
