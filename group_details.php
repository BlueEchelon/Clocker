<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>
<?php
session_start();
if (!isset($_SESSION['g_id'])) {
    $_SESSION['g_id'] = $_GET['G_id'];
}

if (!isset($_SESSION['ID'])) {
    header('Location: index.php');
    exit();
}
?>
<body>
<?php require_once "_navbar_main.php" ?>

<div class="container">
    <div>
        <?php
        require_once "connect.php";

        $sql = "select c.name, g.name as g_name, p.name as p_name from clients c, users u, clocker_db.groups g, 
                                                       projects p where u.ID=c.user_id and g.ID=:g_id and p.client_id=c.ID and p.group_id=g.ID;";
        $handle = $pdo->prepare($sql);
        $params = ['g_id' => $_SESSION['g_id']];
        $handle->execute($params);
        if ($handle->rowCount() > 0) {
            while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                $name = $getRow['name'];
                $g_name = $getRow['g_name'];
                $p_name = $getRow['p_name'];
                echo '
                                  <h2>Group: ' . $g_name . '</h2>
                                  <h2>Project: ' . $p_name . '</h2>
                                  <h2>Client: ' . $name . '</h2>
                                  ';

            }
        }
        if (isset($_POST['Add'])) {
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));
                $sql_g = "SELECT * FROM clocker_db.users WHERE email = :email";
                $handle = $pdo->prepare($sql_g);
                $params = ['email' => $email];
                $handle->execute($params);
                if ($handle->rowCount() > 0) {
                    $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                    $user_id = $getRow['ID'];
                    $group_id = $_SESSION['g_id'];
                    $sql = "insert into clocker_db.members (user_id, group_id) values (:user_id, :group_id)";
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':user_id' => $user_id,
                        ':group_id' => $group_id,
                    ];
                    $handle->execute($params);
                }

            } else {
                if (!isset($_POST['task_name']) || empty($_POST['task_name'])) {
                    $errors[] = 'Task name is required';
                } else {
                    $valName = $_POST['task_name'];
                }
            }
        }
        ?>

    </div>

    <div class="add-project__container">
        <form class="add-project__container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input class="form__input" type="text" name="email" placeholder="Email"
                   value="<?php echo(isset($valName) ? $valName : '') ?>">
            <input type="submit" name="Add" value="Add task"
                   class="form__btn btn-primary btn-primary--filled"/>
        </form>
    </div>

    <div class="projects">
        <h3 class="projects__title">Members</h3>

        <div class="projects__container">
            <div class="projects__row-container projects__header">
                <span>Email</span>
            </div>
            <?php
            require_once "connect.php";

            $sql = "select u.name, u.surname, u.email from users u, clocker_db.groups g, members m where g.ID=:g_id and g.ID=m.group_id and u.ID = m.user_id";
            $handle = $pdo->prepare($sql);
            $params = ['g_id' => $_SESSION['g_id']];
            $handle->execute($params);
            if ($handle->rowCount() > 0) {
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $name = $getRow['name'];
                    $surname = $getRow['surname'];
                    $email = $getRow['email'];
                    echo '<div class="projects__row-container">
                                  <span>' . $email . '</span>
                                  </div>';

                }
            }
            ?>
            <!--            <div class="projects__row-container">-->
            <!--                <span>Jan Kowalski</span>-->
            <!--            </div>-->
            <!--            <div class="projects__row-container">-->
            <!--                <span>Adam Nowak</span>-->
            <!--            </div>-->
            <!--            <div class="projects__row-container">-->
            <!--                <span>Tomasz Hałoń</span>-->
            <!--            </div>-->

        </div>
    </div>
</div>

</body>

</html>