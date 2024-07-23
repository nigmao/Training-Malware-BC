<?php
include_once(__DIR__ . '\database\sqlFunction.php');
include_once('utility.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$username_session = $_SESSION['username'];
$sql = 'SELECT * FROM users where username = "' . $username_session . '";';
$userList_session = select($sql);
$user_session = $userList_session[0];


$id = $fullname = $username = $password = $email = $phonenumber = $role = $avatar =  '';
$id = '';
$done = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM users where user_id = ' . $id;
    $userList = select($sql);
    $user = $userList[0];
    $full_name = $user['full_name'];
    $user_name = $user['username'];
    $email = $user['email'];
    $phone_number = $user['phone_number'];
    $role_id = $user['role_id'];
    if (!empty($_POST)) {
        $email = $_POST['email'];
        $phone_number = $_POST['phone-number'];
        $sql = 'UPDATE users SET email = "' . $email . '", phone_number = "' . $phone_number . '" WHERE user_id = ' . $id . ';';
        execute($sql);
        header("Location: listUser.php");
    }
} else {
    $id = '';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <a href="admin.php"><button class="btn btn-success">Home</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Edit information</h1>
    </br>
    <form method="post" action="">
        <div class="mb-3">
            <label for="usr" class="form-label">User name: </label>
            <input type="text" class="form-control" name="urs" require="true" value="<?= $user_name ?>" disabled="disabled">
        </div>
        <div class="mb-3">
            <label for="full-name" class="form-label">Full name: </label>
            <input type="text" class="form-control" name="full-name" require="true" value="<?= $full_name ?>" disabled="disabled">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address: </label>
            <input type="email" class="form-control" name="email" require="true" value="<?= $email ?>">
        </div>
        <div class="mb-3">
            <label for="phone-number" class="form-label">Phone number: </label>
            <input type="tel" class="form-control" name="phone-number" require="true" value="<?= $phone_number ?>">
        </div>
        <div class="mb-3">
            <input class="btn btn-success" type="submit" value="Update">
        </div>
    </form>

    </div>
</body>

</html>