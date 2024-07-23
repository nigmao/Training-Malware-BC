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

$title = $hint = $path = '';

$result = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM challenges where challenges_id = ' . $id;
    $chalList = select($sql);
    $chal = $chalList[0];
    $title = $chal['title'];
    $hint = $chal['hint'];
    $path = $chal['path'];

    $testVar = explode(".", $path);
    $result = $testVar[0];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <a href="challenges.php"><button class="btn btn-success">Back</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Answer the question</h1>
    <form method="post" action="">
        <div class="mb-3">
            <h1><small>Title: </small><strong><?= $title ?></strong></h1>
        </div>
        <div class="mb-3">
            <label for="hint" class="form-label">HINT: </label>
            <br />
            <textarea rows="5" cols="90" disabled><?= $hint ?></textarea>
        </div>
        <div class="form-group">
            <label for="ans">Enter: </label>
            <input type="text" class="form-control" name="ans">
        </div>
        <br />
        <div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Answer" name="submit">
        </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $ans = trim($_POST['ans'], ' ');
        if ($ans == $result) {
            $filename = 'uploads/challenges/' . $path;
            $fp = fopen($filename, "r");

            $contents = fread($fp, filesize($filename));

            echo "<pre>$contents</pre>";
            fclose($fp);
        } else {
    ?>
            <script>
                alert("Wrong answer!!!");
            </script>
    <?php
        }
    }
    ?>
</body>

</html>