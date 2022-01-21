<!DOCTYPE html>
<html lang="en">

<?php
session_start();

if(!isset($_SESSION['ID']))
{
    header('Location: index.php');
    exit();
}
?>

<?php require_once "_head.php" ?>

<body>
  <?php require_once "_navbar_main.php" ?>
  <main>
    <div class="container">
      <div>
        <h2>Hello, <?php echo $_SESSION['name'].' '.$_SESSION['surname']?>!</h2>
      </div>

      <div class="last-projects">
        <h3 class="last-projects__title">Last projects</h3>

        <div class="last-projects__header">
          <span>Title</span>
          <span>Number of tasks</span>
        </div>
          <?php
            require_once "connect.php";

          $id = $_SESSION['ID'];
          $sql = "SELECT p.name ,COUNT(*) as Licznik   FROM projects as p JOIN tasks as t ON (t.project_id=p.ID) WHERE p.user_id=:id GROUP BY p.ID ORDER BY p.ID DESC";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0){
              while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                  $name=$getRow['name'];
                  $counter=$getRow['Licznik'];
                  echo '<div class="last-projects__row"> <span>'.$name.'</span> <span>'.$counter.'</span> </div>';
              }
          }
          ?>
        <div class="last-projects__row">
          <span>E-Nurse</span>
          <span>69</span>
        </div>
        <div class="last-projects__row">
          <span>Scrumex</span>
          <span>69</span>
        </div>
      </div>

      <div class="recent-groups">
        <h3 class="recent-groups__title">Recent groups</h3>

        <div class="recent-groups__header">
          <span>Name</span>
        </div>

        <div class="recent-groups__row">
          <span>Group 1</span>
        </div>
        <div class="recent-groups__row">
          <span>Group 2</span>
        </div>
        <div class="recent-groups__row">
          <span>Group 3</span>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
