<?php

include './db/Broker.php';

if (!isset($_POST['action'])) {
  exit;
}
$action = $_POST['action'];


if ($action == 'get') {
  echo json_encode($broker->loadData("SELECT * FROM user"));
  exit;
}

if ($action == 'delete' && isset($_POST['id'])) {
  $id = $_POST['id'];
  echo json_encode($broker->persistData("delete FROM user WHERE id=" . $id));
  exit;
}
if ($action == 'create') {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  echo json_encode($broker->persistData("insert INTO `user`(first_name, last_name, email, phone) VALUES " .
    "('" . $first_name . "','" . $last_name . "','" . $email . "','" . $phone . "')"));
  exit;
}
