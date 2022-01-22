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
}// TODO: dodowanie do grup czlonkow
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
        ?>
        <!--        <h2>Group 1</h2>-->
        <!--        <h2>Project: E-Nurse </h2>-->
        <!--        <h2>Client: Jan Kowalski</h2>-->
    </div>

    <div class="add-project__container">
        <select class="form__input" type="text" placeholder="Member">
            <option value="Jan Kowalski">Jan Kowalski</option>
            <option value="Jan Nowak">Jan Nowak</option>
            <option value="Jan Nowak">Jan Kwiatkowski</option>
        </select>
        <input type="submit" value="Add member"
               class="form__btn btn-primary btn-primary--filled"/>
    </div>

    <div class="projects">
        <h3 class="projects__title">Members</h3>

        <div class="projects__container">
            <div class="projects__row-container projects__header">
                <span>Name</span>
            </div>
            <?php
            require_once "connect.php";

            $sql = "select u.name, u.surname from users u, clocker_db.groups g, members m where g.ID=:g_id and g.ID=m.group_id and u.ID = m.user_id";
            $handle = $pdo->prepare($sql);
            $params = ['g_id' => $_SESSION['g_id']];
            $handle->execute($params);
            if ($handle->rowCount() > 0) {
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $name = $getRow['name'];
                    $surname = $getRow['surname'];
                    echo '<div class="projects__row-container">
                                  <span>' . $name . " " . $surname . '</span>
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