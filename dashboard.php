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
<?php require_once "_navbar_main.php" ?> <!-- Navbar powinnien być dopasowany dla admina jednak on nie musi mieć tych samych co frajer user -->
<main>
    <div class="container">
        <div>
            <h2>Welcome back Admin - <?php echo $_SESSION['name'].' '.$_SESSION['surname']?>!</h2>
        </div>

        <div class="last-projects">
            <h3 class="last-projects__title">Users</h3>

            <div class="last-projects__header">
                <span>User name</span>
                <span>Number of projects</span>
            </div>
            <?php
            require_once "connect.php";

            $sql = "SELECT users.ID, users.email ,COUNT(p.ID) as Licznik
                FROM users 
                LEFT JOIN projects as p ON (p.user_id=users.ID)
                WHERE users.role='u'
                GROUP BY users.email
                LIMIT 10";
            $handle = $pdo->prepare($sql);
            $handle->execute();
            if($handle->rowCount()>0){
                while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                    $name=$getRow['email'];
                    $counter=$getRow['Licznik'];
                    echo '<div class="last-projects__row"> <span>'.$name.'</span> <span>'.$counter.'</span> </div>';
                }
            }
            ?>
        </div>

        <div class="recent-groups">
            <h3 class="recent-groups__title">Groups</h3>

            <div class="recent-groups__header">
                <span>Name</span>
            </div>
            <?php
            require_once "connect.php";
            //          $sql = "SELECT g.name   FROM users as u,groups as g JOIN members as m ON (m.group_id=g.ID) WHERE u.ID=:id AND m.user_id =:id GROUP BY g.ID ORDER BY g.ID DESC";
            $sql = "select g.name from clocker_db.groups g ORDER BY g.ID DESC LIMIT 10";
            $handle = $pdo->prepare($sql);
            $handle->execute();
            if($handle->rowCount()>0){
                while($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
                    $name=$getRow['name'];
                    echo '<div class="recent-groups__row"><span>'.$name.'</span></div>';
                }
            }
            ?>
        </div>
    </div>
</main>
</body>

</html>
