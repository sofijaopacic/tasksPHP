<?php

include './db/Broker.php';

if (!isset($_POST['action'])) {
  exit;
}
$action = $_POST['action'];
if ($action == 'get') {
  $query = "select * FROM task inner i join user u on i.user_id = u.id";
  if (isset($_POST["search"])) {
    $query = $query . " WHERE i.title LIKE '%" . $_POST["search"] . "%'";
  }
  echo json_encode($broker->loadData($query));
  exit;
}

if ($action == 'delete' && isset($_POST['id'])) {
  $id = $_POST['id'];
  echo json_encode($broker->persistData("delete FROM task WHERE id=" . $id));
  exit;
}
if ($action == 'create') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $due_date = $_POST['due_date'];
  $user_id = $_POST['user_id'];
  echo json_encode($broker->persistData("insert INTO `task`(title, description, due_date, user_id) VALUES " .
    "('" . $title . "','" . $description . "','" . $due_date . "'," . $user_id . ")"));
  exit;
}

if ($action == 'update' && isset($_POST['id'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $due_date = $_POST['due_date'];
  $user_id = $_POST['user_id'];
  $query = "update task set title= '" . $title . "', description='" . $description . "', due_date='" .
    $due_date . "', user_id=" . $user_id . " WHERE id=" . $id;
  echo json_encode($broker->persistData($query));
}
