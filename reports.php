<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php";
if (!isset($_SESSION['ID'])) {
    header('Location: index.php');
    exit();
}
?>

<body>
<?php require_once "_navbar_main.php" ?>

Reports
<?php
require_once "connect.php";

?>
<form class="add-project__container" method="post" action="create_csv.php">
    <!--      <input class="form__input" type="text" name="task_name" placeholder="Task name"-->
    <!--             value="--><?php //echo (isset($valName) ? $valName : '') ?><!--">-->
    <!--      <input class="form__input" type="text" name="description" placeholder="Description"-->
    <!--             value="--><?php //echo(isset($valName) ? $valName : '') ?><!--">-->
    <input type="submit" name="Add" value="Download raport"
           class="form__btn btn-primary btn-primary--filled"/>
</form>
</body>

</html>