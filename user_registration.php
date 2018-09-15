<?php 
// importing DBConfig.php file
include 'DBConfig.php';

// create the connection
$connection = mysqli_connect($hostName, $dbUsername, $dbPassword, $database);

// get the received JSON and store into $json variable
$json = file_get_contents('php://input');

// decode the JSON and store into the $obj variable
$obj = json_decode($json, true);

// populate Username from JSON $obj array and store into $name
$name = $obj['name'];

// populate User email from JSON $obj array and store into $email
$email = $obj['email'];

// populate Password from JSON $obj array and store into $password
$password = $obj['password'];

// checking to see if Email already exists using a SQL Query
$checkSQL = "SELECT * FROM UserRegistrationTable WHERE email='$email'";

// executing SQL Query
$check = mysqli_fetch_array(mysqli_query($connection, $checkSQL));

if(isset($check)) {
    $emailExistsMsg = 'Email already exists, please try again!';

    // converting the message into JSON format
    $emailExistsJSON = json_encode($emailExistsMsg);

    // echo the message
    echo $emailExistsMsg;
} else {
    // creating a SQL Query and insert the record into MySQL db table
    $sqlQuery = "insert into UserRegistrationTable (name, email, passowrd) values('$name', '$email', '$password')";
    if(mysqli_query($connection, $sqlQuery)) {
        // if the record inserted succesfully then show the message
        $msg = 'User Registered Successfully';

        // convert the message into JSON format
        $json = json_encode($msg);

        // echo the message
        echo $json;
    } else {
        echo 'Please Try Again';
    }
}
mysqli_close($connection);
?>