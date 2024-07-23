<?php
include_once(__DIR__ . '\database\sqlFunction.php');
session_start();
$id = $fullname = $username = $password = $email = $phonenumber = $role = '';
$username = $_SESSION['username'];
if (!isset($username)) {
    header("Location: index.php");
}
$sql = 'SELECT * FROM users where username = "' . $username . '";';
$userList = select($sql);
$user = $userList[0];
$id = $user['user_id'];
$fullname = $user['full_name'];
$email = $user['email'];
$phonenumber = $user['phone_number'];
$role = $user['role_id'];
if (!empty($_POST)) {
    $email = $_POST['email'];
    $phone_number = $_POST['phone-number'];
    $sql = 'UPDATE users SET email = "' . $email . '", phone_number = "' . $phone_number . '" WHERE user_id = ' . $id . ';';
    execute($sql);
    header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>

    <div>
        <div>
            <a href="admin.php"><button>Home</button></a>
            <a href="profile.php"><button>Profile</button></a>
            <a href="logout.php"><button>Log out</button></a>
        </div>
        <h1>Profile</h1>

        <form method="post" action="">
            <div>
                <label for="usr" class="form-label">User name: </label>
                <input type="text" class="form-control" name="urs" value="<?php echo $username; ?>" disabled>
            </div>
            <div>
                <label for="full-name" class="form-label">Full name: </label>
                <input type="text" class="form-control" name="full-name" value="<?php echo $fullname; ?>" disabled>
            </div>
            <div>
                <label for="email" class="form-label">Email address: </label>
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
            </div>
            <div>
                <label for="phone-number" class="form-label">Phone number: </label>
                <input type="tel" class="form-control" name="phone-number" value="<?php echo $phonenumber; ?>">
            </div>
            <div>
                <label for="role" class="form-label">ROLE: </label>
                <input type="selection" class="form-control" name="role" disabled value="<?php if ($role == 1) {
                                                                                                echo "Student";
                                                                                            } else {
                                                                                                echo "Teacher";
                                                                                            } ?>">
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="Update">
            </div>
            <div>
                <!-- <input type="password" class="form-control" name="pwd" value="<?php echo $password; ?>"> -->
                <a href="changePwd.php" class="link-success">Change Password</a>
            </div>
        </form>
    </div>
</body>

</html>