<?php
include_once(__DIR__ . '\database\sqlFunction.php');
session_start();
$cur_pwd = $old_pwd = $re_pwd = $new_pwd = $username = '';

if (!empty($_POST)) {
    $username = $_SESSION['username'];
    $sql = 'SELECT * FROM users where username = "' . $username . '";';
    $userList = select($sql);
    $user = $userList[0];
    $cur_pwd = $user['password'];
    $old_pwd = md5($_POST['oldpwd']);
    $new_pwd = md5($_POST['newpwd']);
    $re_pwd = md5($_POST['repwd']);
    if ($cur_pwd != $old_pwd) {
?>
        <script>
            alert("Wrong password");
        </script>
    <?php
    } else if ($new_pwd != $re_pwd) {
    ?>
        <script>
            alert("Retype password does not match");
        </script>
<?php
    } else {
        $sql = 'UPDATE users SET password = "' . $new_pwd . '" WHERE username = "' . $username . '";';
        execute($sql);
        header("Location: profile.php");
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <a href="admin.php"><button>Home</button></a>
    <h1>Change password</h1>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Current password: </label>
            <input type="password" class="form-control" name="oldpwd" required>
        </div>
        <div class="mb-3">
            <label class="form-label">New password: </label>
            <input type="password" class="form-control" name="newpwd" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Retype new password: </label>
            <input type="password" class="form-control" name="repwd" required>
        </div>
        <button type="submit" class="btn btn-success">Change</button>
    </form>



</body>

</html>