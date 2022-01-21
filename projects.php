<!DOCTYPE html>
<html lang="en">
<?php
function debug_to_console($data)
{ //debug_to_console("TEST2");
    $output = $data;
    if (is_array($output)) $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
session_start();
unset($_SESSION['p_id']);
if(!isset($_SESSION['ID']))
{
    header('Location: index.php');
    exit();
}
require_once "connect.php";
if (isset($_POST['Add'])) {
    if (isset($_POST['project_name'], $_POST['client']) && !empty($_POST['project_name']) && !empty($_POST['client'])) {
        $p_name = trim(filter_var($_POST['project_name'], FILTER_SANITIZE_STRING));
        $client = trim(filter_var($_POST['client'], FILTER_SANITIZE_STRING));
        $sql = "SELECT * FROM clients WHERE name = :client ";
        $handle = $pdo->prepare($sql);
        $params = ['client' => $client];
        $handle->execute($params);
        if ($handle->rowCount()>0) {
            while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                if($getRow['user_id']==$_SESSION['ID']){
                    $client_id=$getRow['ID'];
                    $sql = "INSERT INTO projects (user_id,client_id,name) values (:userId, :clientId, :p_name)";
                    try{
                        $handle = $pdo->prepare($sql);
                        $params = [
                                ':userId' =>$_SESSION['ID'],
                                ':clientId' => $client_id,
                                ':p_name' => $p_name,
                                ];
                                $handle->execute($params);
                    } catch (PDOException $e) {
                        $errors[] = $e->getMessage();
                    }
                } else {
                    $valName = $p_name;
                    $valClient = $client;

                    $errors[] = 'Email address already registered';
                }
            }
        }else{
            $sql = "INSERT INTO clients (name,user_id) values (:c_name,:userId)";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':c_name' =>$client,
                    ':userId' => $_SESSION['ID'],
                ];
                $handle->execute($params);
            } catch (PDOException $e) {
                $errors[] = $e->getMessage();
            }
            $sql = "SELECT * FROM clients WHERE name = :client ";
            $handle = $pdo->prepare($sql);
            $params = ['client' => $client];
            $handle->execute($params);
            if ($handle->rowCount()>0) {
                while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                    if($getRow['user_id']==$_SESSION['ID']){
                        $client_id=$getRow['ID'];
                        $sql = "INSERT INTO projects (user_id,client_id,name) values (:userId, :clientId, :p_name)";
                        try{
                            $handle = $pdo->prepare($sql);
                            $params = [
                                ':userId' =>$_SESSION['ID'],
                                ':clientId' => $client_id,
                                ':p_name' => $p_name,
                            ];
                            $handle->execute($params);
                        } catch (PDOException $e) {
                            $errors[] = $e->getMessage();
                        }
                    } else {
                        $valName = $p_name;
                        $valClient = $client;
                        $errors[] = 'Email address already registered';
                    }
                }
            }
        }
            /*
            $sql = "INSERT INTO projects (email, password, name, surname, role) values (:email, :passw, :fname, :sur, :urole)";
            try {
                $handle = $pdo->prepare($sql);
                $params = [
                        ':p_name' => $email,
                        ':Client' => $hashPassword,
                        ':u_id' =>$_SESSION['ID'],
                        ];
                        $handle->execute($params);
                        $success = 'User has been created successfully;';
                    } catch (PDOException $e) {
                        $errors[] = $e->getMessage();
                    }
                } else {
                    $valName = $name;
                    $valSurName = $surname;
                    $valEmail = '';
                    $valPassword = $password;
                    $valConPassword = $confirmPass;

                    $errors[] = 'Email address already registered';
                }
            } else $errors[] = "Email address is not valid";
    } else {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors[] = 'First name is required';
        } else {
            $valName = $_POST['name'];
        }
        if (!isset($_POST['surname']) || empty($_POST['surname'])) {
            $errors[] = 'Surname is required';
        } else {
            $valSurName = $_POST['surname'];
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'Email is required';
        } else {
            $valEmail = $_POST['email'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'Password is required';
        } else {
            $valPassword = $_POST['password'];
        }
        if (!isset($_POST['confirmPass']) || empty($_POST['confirmPass'])) {
            $errors[] = 'Password is required';
        } else {
            $valConPassword = $_POST['confirmPass'];
        }*/
    }
}




?>
<?php require_once "_head.php" ?>

<body>
<?php require_once "_navbar_main.php" ?>

<div class="container">
    <form class="add-project__container"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input class="form__input"  type="text" name="project_name" placeholder="Project name"
               value="<?php echo (isset($valName) ? $valName : '') ?>">
        <input class="form__input"  type="text" name="client" placeholder="Client"
               value="<?php echo (isset($valClient) ? $valClient : '') ?>">
        <input type="submit"  name="Add" value="Add project"
               class="form__btn btn-primary btn-primary--filled"/>
    </form>

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
            $sql = "SELECT p.name,p.ID , c.name as Klient ,COUNT(t.ID) as Licznik
FROM projects as p 
LEFT JOIN tasks as t ON (t.project_id=p.ID), clients as c 
WHERE p.user_id=:id AND c.ID = p.client_id 
GROUP BY p.ID 
ORDER BY p.ID DESC";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $id];
            $handle->execute($params);
            if ($handle->rowCount()>0){
                while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                    $name = $getRow['name'];
                    $client = $getRow['Klient'];
                    $counter = $getRow['Licznik'];
                    $p_id = $getRow['ID'];
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