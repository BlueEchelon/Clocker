<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>
<?php
session_start();
unset($_SESSION['g_id']);
if (!isset($_SESSION['ID'])) {
    header('Location: index.php');
    exit();
}
function debug_to_console($data)
{ //debug_to_console("TEST2");
    $output = $data;
    if (is_array($output)) $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
require_once "connect.php";
if (isset($_POST['submit_group'])) {
    if (isset($_POST['group_name'], $_POST['project_name']) && !empty($_POST['group_name']) && !empty($_POST['project_name'])) {
        $g_name = trim(filter_var($_POST['group_name'], FILTER_SANITIZE_STRING));
        $p_name = trim(filter_var($_POST['project_name'], FILTER_SANITIZE_STRING));
        debug_to_console($p_name);
        $sql_g = "SELECT * FROM clocker_db.groups WHERE name = :g_name";
        $handle = $pdo->prepare($sql_g);
        $params = ['g_name' => $g_name];
        $handle->execute($params);
        if ($handle->rowCount() == 0) {
            $sql = "insert into clocker_db.groups (name) values(:g_name)";
            try {
                $handle = $pdo->prepare($sql);
                $handle->execute($params);
                $handle = $pdo->prepare($sql_g);
                $params = ['g_name' => $g_name];
                $handle->execute($params);
                if ($handle->rowCount() > 0) {
                    $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                    $g_id = $getRow['ID'];

                    $sql = "insert into members (user_id, group_id) values (:user_id, :g_id)";
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':user_id' => $_SESSION['ID'],
                        ':g_id' => $g_id,
                    ];
                    $handle->execute($params);

                    $sql_get_project_id = "select * from projects where user_id=:u_id and name=:p_name";
                    $handle = $pdo->prepare($sql_get_project_id);
                    $params = [
                        ':u_id' => $_SESSION['ID'],
                        ':p_name' => $p_name,
                    ];
                    $handle->execute($params);
                    if ($handle->rowCount()>0) {
                        $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                        $p_id = $getRow['ID'];

                        $sql_p = "update projects set group_id=:g_id where ID=:p_id";
                        $handle = $pdo->prepare($sql_p);
                        debug_to_console($p_id);
                        $params = [
                            ':g_id' => $g_id,
                            ':p_id' =>$p_id
                        ];
                        $handle->execute($params);
                    }
                }
            } catch (PDOException $e) {
                $errors[] = $e->getMessage();
            }
        } else {
            $errors[] = 'Group name already exists';
        }
    }
}
?>
<body>
<?php require_once "_navbar_main.php" ?>

<div class="container">
    <form class="add-project__container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input class="form__input" name="group_name" type="text" placeholder="Group name">
        <select class="form__input" name="project_name" type="text" placeholder="Project">
            <?php
            require_once "connect.php";
            $id = $_SESSION['ID'];
            $sql = "select name from projects where user_id=:id";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $id];
            $handle->execute($params);

            if ($handle->rowCount() > 0) {
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $name = $getRow['name'];
                    echo '<option value=' . $name . '>' . $name . '</option>';
                }
            }
            ?>
            <!--            <option value="Project 1">Project 1</option>-->
            <!--            <option value="Project 2">Project 2</option>-->
            <!--            <option value="Project 3">Project 3</option>-->
        </select>

        <input type="submit" name="submit_group" value="Add group"

               class="form__btn btn-primary btn-primary--filled"/>
    </form>

    <div class="projects">
        <h3 class="projects__title">Your groups</h3>

        <div class="projects__container">
            <div class="projects__row-container projects__header">
                <span>Title</span>
                <span>Number of members</span>
            </div>
            <?php
            require_once "connect.php";

            $id = $_SESSION['ID'];
            $sql = "select * from clocker_db.groups g, members m where g.ID=m.group_id and user_id=:id";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $id];
            $handle->execute($params);
            if ($handle->rowCount() > 0) {
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $name = $getRow['name'];
                    $group_id = $getRow['group_id'];

                    $prepare = "select count(*) as Licznik from clocker_db.groups g,
                     members m where g.ID=m.group_id and g.ID=:group_id";
                    $hand = $pdo->prepare($prepare);
                    $param = ['group_id' => $group_id];
                    $hand->execute($param);
                    $counter = $hand->fetch(PDO::FETCH_ASSOC);

                    echo '<div class="projects__row-container">
                                  <span>' . $name . '</span>
                                  <span>' . $counter['Licznik'] . '</span>
                                  <a href="group_details.php?G_id=' . $group_id . '"
                                    class="details btn-primary--filled">Details</a>
                                  </div>';
                }
            }
            ?>
            <!--        <div class="projects__row-container">-->
            <!--          <span>Group 1</span>-->
            <!--          <span>69</span>-->
            <!--          <a href="group_details.php"-->
            <!--            class="details btn-primary--filled">Details</a>-->
            <!--        </div>-->
            <!--        <div class="projects__row-container">-->
            <!--          <span>Group 2</span>-->
            <!--          <span>69</span>-->
            <!--          <a href="group_details.php"-->
            <!--            class="details btn-primary--filled">Details</a>-->
            <!--        </div>-->
            <!--        <div class="projects__row-container">-->
            <!--          <span>Group 3</span>-->
            <!--          <span>69</span>-->
            <!--          <a href="group_details.php"-->
            <!--            class="details btn-primary--filled">Details</a>-->
            <!--        </div>-->

        </div>
    </div>
</body>

</html>