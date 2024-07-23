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
$id_session = $user_session['user_id'];

$fromid = $toid = '';

if (isset($_GET['fromid']) && isset($_GET['toid'])) {
    $fromid = $_GET['fromid'];
    $toid = $_GET['toid'];
}
if (isset($_POST['submit'])) {
    $content = $_POST['content_message'];
    $sql = 'INSERT INTO messenger (from_id, to_id, content) VALUES (' . $fromid . ', ' . $toid . ', "' . $content . '");';
    execute($sql);
    header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    die;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <div>
        <a href="listUser.php"><button class="btn btn-success">Back</button></a>
        <a href="profile.php"><button class="btn btn-success">Profile</button></a>
        <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
        <h1>Box Chat</h1>

        <?php
        $sql = 'SELECT * FROM messenger WHERE (from_id = ' . $fromid . ' AND to_id = ' . $toid . ') OR (from_id = ' . $toid . ' AND to_id = ' . $fromid . ');';
        $messList = select($sql);
        foreach ($messList as $mess) {
            $sql = 'SELECT full_name FROM users where user_id = ' . $mess['from_id'] . ';';
            $fromFullName = select($sql)[0]['full_name'];
            if ($id_session == $mess['to_id']) {
                echo '<div class="media w-50 mb-3">
                    <div class="media-body ml-3">
                        <label class="small text-muted">From ' . $fromFullName . ':</label>
                        <div class="bg-light rounded py-2 px-3 mb-2">    
                            <p class="text-small mb-0 text-muted">' . $mess['content'] . '</p>
                        </div>
                        <p class="small text-muted">' . $mess['created_at'] . '</p>
                    </div>
                </div>';
            } else if ($id_session == $mess['from_id']) {
                echo '<div class="media w-50 ml-auto mb-3">
                    <div class="media-body">
                        <div class="bg-primary rounded py-2 px-3 mb-2">
                            <p class="text-small mb-0 text-white">' . $mess['content'] . '</p>
                        </div>
                        <p class="small text-muted">' . $mess['created_at'] . '</p>
                    </div>
                </div>';
            }
        }
        ?>
        <form action="" class="bg-light" method="POST">
            <div class="input-group">
                <input type="text" placeholder="Type a message" required name="content_message" class="form-control rounded-0 border-0 py-3 bg-light">
                <button class="btn btn-primary" type="submit" name="submit">Send</button>
            </div>
        </form>
</body>

</html>