<!DOCTYPE html>
<html lang="en">
<?php
session_start();
unset($_SESSION['p_id']);
if(!isset($_SESSION['ID']))
{
    header('Location: index.php');
    exit();
}
?>
<?php require_once "_head.php" ?>

<body>
  <?php require_once "_navbar_main.php" ?>

  <div class="container">
    <div class="add-project__container">
      <input class="form__input" type="text" placeholder="Project name">
      <input class="form__input" type="text" placeholder="Client">
      <input type="submit" value="Add project"
        class="form__btn btn-primary btn-primary--filled" />
    </div>

    <div class="projects">
      <h3 class="projects__title">Your projects</h3>

      <div class="projects__container">
        <div class="projects__row-container projects__header">
          <span>Title</span>
          <span>Client</span>
          <span>Number of tasks</span>
        </div>
          <?php
          require_once "connect.php";

          $id = $_SESSION['ID'];
          $sql = "SELECT p.name,p.ID , c.name as Klient ,COUNT(*) as Licznik   FROM projects as p JOIN tasks as t ON (t.project_id=p.ID), clients as c WHERE p.user_id=:id AND c.ID = p.client_id GROUP BY p.ID ORDER BY p.ID DESC";
          $handle = $pdo->prepare($sql);
          $params = ['id' => $id];
          $handle->execute($params);
          if($handle->rowCount()>0){
              while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                  $name=$getRow['name'];
                  $client=$getRow['Klient'];
                  $counter=$getRow['Licznik'];
                  $p_id=$getRow['ID'];
                  echo '<div class="projects__row-container">
                          <span>'.$name.'</span>
                          <span>'.$client.'</span>
                          <span>'.$counter.'</span>
                          <a href="project_details.php?id='.$p_id.'"
                            class="details btn-primary--filled">Details</a>
                          </div>';
              }
          }
          ?>
      </div>
    </div>

</body>

</html>