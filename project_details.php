<!DOCTYPE html>
<html lang="en">

<?php require_once "_head.php" ?>

<body>
  <?php require_once "_navbar_main.php" ?>

  <div class="container">
    <div>
      <h2>E-Nurse - Jan Kowalski</h2>
    </div>

    <div class="add-project__container">
      <input class="form__input" type="text" placeholder="Task name">
      <input type="submit" value="Add task"
        class="form__btn btn-primary btn-primary--filled" />
    </div>

    <div class="projects">
      <h3 class="projects__title">Tasks</h3>

      <div class="projects__container">
        <div class="projects__row-container projects__header">
          <span>Task</span>
          <span>Time</span>
        </div>

        <div class="projects__row-container">
          <span id="project-name">Task 1</span>
          <span class="working">01:09:21</span>
          <a class="details btn-primary--filled">Stop</a>
        </div>
        <div class="projects__row-container">
          <span id="project-name">Task 2</span>
          <span class="not-working">21:37:03</span>
          <a class="details btn-primary--filled">Start</a>
        </div>
        <div class="projects__row-container">
          <span id="project-name">Task 3</span>
          <span class="working">03:57:50</span>
          <a class="details btn-primary--filled">Stop</a>
        </div>

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