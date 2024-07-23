<?php
include_once(__DIR__ . '\database\sqlFunction.php');
include_once('utility.php');
session_start();
$username_session = $_SESSION["username"];
$sql = 'SELECT * FROM users where username = "' . $username_session . '";';
$userList_session = select($sql);
$user_session = $userList_session[0];
$id_session = $user_session['user_id'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == $id_session) {
        header("Location: listUser.php");
    } else {
        $sql = 'DELETE FROM users where user_id = ' . $id;
        execute($sql);
        header("Location: listUser.php");
    }
}
