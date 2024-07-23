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

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Classroom</title>
</head>

<body>
    <div>

        <a href="admin.php"><button class="btn btn-success">Home</button></a>
        <a href="profile.php"><button class="btn btn-success">Profile</button></a>
        <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
        <div class="panel panel-primary">
            <div class="panel-heading">
                </br>
                <h1>Information of student and teacher</h1>
                </br>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM Users";
                        $userList = select($sql);

                        foreach ($userList as $urs) {
                            $role;
                            if ($urs['role_id'] == 2) $role = "Teacher";
                            else if ($urs['role_id'] == 1) $role = "Student";
                            echo '<tr>
        <td>' . $urs['user_id'] . '</td>
        <td>' . $urs['full_name'] . '</td>
        <td>' . $urs['username'] . '</td>
        <td>' . $urs['email'] . '</td>
        <td>' . $urs['phone_number'] . '</td>
        <td>' . $role . '</td>';

                            if ($role_session == 2) {
                                echo '<td><a href="editUser.php?id=' . $urs['user_id'] . '"><button class="btn btn-warning">Edit</button></a></td>
        <td><a href="deleteUser.php?id=' . $urs['user_id'] . '"><button class="btn btn-danger">Delete</button></a></td>';
                            }
                            if ($id_session != $urs['user_id']) {
                                echo '<td><a href="messenger.php?toid=' . $urs['user_id'] . '&fromid=' . $id_session . '"><button class="btn btn-primary">Chat</button></a></td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            if ($role_session == 2) {
                echo '<a href="addStudent.php"><button class="btn btn-primary">Add student</button></a>';
            }
            ?>
        </div>
    </div>
</body>

</html>