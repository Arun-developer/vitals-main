<?php

// **********************************
// cosmetic stuff

if (!defined('jj')) {

    define('jj', '<br />');
}



echo '<b>Database configuration:</b>';

echo '<pre>';

print_r($db['default']);

echo '</pre>';



echo 'Trying to connect: ';

$dbh = mysqli_connect
        (
        $db['default']['hostname'], $db['default']['username'], $db['default']['password'])

        or

        die(jj . 'Cannot connect to the database because: ' . mysqli_error()
);



$connected = mysqli_select_db($db['default']['database']);



$msg = 'Big Problen cannot connect???'; // default

if ($connected) {

    $msg = 'Connected OK';
}

echo jj, jj, $msg;



die(jj . jj . '<b>Debug:</b> file: ' . __FILE__ . '--> Line: ' . __LINE__);



// ***********************************