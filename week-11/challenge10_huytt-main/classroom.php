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
        echo '<td><a href="addAssignment.php"><button class="btn btn-success">Add Assignment </button></a></td>';
    }
    ?>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Assignment Management</h1>
    <?php
    $sql = "SELECT * FROM assignment";
    $assignList = select($sql);
    foreach ($assignList as $ass) {
        if ($ass['path'] == '') {
            echo "<p>Not found file</p>";
        }
        $down = "uploads/teacher/" . $ass['path'];
        echo '<div class="mb-3" style="border-radius: 5px;">
            <h5 class="">' . $ass['title'] . '
            <small class="text-muted">' . $ass['created_at'] . '</small>
            </h5>
            <label for="des" class="form-label">Description: </label>
            <br/>
            <textarea rows="5" cols="75" id="des" disabled>' . $ass['description'] . '</textarea>
            <br/>
            <td><a href="' . $down . '"><button class="btn btn-warning">Download</button></a></td>';
        if ($role_session == 1) {
            echo '<td><a href="submissionAsStudent.php?id=' . $ass['assign_id'] . '"><button class="btn btn-primary">Submission</button></a></td>';
        } else {
            echo '<td><a href="submissionAsTeacher.php?id=' . $ass['assign_id'] . '"><button class="btn btn-primary">Submission</button></a></td>';
        }
        echo '<hr/>
            </div>';
    }
    ?>

</body>

</html>