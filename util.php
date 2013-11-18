<?php
define("VALID",          0);
define("BLANK",          1);
define("TOO_LONG",       2);
define("PWD_NO_MATCH",   3);
define("TOO_SHORT",      4);
define("USER_EXISTS",    5);

function displayLengthError($itemReturnCode, $itemName, $length) {
    if ($itemReturnCode == BLANK) {
        echo "&nbsp;$itemName is required.";
    } elseif ($firstNameReturnCode == TOO_LONG) {
        echo "&nbsp;$itemName is too long. Should not be more than $length characters.";
    }
}

function createUser($firstName, $lastName, $middleInitial, $phone, $address, $apt, $town, $state, $zipcode) {
    $output = array();
        global $dsn;
        $connection = DB::connect($dsn);

        if (DB::isError($connection)) {
            die($connection->getMessage());
        }

        $statement = $connection->prepare('INSERT INTO user (id, last_name, first_name, password, admin, last_login) VALUES (?, ?, ?, ?, ?, ?)');
        $data = array($firstName, $lastName, generate_hash($pwd), $admin, NULL);
        $result = $connection->execute($statement, $data);

        $connection->disconnect();

    return array($retval, $output);
}
?>
