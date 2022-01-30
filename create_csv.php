<?php
require_once "connect.php";
session_start();
$id = $_SESSION['ID'];
$sql = "select u.name, u.surname, p.name as p_name, t.name as t_name, t.timer, t.start as data_rozpoczecia, c.name as c_name from tasks t, users u, projects p, clients c
where p.ID=t.project_id
and p.user_id=u.ID
and p.client_id = c.ID
and u.ID=:id
order by data_rozpoczecia";
$handle = $pdo->prepare($sql);
$params = ['id' => $id];
$handle->execute($params);
if ($handle->rowCount() > 0) {
    $getRowName = $handle->fetch(PDO::FETCH_ASSOC);
    $u_name = $getRowName['name'];
    $s_name = $getRowName['surname'];
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'. $u_name . '-' . $s_name . '.csv"');
    $user_CSV[0] = array('Project Name', 'Task name', 'Timer', 'Start', 'Client name');
    $counter = 1;
    while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)) {
        $p_name = $getRow['p_name'];
        $t_name = $getRow['t_name'];
        $timer = $getRow['timer'];
        $start = $getRow['data_rozpoczecia'];
        $c_name = $getRow['c_name'];
        $user_CSV[$counter] = array($p_name, $t_name, $timer, $start, $c_name);
        $counter++;
    }
    $fp = fopen('php://output', 'wb');
    foreach ($user_CSV as $line) {
        fputcsv($fp, $line, ';');
    }
    fclose($fp);
}
?>