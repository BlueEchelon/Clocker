<?php
session_start();
require_once "connect.php";
if (isset($_POST['submit']))
{
    if(isset($_POST['name'],$_POST['surname'],$_POST['email'],$_POST['password'],$_POST['confirmPass']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPass']))
    {
        $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
        $surname= trim(filter_var($_POST['surname'], FILTER_SANITIZE_STRING));
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));
        $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
        $confirmPass = trim(filter_var($_POST['confirmPass'], FILTER_SANITIZE_STRING));

        $options = array("cost"=>4);
        if($password==$confirmPass){
            //$hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
            $hashPassword=$password;
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $sql = "SELECT * FROM users WHERE email = :email";
                $handle=$pdo->prepare($sql);
                $params=['email'=>$email];
                $handle->execute($params);
                if ($handle->rowCount()==0) {
                    $sql = "INSERT INTO users ('email', 'password', 'name', 'surname', 'role') values(:email,:passw,:fname,:sur,:urole)";
                    try{
                        $handle=$pdo->prepare(sql);
                        $params=[
                            ':email'=>$email,
                            ':passw'=>$hashPassword,
                            ':fname'=>$name,
                            ':sur'=>$surname,
                            ':urole'=>'u'
                        ];
                        $handle->execute($params);
                        $success = 'User has been created successfully;';
                    }
                    catch (PDOException $e){
                        $errors[]=$e->getMessage();
                    }
                }
                else{
                    $valName=$name;
                    $valSurName=$surname;
                    $valEmail='';
                    $valPassword=$password;
                    $valConPassword=$confirmPass;

                    $errors[] = 'Email address already registered';
                }
            } else $errors[] = "Email address is not valid";
        }else $errors[] = "Password does not match";
    } else {
        if(!isset($_POST['name']) || empty($_POST['name']))
        {
            $errors[] = 'First name is required';
        }
        else
        {
            $valName = $_POST['name'];
        }
        if(!isset($_POST['surname']) || empty($_POST['surname']))
        {
            $errors[] = 'Surname is required';
        }
        else
        {
            $valSurName = $_POST['surname'];
        }

        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'Email is required';
        }
        else
        {
            $valEmail = $_POST['email'];
        }

        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'Password is required';
        }
        else
        {
            $valPassword = $_POST['password'];
        }
        if(!isset($_POST['confirmPass']) || empty($_POST['confirmPass']))
        {
            $errors[] = 'Password is required';
        }
        else
        {
            $valConPassword = $_POST['confirmPass'];
        }
    }
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
  <?php
  require_once "_navbar.php";
  if(isset($errors) && count($errors) > 0)
  {
      foreach($errors as $error_msg)
      {
          echo '<div class="alert alert-danger">'.$error_msg.'</div>';
      }
  }
  if(isset($success))
  {
      echo '<div class="alert alert-success">'.$success.'</div>';
  }
  ?>
  <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>)">
    <h4 class="form__title">Sign up</h4>

    <input class="form__input" type="text" name="name" placeholder="First name" value="<?php echo (isset($valName) ? $valName : '')?>">
    <input class="form__input" type="text" name="surname" placeholder="Last name" value="<?php echo (isset($valSurName) ? $valSurName : '')?>">
    <input class="form__input" type="email" name="email" placeholder="Email" value="<?php echo (isset($valEmail) ? $valEmail : '')?>">
    <input class="form__input" type="password" name="password" placeholder="Password" value="<?php echo (isset($valPassword) ? $valPassword : '')?>">
    <input class="form__input" type="password" name="confirmPass" placeholder="Confirm password" value="<?php echo (isset($valConPassword) ? $valConPassword : '')?>">

    <input type="submit" name="submit" value="Sign up"
      class="form__btn btn-primary btn-primary--filled" />

    <p class="form__text">Already registered? <a class="form__text-link"
        href="login.php">Sign
        in</a></p>
  </form>
</body>


</html>