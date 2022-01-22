<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['p_id'])){
    $_SESSION['p_id']=$_GET['P_id'];
}
if(!isset($_SESSION['ID']))
{
    header('Location: index.php');
    exit();
}
$records=array();
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

if (isset($_POST['Add'])) {
    if (isset($_POST['task_name']) && !empty($_POST['task_name'])) {
        $t_name = trim(filter_var($_POST['task_name'], FILTER_SANITIZE_STRING));
        $sql = "INSERT INTO tasks (project_id,name) values (:projectId, :t_name)";
        try {
            $handle = $pdo->prepare($sql);
            $params = [
                'projectId'=>$_SESSION['p_id'],
                't_name' => $t_name,
            ];
            $handle->execute($params);
        }catch (PDOException $e) {
            $errors[] = $e->getMessage();
        }
    }else {
        if (!isset($_POST['task_name']) || empty($_POST['task_name'])) {
            $errors[] = 'Task name is required';
        } else {
            $valName = $_POST['task_name'];
        }
    }
}

if (isset($_POST['Time'])) {
    if (isset($_POST['task_name']) && !empty($_POST['task_name'])) {
        $t_name = trim(filter_var($_POST['task_name'], FILTER_SANITIZE_STRING));
        $sql = "INSERT INTO tasks (project_id,name) values (:projectId, :t_name)";
        try {
            $handle = $pdo->prepare($sql);
            $params = [
                ':projectId'=>$_SESSION['p_id'],
                ':t_name' => $t_name,
            ];
            $handle->execute($params);
        }catch (PDOException $e) {
            $errors[] = $e->getMessage();
        }
    }else {
        if (!isset($_POST['task_name']) || empty($_POST['task_name'])) {
            $errors[] = 'Task name is required';
        } else {
            $valName = $_POST['task_name'];
        }
    }
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

    <form class="add-project__container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input class="form__input" type="text" name="task_name" placeholder="Task name"
             value="<?php echo (isset($valName) ? $valName : '') ?>">
      <input type="submit" name="Add" value="Add task"
        class="form__btn btn-primary btn-primary--filled" />
    </form>
      <?php if (isset($errors) && count($errors) > 0) {
          foreach ($errors as $error_msg) {
              echo '<div style="color: red;">' . $error_msg . '</div>';
          }
      }
      ?>

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
          $sql = "SELECT t.ID,t.name, t.timer, t.status FROM tasks as t WHERE t.project_id=:id ORDER BY t.ID DESC";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0){
              while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                  $name=$getRow['name'];
                  $timer=strtotime($getRow['timer']);
                  $timer=date("H:i:s",$timer);
                  if($getRow['status']==1){
                      $status = 'STOP';
                  }
                  else $status = 'START';
                  $t_id=$getRow['ID'];
                  echo '<div class="projects__row-container" href>
                          <span id="project-name"  >'.$name.'</span>
                          <span class="working">'.$timer.'</span>
                          <a type="button" class="details btn-primary--filled"  >'.$status.'</a>
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