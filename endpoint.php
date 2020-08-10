<?php
   

 //Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){

//Make sure that the content type of the POST request has been set to application/json
		$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
		if(strcasecmp($contentType, 'application/json') != 0){
   			 throw new Exception('Content type must be: application/json');
		}

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input"));

		//Attempt to decode the incoming RAW post data from JSON.
		$decoded = json_decode($content, true);

		//If json_decode failed, the JSON is invalid.
		if(!is_array($decoded)){
  			  throw new Exception('Received content contained invalid JSON!');
		}
		echo $decoded['params']['name'];
}

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0){
	if($_GET["params"]) {
		//Attempt to decode the incoming RAW post data from JSON.
		$decoded = json_decode($_GET["params"],true);

		//If json_decode failed, the JSON is invalid.
		if(!is_array($decoded)){
  			  throw new Exception('Received content contained invalid JSON!');
		}
		insertintoOrders("ksajkljskla","10212","jkarthik@gmail.com","jhhjg", "jhgjg", "jjhjk","jgjgjghj", "jkhjj", "trytfgh", "jghjhjhj","ddewdas","dewxs","dsew");
   }

}

function dbConnection() {
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "EcommerceDatabase";

    // Create connection
	$con = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    echo "database Connected successfully";
    return $con;
}

function insertIntoOwnersTable($ownserUserid, $name, $email, $password, $phoneNumber) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO OwnersAccountsTable(owneruserid, name, email, password, phonenumber) VALUES ('$ownserUserid', '$name', '$email', '$password', '$phoneNumber')";
	if(mysqli_query($con, $insertQuery)){
    echo "Records added successfully OwnersAccountsTable";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);
}

function insertintoCustomerTable($customerUserid, $name, $email, $password, $phoneNumber) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO CustomersTable(customeruserid, name, email, password, phonenumber) VALUES ('$customerUserid', '$name', '$email', '$password', '$phoneNumber')";
	if(mysqli_query($con, $insertQuery)){
    echo "Records added successfully CustomersTable";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);
}

function insertintoAddressTable($customeruserid, $plotno, $street, $nearby, $colony, $village, $pincode) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO Addresstable(customeruserid, plotno, street, nearby, colony, village, pincode) VALUES ('$customeruserid', '$plotno', '$street', '$nearby', '$colony', '$village', '$pincode')";
	if(mysqli_query($con, $insertQuery)){
    echo " Records added successfully in addresstable";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);
}

function insertintoOffersTable($owneruserid, $offerimages, $offerpercentage) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO offerstable(owneruserid, offerimages, offerpercentage) VALUES ('$owneruserid', '$offerimages', '$offerpercentage')";
	if(mysqli_query($con, $insertQuery)){
    echo " Records added successfully in offerstable";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);
}


function insertintoProducts($productid, $owneruserid, $productname, $price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO Products(productid, owneruserid, productname, price, discountprice, discountpercentage, producttype, sizes, productdetails, images) VALUES ('$productid', '$owneruserid', '$productname', '$price', '$discountprice', '$discountpercentage', '$producttype', '$sizes', '$productdetails', '$images')";
	if(mysqli_query($con, $insertQuery)){
    echo " Records added successfully in Products";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);

}

function insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype) {
	$con = dbConnection();
	$insertQuery = "INSERT INTO Orders(customeruserid, owneruserid, orderid, productname, orderprice, orderdiscount, productid, orderdate, orderstatus, orderaddress, orderplacedtype, orderdetails, producttype) 
	VALUES ('$customeruserid', '$owneruserid', '$orderid', '$productname', '$orderprice', '$orderdiscount', '$productid', '$orderdate', '$orderstatus', '$orderaddress', '$orderplacedtype', '$orderdetails', '$producttype')";
	if(mysqli_query($con, $insertQuery)){
    echo " Records added successfully in Products";
	} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	} 
	// Close connection
	mysqli_close($con);
}



?>