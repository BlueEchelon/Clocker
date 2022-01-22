<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>
<?php
session_start();
if (!isset($_SESSION['g_id'])){
    $_SESSION['g_id']=$_GET['G_id'];
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
      <h2>Group 1</h2>
      <h2>Project: E-Nurse </h2>
      <h2>Client: Jan Kowalski</h2>
    </div>

    <div class="add-project__container">
      <select class="form__input" type="text" placeholder="Member">
        <option value="Jan Kowalski">Jan Kowalski</option>
        <option value="Jan Nowak">Jan Nowak</option>
        <option value="Jan Nowak">Jan Kwiatkowski</option>
      </select>
      <input type="submit" value="Add member"
        class="form__btn btn-primary btn-primary--filled" />
    </div>

    <div class="projects">
      <h3 class="projects__title">Members</h3>

      <div class="projects__container">
        <div class="projects__row-container projects__header">
          <span>Name</span>
        </div>

        <div class="projects__row-container">
          <span>Jan Kowalski</span>
        </div>
        <div class="projects__row-container">
          <span>Adam Nowak</span>
        </div>
        <div class="projects__row-container">
          <span>Tomasz Hałoń</span>
        </div>

      </div>
    </div>
  </div>

</body>

</html>