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
    $path = "uploads/teacher/";
    $file = $_FILES['filename'];
    $error = [];

    $filename = $file['name'];
    $splitFileName = explode('.', $filename);
    $ext = end($splitFileName);
    // $new_file = md5(uniqid()).'.'.$ext;

    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'ppt', 'zip', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'php'];
    if (in_array($ext, $allow_ext)) {
        if (file_exists('uploads/teacher/' . $filename)) {
            $error['file_exists_error'];
        } else {
            if (!is_dir($path)) {
                mkdir($path);
            }
            $upload = move_uploaded_file($file['tmp_name'], $path . $filename);
            $title = $_POST['title'];
            $description = $_POST['description'];
            $sql = 'INSERT INTO assignment (title, description, path) VALUES ("' . $title . '", "' . $description . '", "' . $filename . '");';
            execute($sql);
            header("Location: classroom.php");
            if (!$upload) {
                $error[] = 'upload_error';
            }
        }
    } else {
        $error[] = 'ext_error';
    }

    if (!empty($error)) {
        $mess = '';
        if (in_array('ext_error', $error)) {
            $mess = "Invalid file";
        } else if (in_array('file_exists_error', $error)) {
            $mess = "File already exists";
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
    <a href="classroom.php"><button class="btn btn-success">Back</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1>Teacher upload assignment</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description: </label>
            <textarea name="description" id="description" cols="204" rows="10" class="form-control"></textarea>
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