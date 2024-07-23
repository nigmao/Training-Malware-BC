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
$id_session = $user_session['user_id'];
$role_session = $user_session['role_id'];

if (isset($_GET['id'])) {
    $assign_id = $_GET['id'];
    $sql = 'SELECT * FROM assignment where assign_id = "' . $assign_id . '";';
    $assignList = select($sql);
    $assign = $assignList[0];
    $assign_title = $assign['title'];
}

if (isset($_POST['add']) && isset($_FILES['filename'])) {
    $path = "uploads/student/";
    $file = $_FILES['filename'];
    $error = [];

    $filename = $file['name'];
    $splitFileName = explode('.', $filename);
    $ext = end($splitFileName);
    // $new_file = md5(uniqid()).'.'.$ext;

    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'ppt', 'zip', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
    if (in_array($ext, $allow_ext)) {
        $upload = move_uploaded_file($file['tmp_name'], $path . $filename);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = 'INSERT INTO submission (assign_id, student_id ,title, description, path) VALUES ("' . $assign_id . '", "' . $id_session . '", "' . $title . '", "' . $description . '", "' . $filename . '");';
        execute($sql);
        header("Location: submissionAsStudent.php?id=" . $assign_id);
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
    <a href="classroom.php"><button class="btn btn-success">Back</button></a>
    <a href="profile.php"><button class="btn btn-success">Profile</button></a>
    <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
    <h1 style="color:green;text-align:center;">Submission of <strong><?php echo $assign_title; ?></strong> (Student page)</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <br />
        <div class="form-group">
            <label for="filename">File</label>
            <input type="file" class="form-control-file" name="filename">
        </div>
        <br />
        <button type="submit" class="btn btn-primary" name="add">Submit</button>
    </form>
    <h1 class="display-2">Submitted</h1>
    <?php
    $sql = 'SELECT * FROM submission WHERE assign_id = ' . $assign_id . ' AND student_id = ' . $id_session . ';';
    $submisList = select($sql);
    foreach ($submisList as $sub) {
        $down = "uploads/student/" . $sub['path'];
        echo '<div class="mb-3" style="border-radius: 5px;">
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