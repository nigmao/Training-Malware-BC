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

if (isset($_GET['id'])) {
    $assign_id = $_GET['id'];
    $sql = 'SELECT * FROM assignment where assign_id = "' . $assign_id . '";';
    $assignList = select($sql);
    $assign = $assignList[0];
    $assign_title = $assign['title'];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <a href="classroom.php"><button class="btn btn-success">Back</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Submitted of <strong><?php echo $assign_title; ?></strong> (Teacher page)</h1>
    <?php
    $sql = 'SELECT * FROM submission WHERE assign_id = ' . $assign_id . ';';
    $submisList = select($sql);
    foreach ($submisList as $sub) {
        $cur_student = $sub['student_id'];
        $sql = 'SELECT * FROM users WHERE user_id = ' . $cur_student . ';';
        $studentList = select($sql);
        $astudent = $studentList[0];
        $cur_fullname = $astudent['full_name'];
        $down = "uploads/student/" . $sub['path'];
        echo '<div class="mb-3" style="border-radius: 5px;">
                <h9>From <strong>' . $cur_fullname . '</strong></h9>
                <h5 class="">' . $sub['title'] . '
                <small class="text-muted">' . $sub['created_at'] . '</small>
                </h5>
                
                <label for="des" class="form-label">Description: </label>
                <br/>
                <textarea rows="5" cols="75" id="des" disabled>' . $sub['description'] . '</textarea>
                <br/>
                <td><a href="' . $down . '"><button class="btn btn-warning">Download</button></a></td>';
        echo '<hr/>
                </div>';
    }
    ?>
</body>

</html>