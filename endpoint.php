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
		
		if($decoded["params"]["method"] == Constants::$Customerregister) {
			// echo $str = implode(',', $decoded["params"]["data"]);
			CustomersOperations::registerCustomer($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$ownerRegister) {
			OwnerOperations::registerOwner($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addProduct) {
			OwnerOperations::addProduct($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addAddress) {
			CustomersOperations::addAddressCustomer($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$placeOrder) {
			CustomersOperations::placeOrder($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addoffers) {
			OwnerOperations::addoffers($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addImages) {
			OwnerOperations::addImages($decoded["params"]["data"]);
		} 
}

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0){
	if($_GET["params"]) {
		//Attempt to decode the incoming RAW post data from JSON.
		$decoded = json_decode($_GET["params"],true);

		//If json_decode failed, the JSON is invalid.
		if(!is_array($decoded)){
  			  throw new Exception('Received content contained invalid JSON!');
		}
		insertintoImagesTable("das","ygygygy","saxwx",getImagefile("scree.png"),"scree.png");
   }

}



function getImagefile($path) {


	// $imagePath = "https://meet.google.com/linkredirect?authuser=0&dest=https%3A%2F%2Fmedia.geeksforgeeks.org%2Fwp-content%2Fuploads%2Fgeeksforgeeks-22.png";
 
	// //Get the extension of the file using the pathinfo function.
	$extension = pathinfo($path, PATHINFO_EXTENSION);


	// //Get the file data.
	$data  = file_get_contents($path);
	
	//Encode the data into Base 64 using the base64_encode function.
	$dataEncoded = base64_encode($data);
	 
	//Construct our base64 string.
	$base64Str = 'data:image/' . $extension . ';base64,' . $dataEncoded;

	return $base64Str;
}


/**
 * 
 */
 class Constants
{
	
	 public static $Customerregister = "customerregister";
	 public static $ownerRegister = "registerOwner";
	 public static $addProduct = "addProduct";
	 public static $addAddress = "addAddress";
	 public static $placeOrder = "placeOrder";
	 public static $addoffers = "addoffers";
	 public static $addImages = "addImages";

}

/**
 * 
 */
class Dboperations
{
	
	public static function dbConnection() {
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

	public static function insertIntoOwnersTable($ownserUserid, $name, $email, $password, $phoneNumber) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO OwnersAccountsTable(owneruserid, name, email, password, phonenumber) VALUES ('$ownserUserid', '$name', '$email', '$password', '$phoneNumber')";
		if(mysqli_query($con, $insertQuery)){
	    echo "Records added successfully OwnersAccountsTable";
		} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);
	}

	public static function insertintoCustomerTable($customerUserid, $name, $email, $password, $phoneNumber) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO CustomersTable(customeruserid, customername, email, password, phonenumber) VALUES ('$customerUserid', '$name', '$email', '$password', '$phoneNumber')";
		if(mysqli_query($con, $insertQuery)){
	    echo "Records added successfully CustomersTable";
		} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);
	}

	public static function insertintoAddressTable($customeruserid, $plotno, $street, $nearby, $colony, $village, $pincode) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO Addresstable(customeruserid, plotno, street, nearby, colony, village, pincode) VALUES ('$customeruserid', '$plotno', '$street', '$nearby', '$colony', '$village', '$pincode')";
		if(mysqli_query($con, $insertQuery)){
	    echo " Records added successfully in addresstable";
		} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);
	}

	public static function insertintoOffersTable($owneruserid, $offerimages, $offerpercentage) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO offerstable(owneruserid, offerimages, offerpercentage) VALUES ('$owneruserid', '$offerimages', '$offerpercentage')";
		if(mysqli_query($con, $insertQuery)){
	    echo " Records added successfully in offerstable";
		} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);
	}


	public static function insertintoProducts($pid, $owneruserid, $productname, $description, $price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images) {
		$con = Dboperations::dbConnection();
		
		$insertQuery = "INSERT INTO Products(productid, owneruserid, productname, description, price, discountprice, discountpercentage, producttype, sizes, productdetails, images) VALUES ('$pid', '$owneruserid', '$productname', '$description', '$price', '$discountprice', '$discountpercentage', '$producttype', '$sizes', '$productdetails', '$images')";

		if(mysqli_query($con, $insertQuery)){
	    echo " Records added successfully in Products";
		} else {
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);

	}

	public static function insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype) {
		$con = Dboperations::dbConnection();
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


	public static function insertintoImagesTable($productid, $owneruserid, $imageid, $file, $imagename) {
		$con = Dboperations::dbConnection();

		$insertQuery = "INSERT INTO ImagesTable(productid, owneruserid, imageid, image,imagename) VALUES ('$productid', '$owneruserid', '$imageid', '$file','$imagename')";

		if(mysqli_query($con, $insertQuery)){
	    	echo " Records added successfully in ImagesTable";
		} else {
	   	 	echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		} 
		// Close connection
		mysqli_close($con);

	}


}

/**
 * 
 */
class CustomersOperations
{
	
	public static function registerCustomer($data) {

			 $customername = $data["customername"];
			 $email = $data["email"];
			 $password = $data["password"];
			 $phonenumber = $data["phoneNumber"];

			Dboperations::insertintoCustomerTable("edweewef",$customername, $email, $password, $phonenumber);
	}

	public static function deleteCustomer($customerUserid){

	}


	public static function addAddressCustomer($data){
		$customeruserid = $data["customeruserid"];
		$plotno = $data["plotno"];
		$street = $data["street"];
		$nearby = $data["nearby"];
		$colony = $data["colony"];
		$village = $data["village"];
		$pincode = $data["pincode"];
		Dboperations::insertintoAddressTable($customeruserid, $plotno, $street, $nearby, $colony, $village, $pincode);
	}

	public static function placeOrder($data) {
		//insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype)
		$customeruserid = $data["customeruserid"];
		$owneruserid = $data["owneruserid"];
		$orderid = "createorderid";
		$productname = $data["productname"];
		$orderprice = $data["orderprice"];
		$orderdiscount = $data["orderdiscount"];
		$productid = $data["productid"];
		$orderdate = $data["orderdate"];
		$orderstatus = $data["orderstatus"];
		$orderaddress = $data["orderaddress"];
		$orderplacedtype = $data["orderplacedtype"];
		$orderdetails = $data["orderdetails"];
		$producttype = $data["producttype"];

		Dboperations::insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype);

	}


	 
}

/**
 * 
 */
class OwnerOperations
{
	public static function registerOwner($data) {
		 	 $ownserUserid = "createdownerid";
		 	 $ownername = $data["ownername"];
			 $email = $data["email"];
			 $password = $data["password"];
			 $phonenumber = $data["phoneNumber"];
			 Dboperations::insertIntoOwnersTable($ownserUserid, $ownername, $email, $password, $phonenumber);
	}

	public static function addProduct($data) {
			$productid = "createpdid";
			$owneruserid = $data["owneruserid"];
			$productname = $data["productname"];
			$description = $data["description"];
			$price = $data["price"];
			$discountprice = $data["discountprice"];
			$discountpercentage = $data["discountpercentage"];
			$producttype = $data["producttype"];
			$sizes = $data["sizes"];
			$productdetails = $data["productdetails"];
			$images = $data["images"];
			
			Dboperations::insertintoProducts($productid, $owneruserid, $productname, $description,$price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images);

	}

	public static function addoffers($data) {
			$owneruserid = $data["owneruserid"];;
			$offerimages = $data["offerimages"];
			$offerpercentage = $data["offerpercentage"];
			Dboperations::insertintoOffersTable($owneruserid, $offerimages, $offerpercentage);
	}

	public static function addImages($data) {
			$productid = "productod";
			$imageid = "imageidcreate";
			$image = $data["image"];
			$imagename = $data["imagename"];
			$owneruserid = $data["owneruserid"];

			Dboperations::insertintoImagesTable($productid, $owneruserid, $imageid, $image, $imagename);
	}

}


?>