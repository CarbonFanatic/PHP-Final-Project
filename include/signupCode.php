<?php
$json = file_get_contents("accountInfo.json");
$accountArray = json_decode($json, true);
if (isset($_POST['signup'])) {

    $username = $_POST['uid'];
    $password = $_POST['pass'];
    $passwordRepeat = $_POST['pass-repeat'];

//check for missing fields
    if (empty($username) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&uid=" . $username );
        exit();
    }
    // validate Username
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid" );
        exit();
    } //password and repeat password does not match
    else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=" . $username);
        exit();
    } else {
        foreach ($accountArray as $account) {
            $acctemp = $account['UserName'];

            if ($account['UserName'] == $username) {
                header("Location: ../signup.php?error=userExists");
                exit();
            }
        }
        $newPerson= array(
            'type' => 'standard',
            'UserName' => $username,
            'password'=>$password
        );
        $accountArray[]=$newPerson;
        $encode= json_encode($accountArray,JSON_PRETTY_PRINT);
        file_put_contents('accountInfo.json',$encode);
        header("Location: ../loginPage?msg=accountCreated");
        exit();
                }


}