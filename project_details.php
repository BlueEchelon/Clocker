<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$_SESSION['p_id']=$_GET['id'];
if(!isset($_SESSION['ID']))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$id = $_SESSION['p_id'];
$sql = "SELECT p.ID FROM projects as p WHERE p.ID=:id ";
$handle = $pdo->prepare($sql);
$params = ['id' => $id];
$handle->execute($params);
if($handle->rowCount()>0){
    $getRow = $handle->fetch(PDO::FETCH_ASSOC);
    $p_id=$getRow['ID'];
    if($p_id!=$_SESSION['p_id']){
        unset($_SESSION['p_id']);
        header('Location: projects.php');
        exit();
    }
}
else{
    unset($_SESSION['p_id']);
    header('Location: projects.php');
    exit();
}

?>
<?php require_once "_head.php" ?>

<body>
  <?php require_once "_navbar_main.php" ?>

  <div class="container">
    <div>
      <h2>
          <?php
          require_once "connect.php";
          $id = $_SESSION['p_id'];
          $sql = "SELECT p.name   FROM projects as p  WHERE p.ID=:id  ";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0) {
              $getRow = $handle->fetch(PDO::FETCH_ASSOC);
              $name = $getRow['name'];
              echo $name . " - " . $_SESSION['name'];
          }
          //$today = date("Y-m-d H:i:s"); format timestampa
          //echo $date = date('Y-m-d H:i:s');
      ?></h2>
    </div>

    <div class="add-project__container">
      <input class="form__input" type="text" name="name"placeholder="Task name">
      <input type="submit" name="submit" value="Add task"
        class="form__btn btn-primary btn-primary--filled" />
    </div>

    <div class="projects">
      <h3 class="projects__title">Tasks</h3>

      <div class="projects__container">
        <div class="projects__row-container projects__header">
          <span>Task</span>
          <span>Time</span>
        </div>

          <?php
          require_once "connect.php";

          $id = $_SESSION['p_id'];
          $sql = "SELECT t.name, t.start , t.stop FROM tasks as t WHERE t.project_id=:id ORDER BY t.ID DESC";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0){
              while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                  $name=$getRow['name'];
                  $start=$timestamp = strtotime($getRow['start']);
                  $stop=$timestamp = strtotime($getRow['stop']);
                  $stop=date("H:i:s",$stop-$start);
                  echo '<div class="projects__row-container">
                          <span id="project-name">'.$name.'</span>
                          <span class="working">'.$stop.'</span>
                          <a class="details btn-primary--filled">Stop</a>
                        </div>';
              }
          }
          ?>
      </div>
    </div>

    <div class="add-project__container">
      <input class="form__input" id="edit-task" type="text"
        placeholder="Task name">
      <input type="submit" value="Edit task"
        class="form__btn btn-primary btn-primary--filled" />
    </div>
  </div>

</body>

</html>