<?php
session_start();

$id = "";
$passwd = "";
$login = array();

if (isset($_POST['id'])) { // La variable n'était pas attribuée au POST
    echo $id;
};
if (isset($_POST['passwd'])) { // La variable n'était pas attribuée au POST
    echo $passwd;
};
if (isset($_POST['save'])) { // Ce test vérifie que le submit soit posté
    #$id = $_POST['id'];
    #$passwd = $_POST['passwd'];
    #echo $id, $passwd;

    $login[$_POST['id']] = $_POST['passwd'];
    print_f($login);
};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <form action="index.php" method="POST">
        <input type="text" name="id" tabIndex="1"/>
        <input type="text" name="passwd" tabIndex="2"/>
        <button type="submit" name="save">Login</button>
    </form>
</body>
</html>
