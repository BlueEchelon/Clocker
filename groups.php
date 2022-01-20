<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>

<body>
  <?php require_once "_navbar_main.php" ?>

  <div class="container">
    <div class="add-project__container">
      <input class="form__input" type="text" placeholder="Group name">
      <select class="form__input" type="text" placeholder="Project">
        <option value="Project 1">Project 1</option>
        <option value="Project 2">Project 2</option>
        <option value="Project 3">Project 3</option>
      </select>
      <input type="submit" value="Add group"
        class="form__btn btn-primary btn-primary--filled" />
    </div>

    <div class="projects">
      <h3 class="projects__title">Your groups</h3>

      <div class="projects__container">
        <div class="projects__row-container projects__header">
          <span>Title</span>
          <span>Number of members</span>
        </div>

        <div class="projects__row-container">
          <span>Group 1</span>
          <span>69</span>
          <a href="group_details.php"
            class="details btn-primary--filled">Details</a>
        </div>
        <div class="projects__row-container">
          <span>Group 2</span>
          <span>69</span>
          <a href="group_details.php"
            class="details btn-primary--filled">Details</a>
        </div>
        <div class="projects__row-container">
          <span>Group 3</span>
          <span>69</span>
          <a href="group_details.php"
            class="details btn-primary--filled">Details</a>
        </div>

      </div>
    </div>
</body>

</html>