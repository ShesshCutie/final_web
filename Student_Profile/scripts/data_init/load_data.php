<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create('en_PH');
$serverName = "localhost";
$userName = "root";
$dbName = 'records_app';
$pass = '';

$db_conn = mysqli_connect($serverName, $userName, $pass, $dbName);

if (!$db_conn) {
    'Connection Failed: ' . die(mysqli_connect_error());
}

function addEmployeesRow(int $limit, $db_conn) : void {
    global $faker;

    for($i = 0; $i < $limit; $i++) {
        $lastName = $faker -> lastName;
        $firstName = $faker -> firstName;
        $officeID = $faker -> numberBetween(1, 50);
        $address = $faker -> address;

        $stmt = $db_conn -> prepare("INSERT INTO employee (lastName, firstName, officeID, address) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssis", $lastName, $firstName, $officeID, $address);

        if ($stmt -> execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . mysqli_error($db_conn);
        }
        echo "\n";
    }
}

function addOfficeRow(int $limit, $db_conn) : void {
    global $faker;

    for($i = 0; $i < $limit; $i++) {
        $name = $faker -> company;
        $contactNum = $faker -> phoneNumber;
        $email = $faker -> companyEmail;
        $address = $faker -> address;
        $city = $faker -> city;
        $country = $faker -> country;
        $postal = $faker -> postcode;

        $stmt = $db_conn -> prepare("INSERT INTO office (name, contactnum, email, address, city, country, postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssssss", $name, $contactNum, $email, $address, $city, $country, $postal);

        if ($stmt -> execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . mysqli_error($db_conn);
        }
        echo "\n";
    }
}

function addTransactionRow(int $limit, $db_conn) : void {
    global $faker;

    for($i = 0; $i < $limit; $i++) {
        $employeeID = $faker -> numberBetween(1, 200);
        $officeID = $faker -> numberBetween(1, 50);
        $date = $faker -> date();
        $action = $faker -> randomElement(array('Cash Payment', 'Loan', 'Loan Payment', 'Order Purchase'));
        $remarks = $faker -> optional(0.7) -> word;
        $documentCode = $faker -> countryCode;

        $stmt = $db_conn -> prepare("INSERT INTO transaction(employee_id, office_id, datelog, action, remarks, documentcode)
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("iissss", $employeeID, $officeID, $date, $action, $remarks, $documentCode);
        $stmt -> execute();
    }
    echo "$limit transaction records created successfully.";
}

addOfficeRow(50, $db_conn);
addEmployeesRow(200, $db_conn);
addTransactionRow(500, $db_conn);