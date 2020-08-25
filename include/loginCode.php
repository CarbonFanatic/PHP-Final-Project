<?php

$json = file_get_contents("accountInfo.json");
$accountArray = json_decode($json, true);
if (isset($_POST['login'])) {

    $uid = $_POST['uid'];
    $password = $_POST['pass'];
    if (empty($uid) || empty($password)) {
        header("Location: ../loginPage.php?msg=emptyfields&uid=". $uid);
        exit();
    } else
        foreach ($accountArray as $account) {
            $acctemp = $account['UserName'];
            $passtemp = $account['password'];
            $accType = $account['type'];


            if($acctemp == $uid && $passtemp != $password) {
                header("Location: ../loginPage.php?msg=wrongPassword&uid=". $uid);
                exit();

            }
            elseif ($acctemp != $uid) {
                header("Location: ../loginPage.php?msg=UserNExist");

            }
            elseif ($acctemp == $uid && $passtemp == $password) {
                session_start();
                // And NOW we create the session variables.
                $_SESSION['acctype'] = $accType;
                $_SESSION['uid'] = $acctemp;
                header("Location: ../index.php?msg=loginSuccesfull");
                exit();
            }

        }
}

