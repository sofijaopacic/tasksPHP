<?php

require '../db/Broker.php';

if (!isset($_POST['akcija'])) {
  exit;
}
$akcija = $_POST['akcija'];
if ($akcija == 'get') {
  $query = "select * FROM task t inner join user u on t.user_id = u.id";
  if (isset($_POST["pretraga"])) {
    $query = $query . " WHERE t.title LIKE '%" . $_POST["pretraga"] . "%'";
  }
  echo json_encode($broker->loadData($query));
  exit;
}

if ($akcija == 'one' && isset($_POST['id'])) {
  $id = $_POST['id'];
  $query = "select * FROM task where id =" . $id;
  echo json_encode($broker->loadData($query));
  exit;
}

if ($akcija == 'delete' && isset($_POST['id'])) {
  $id = $_POST['id'];
  echo $broker->persistData("delete FROM task WHERE id=" . $id);
  exit;
}
if ($akcija == 'create') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $due_date = $_POST['due_date'];
  $user_id = $_POST['user_id'];
  echo $broker->persistData("insert INTO `task`(title, description, due_date, user_id) VALUES " .
    "('" . $title . "','" . $description . "','" . $due_date . "'," . $user_id . ")");
  exit;
}

if ($akcija == 'update' && isset($_POST['id'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $due_date = $_POST['due_date'];
  $user_id = $_POST['user_id'];
  $query = "update task set title= '" . $title . "', description='" . $description . "', due_date='" .
    $due_date . "', user_id=" . $user_id . " WHERE id=" . $id;
  echo $broker->persistData($query);
}
