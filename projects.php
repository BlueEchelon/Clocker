<!DOCTYPE html>
<html lang="en">

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

        <div class="projects__row-container">
          <span>Project 1</span>
          <span>Client 1</span>
          <span>69</span>
          <a href="project_details.php"
            class="details btn-primary--filled">Details</a>
        </div>
        <div class="projects__row-container">
          <span>Project 2</span>
          <span>Client 2</span>
          <span>69</span>
          <a href="project_details.php"
            class="details btn-primary--filled">Details</a>
        </div>
        <div class="projects__row-container">
          <span>Project 3</span>
          <span>Client 3</span>
          <span>69</span>
          <a href="project_details.php"
            class="details btn-primary--filled">Details</a>
        </div>

      </div>
    </div>

</body>

</html>