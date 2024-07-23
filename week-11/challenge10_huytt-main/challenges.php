<?php
include_once(__DIR__ . '\database\sqlFunction.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$username_session = $_SESSION['username'];
$sql = 'SELECT * FROM users where username = "' . $username_session . '";';
$userList_session = select($sql);
$user_session = $userList_session[0];
$role_session = $user_session['role_id'];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <a href="admin.php"><button class="btn btn-success">Home</button></a>
    <?php
    if ($role_session == 2) {
        echo '<td><a href="addChallenges.php"><button class="btn btn-success">Add Challenges</button></a></td>';
    }
    ?>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Challenges</h1>
    <?php
    if ($role_session == 2) {
        $sql = "SELECT * FROM challenges";
        $chalList = select($sql);
        foreach ($chalList as $chal) {
            $down = "uploads/challenges/" . $chal['path'];
            echo '<div class="mb-3" style="border-radius: 5px;">
                <h5 class="">' . $chal['title'] . '
                </h5>
                <label for="des" class="form-label">HINT: </label>
                <br/>
                <textarea rows="5" cols="75" id="des" disabled>' . $chal['hint'] . '</textarea>
                <br/>
                <hr/>
                </div>';
        }
    } else if ($role_session == 1) {
        $sql = "SELECT * FROM challenges";
        $chalList = select($sql);
        foreach ($chalList as $chal) {
            echo '<div class="mb-3" style="border-radius: 5px;">
                <h5 class="">' . $chal['title'] . '
                </h5>
                <label for="des" class="form-label">HINT: </label>
                <br/>
                <textarea rows="5" cols="75" id="des" disabled>' . $chal['hint'] . '</textarea>
                <br/>
                <a href="answer.php?id=' . $chal['challenges_id'] . '"><button class="btn btn-success">Answer</button></a>
                <hr/>
                </div>';
        }
    }
    ?>
</body>

</html>