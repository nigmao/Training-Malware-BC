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

$full_name = $username = $password = $email = $phonenumber = $role = '';
if (!empty($_POST)) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $role  = $_POST['role'];

    if ($full_name != '' && $password != '' && $email != '' && $username != '' && $phonenumber != '' && $role != '') {
        //save user into database
        $password = md5($password);
        $sql = "insert into users (full_name, username, password, email, phone_number, avatar, role_id) values ('$full_name','$username' , '$password', '$email', '$phonenumber', 'avatardefault.jpg','$role')";
        execute($sql);
        header('Location: listUser.php');
    }
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    </br>
    <a href="listUser.php"><button class="btn btn-success">Back</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Add Student Page</h1>
    <form method="POST" action="">
        <div>
            <label for="usr" class="form-label">User name: </label>
            <input type="text" class="form-control" id="urs" required name="username">
        </div>
        <div>
            <label for="pwd" class="form-label">Password: </label>
            <input type="password" class="form-control" id="pwd" required name="password">
        </div>
        <div>
            <label for="fullname" class="form-label">Full name: </label>
            <input type="text" class="form-control" id="fullname" required name="full_name">
        </div>
        <div>
            <label for="email" class="form-label">Email: </label>
            <input type="email" class="form-control" id="email" required name="email">
        </div>
        <div>
            <label for="phone_number" class="form-label">Phone number: </label>
            <input type="text" class="form-control" id="phone_number" required name="phonenumber">
        </div>
        <div>
            <label for="role" class="form-label">Role:</label>
            <select name="role" id="role" class="form-select">
                <option value="2"></option>
                <option value="1">Student</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>
</body>

</html>