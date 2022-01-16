<?php
 //Funkcja do sprawdzania w consoli !!!!!!!!!!!!!!! WYWALA przechodzenie do innej strony "HEADER" używać z rozwagą
/*function debug_to_console($data){ //debug_to_console("TEST2");
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}*/
session_start();
require_once "connect.php";
if (isset($_POST['submit']))
{
    if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));
        $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
        if (filter_var($email,FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT * FROM users WHERE email = :email";
            $handle=$pdo->prepare($sql);
            $params=['email'=>$email];
            $handle->execute($params);
            $option = array("cost"=>4);
            if ($handle->rowCount()>0){
                //debug_to_console($password);
                $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                //debug_to_console(password_verify($password,$getRow['password']));
                //debug_to_console($getRow['password']);
                $password_hash=$getRow['password'];

                if(password_verify($password, $password_hash)) {
                    unset($getRow['password']);
                    $_SESSION=$getRow;
                    header('location:main.php');
                    exit();
                }


                if($password==$getRow['password']){
                    unset($getRow['password']);
                    $_SESSION=$getRow;
                    header('location:main.php');
                    exit();
                }
                else $errors[] = "Wrong Email or Password";
            }else $errors[] = "Wrong Email or Password";
        }else $errors[] = "Email address is not valid";
    } else $errors[] = "Email and Password are required";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@700&family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../styles/styles.css">
  <title>Clocker</title>
</head>

<body>
  <?php require_once "_navbar.php" ?>

  <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h4 class="form__title">Sign in</h4>

    <input class="form__input" type="email" name=email placeholder="Email">
    <input class="form__input" type="password" name=password placeholder="Password">

    <input type="submit" name="submit" value="Sign in"
      class="form__btn btn-primary btn-primary--filled" />
      <?php
      if(isset($errors) && count($errors) > 0)
      {
          foreach($errors as $error_msg)
          {
              echo '<div class="alert alert-danger">'.$error_msg.'</div>';
          }
      }
      ?>
    <p class="form__text">Forgot password?</p>
    <p class="form__text">Dont't have an account? <a class="form__text-link"
        href="register.php">Sign
        up</a></p>
  </form>
</body>
</html>