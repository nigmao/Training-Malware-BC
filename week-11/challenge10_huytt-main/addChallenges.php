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

//////////////////////////////////////////////////////////////////////////////

if (isset($_POST['add']) && isset($_FILES['filename'])) {
    $path = "uploads/challenges/";
    $file = $_FILES['filename'];
    $error = [];

    $filename = $file['name'];
    $splitFileName = explode('.', $filename);
    $ext = end($splitFileName);
    // $new_file = md5(uniqid()).'.'.$ext;

    $allow_ext = ['txt'];
    if (in_array($ext, $allow_ext)) {
        $upload = move_uploaded_file($file['tmp_name'], $path . $filename);
        $title = $_POST['title'];
        $hint = $_POST['hint'];
        $sql = 'INSERT INTO challenges (title, hint, path) VALUES ("' . $title . '", "' . $hint . '", "' . $filename . '");';
        execute($sql);
        header("Location: challenges.php");
        if (!$upload) {
            $error[] = 'upload_error';
        }
    } else {
        $error[] = 'ext_error';
    }

    if (!empty($error)) {
        $mess = '';
        if (in_array('ext_error', $error)) {
            $mess = "Invalid file";
        } else {
            $mess = "Something is wrong";
        }
        if (!empty($mess)) {
?>
            <script>
                alert("<?php echo $mess; ?>");
            </script>
<?php
        }
    }
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
    <h1>Create challenges</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="hint">Hint: </label>
            <textarea name="hint" id="hint" cols="204" rows="10" class="form-control" placeholder="Ví Dụ: con meo la con gi ?"></textarea>
        </div>
        <br />
        <div class="form-group">
            <label for="filename">File</label>
            <input type="file" class="form-control-file" name="filename">
        </div>
        <br />
        <button type="submit" class="btn btn-primary" name="add">Add</button>
    </form>

</body>

</html>