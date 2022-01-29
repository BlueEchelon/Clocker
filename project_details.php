<!DOCTYPE html>
<html lang="en">
<?php
function debug_to_console($data)
{ //debug_to_console("TEST2");
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
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

if (isset($_POST['Add'])) { // dodawanie tasków
    if (isset($_POST['task_name']) && !empty($_POST['task_name'])) {
        $t_name = trim(filter_var($_POST['task_name'], FILTER_SANITIZE_STRING));
        $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
        $sql = "INSERT INTO tasks (project_id,name,description) values (:projectId, :t_name, :description)";
        try {
            $handle = $pdo->prepare($sql);
            $params = [
                'projectId'=>$_SESSION['p_id'],
                't_name' => $t_name,
                'description' => $description
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

if (isset($_POST['Time'])) { //przyciski STOP/START z update'em do bazy timestampa
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

if (isset($_POST['submit_task'])) { // zmiana opisu taska
    if (isset($_POST['edit-task'], $_POST['description']) && !empty($_POST['edit-task']) && !empty($_POST['description'])) {
        $t_name = trim(filter_var($_POST['edit-task'], FILTER_SANITIZE_STRING));
        $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
        $sql = "update tasks set description=:upd_desc where ID=:t_id";
        try {
            $handle = $pdo->prepare($sql);
            $params = [
                't_id' => $t_name,
                'upd_desc' => $description
            ];
            $handle->execute($params);
        }catch (PDOException $e) {
            $errors[] = $e->getMessage();
        }
    }else {
        if (!isset($_POST['edit-task']) || empty($_POST['edit-task'])) {
            $errors[] = 'Task name is required';
        } else {
            $valDesc = $_POST['description'];
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
        <input class="form__input" type="text" name="description" placeholder="Description"
               value="<?php echo(isset($valName) ? $valName : '') ?>">
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
          <span>Description</span>
        </div>

          <?php
          require_once "connect.php";

          $id = $_SESSION['p_id'];
          $sql = "SELECT t.ID,t.name, t.timer, t.description, t.status FROM tasks as t WHERE t.project_id=:id ORDER BY t.ID DESC";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0){
              while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                  $name=$getRow['name'];
                  $desc=$getRow['description'];
                  $timer=strtotime($getRow['timer']);
                  $timer=date("H:i:s",$timer);
                  if($getRow['status']==1){
                      $status = 'STOP';
                  }
                  else $status = 'START';
                  $t_id=$getRow['ID'];
                  echo '<div class="projects__row-container" >
                          <span id="project-name"  >'.$name.'</span>
                          <span class="working" id="clock">'.$timer.'</span>
                          <span id="project-name">'.$desc.'</span>
                          <a type="button" id="timer" class="details btn-primary--filled"  >'.$status.'</a>
                        </div>';
              }
          }
          ?>
      </div>
    </div>
    <form class="add-project__container" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <select class="form__input" name="edit-task" type="text" placeholder="Task name">
            <?php
            require_once "connect.php";
            $id = $_SESSION['p_id'];
            $sql = "select name,ID from tasks where project_id=:id";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $id];
            $handle->execute($params);
            if ($handle->rowCount() > 0) {
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $name = $getRow['name'];
                    $t_id=$getRow['ID'];
                    echo '<option value=' . $t_id . '>' . $name . '</option>';
                }
            }
            ?>
            <!--            <option value="Project 1">Project 1</option>-->
            <!--            <option value="Project 2">Project 2</option>-->
            <!--            <option value="Project 3">Project 3</option>-->
        </select>
        <input class="form__input" type="text" name="description" placeholder="Description"
               value="<?php echo(isset($valDesc) ? $valDesc : '') ?>">
      <input type="submit" name="submit_task" value="Edit task"
        class="form__btn btn-primary btn-primary--filled" />

    </form>
  </div>

</body>

</html>