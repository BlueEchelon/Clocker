<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>
<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header('Location: index.php');
    exit();
}
?>
<body>
<?php require_once "_navbar_main.php" ?>

<div class="container">
    <div class="add-project__container">
        <input class="form__input" type="text" placeholder="Group name">
        <select class="form__input" type="text" placeholder="Project">
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
                    echo '<option value='. $name .'>'. $name. '</option>';
              }
            }
            ?>
<!--            <option value="Project 1">Project 1</option>-->
<!--            <option value="Project 2">Project 2</option>-->
<!--            <option value="Project 3">Project 3</option>-->
        </select>
        <input type="submit" value="Add group"

               class="form__btn btn-primary btn-primary--filled"/>
    </div>

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
                                  <a href="groups_details.php?id=' . $group_id . '"
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