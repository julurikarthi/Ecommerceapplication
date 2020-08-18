 <?php

include('ArrayList.php');
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
		} else if ($decoded["params"]["method"] == Constants::$customerlogin) {
			CustomersOperations::customerlogin($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$ownerlogin) {
			OwnerOperations::ownerlogin($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$getAddress) {
			CustomersOperations::getAddress($decoded["params"]["data"]);
		} if ($decoded["params"]["method"] == Constants::$getoffers) {
			CustomersOperations::getoffers($decoded["params"]["data"]);
		} if ($decoded["params"]["method"] == Constants::$getProducts) {
			CustomersOperations::getProducts($decoded["params"]["data"]);
		} if ($decoded["params"]["method"] == Constants::$getImagedata) {
			CustomersOperations::getImagedata($decoded["params"]["data"]);
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
	 public static $customerlogin = "customerlogin";
	 public static $ownerlogin = "ownerlogin";
	 public static $getAddress = "getAddress";
	 public static $getoffers = "getoffers";
	 public static $getProducts = "getProducts";
	 public static $getImagedata = "getImagedata";

}
class UserIDOperations
{
	
	public static function createUserid() {
		return uniqid();
	}
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
		return $con;
	}

	public static function insertIntoOwnersTable($ownserUserid, $name, $email, $password, $phoneNumber) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO OwnersAccountsTable(owneruserid, name, email, password, phonenumber) VALUES ('$ownserUserid', '$name', '$email', '$password', '$phoneNumber')";
		if(mysqli_query($con, $insertQuery)){
	     	return TRUE;
		} else{
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);
	}

	public static function insertintoCustomerTable($customerUserid, $owneruserid, $name, $email, $password, $phoneNumber) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO CustomersTable(customeruserid,owneruserid , customername, email, password, phonenumber) VALUES ('$customerUserid', '$owneruserid', '$name', '$email', '$password', '$phoneNumber')";
		if(mysqli_query($con, $insertQuery)){
			return TRUE;
		} else {
			$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;

		} 
		mysqli_close($con);
	}

	public static function insertintoAddressTable($customeruserid, $plotno, $street, $nearby, $colony, $village, $pincode) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO Addresstable(customeruserid, plotno, street, nearby, colony, village, pincode) VALUES ('$customeruserid', '$plotno', '$street', '$nearby', '$colony', '$village', '$pincode')";
		if(mysqli_query($con, $insertQuery)){
	   		return TRUE;
		} else{
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);
	}

	public static function insertintoOffersTable($owneruserid, $offerimages, $offerpercentage) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO offerstable(owneruserid, offerimages, offerpercentage) VALUES ('$owneruserid', '$offerimages', '$offerpercentage')";
		if(mysqli_query($con, $insertQuery)){
	    	return TRUE;
		} else{
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);
	}


	public static function insertintoProducts($pid, $owneruserid, $productname, $description, $price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images) {
		$con = Dboperations::dbConnection();
		
		$insertQuery = "INSERT INTO Products(productid, owneruserid, productname, description, price, discountprice, discountpercentage, producttype, sizes, productdetails, images) VALUES ('$pid', '$owneruserid', '$productname', '$description', '$price', '$discountprice', '$discountpercentage', '$producttype', '$sizes', '$productdetails', '$images')";

		if(mysqli_query($con, $insertQuery)){
	     	return TRUE;
		} else{
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);

	}


	public static function insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO Orders(customeruserid, owneruserid, orderid, productname, orderprice, orderdiscount, productid, orderdate, orderstatus, orderaddress, orderplacedtype, orderdetails, producttype) 
		VALUES ('$customeruserid', '$owneruserid', '$orderid', '$productname', '$orderprice', '$orderdiscount', '$productid', '$orderdate', '$orderstatus', '$orderaddress', '$orderplacedtype', '$orderdetails', '$producttype')";
		if(mysqli_query($con, $insertQuery)){
	     	return TRUE;
		} else{
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);
	}


	public static function insertintoImagesTable($productid, $owneruserid, $imageid, $file, $imagename) {
		$con = Dboperations::dbConnection();

		$insertQuery = "INSERT INTO ImagesTable(productid, owneruserid, imageid, image,imagename) VALUES ('$productid', '$owneruserid', '$imageid', '$file','$imagename')";

		if(mysqli_query($con, $insertQuery)){
	     	return TRUE;
		} else {
	    	$array = $array = [
						    "status" => "failure"
						];
			$array["error"] = "". mysqli_error($con);
			header('Content-type: application/json');
			echo json_encode($array);
			return FALSE;
		} 
		// Close connection
		mysqli_close($con);

	}

	public static function isregisterCustomer($email,$password) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM CustomersTable WHERE email = '$email'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = [];
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					if($row['password'] == $password) {
					$array["customeruserid"] =  $row['customeruserid']; 
					$array["owneruserid"] =  $row['owneruserid']; 
					$array["customername"] =  $row['customername']; 
					$array["email"] =  $row['email'];
					$array["phonenumber"] =  $row['phonenumber'];
					} else {
						$array["error"] = "password wrong";
					}
			}
		} 
		return $array;
	}

	public static function isregisterOwner($email,$password) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM OwnersAccountsTable WHERE email = '$email'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = [];
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					if($row['password'] == $password) {
					$array["owneruserid"] =  $row['owneruserid']; 
					$array["ownername"] =  $row['name']; 
					$array["email"] =  $row['email'];
					$array["phonenumber"] =  $row['phonenumber'];
					} else {
						$array["error"] = "password wrong";
					}
			}
		} 
		mysqli_close($con);
		return $array;
	}

	public static function iscustomerRegister($email) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select count(email) FROM CustomersTable WHERE email = '$email'";
		$result = mysqli_query($con, $insertQuery);
		$count = mysqli_fetch_row($result)[0];
		if ($count > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
		mysqli_close($con);

	}

	public static function isOwnerRegister($email) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select count(email) FROM OwnersAccountsTable WHERE email = '$email'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_fetch_row($result)[0];
		if ($rowcount > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
		mysqli_close($con);

	}

	public static function getAllAddress($customeruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Addresstable WHERE customeruserid = '$customeruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["plotno"] =  $row['plotno']; 
					$objects["street"] =  $row['street']; 
					$objects["nearby"] =  $row['nearby'];
					$objects["colony"] =  $row['colony'];
					$objects["village"] =  $row['village'];
					$objects["pincode"] =  $row['pincode'];
					// $array[] = $objects;
					// array_push($array, $objects);
					$arrylist->add($objects);
			}
		}
		mysqli_close($con);
		return $arrylist->toArray();
	}


	public static function getAllProducts($owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Products WHERE owneruserid = '$owneruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["productid"] =  $row['productid'];
					$objects["owneruserid"] =  $row['owneruserid']; 
					$objects["productname"] =  $row['productname']; 
					$objects["description"] =  $row['description'];
					$objects["price"] =  $row['price'];
					$objects["discountprice"] =  $row['discountprice'];
					$objects["discountpercentage"] =  $row['discountpercentage'];
					$objects["producttype"] =  $row['producttype'];
					$objects["sizes"] =  $row['sizes'];
					$objects["productdetails"] =  $row['productdetails'];
					$objects["images"] = $row['images'];
					$arrylist->add($objects);
			}
		}
		mysqli_close($con);
		return $arrylist->toArray();
		// "INSERT INTO Products(productid, owneruserid, productname, description, price, discountprice, discountpercentage, producttype, sizes, productdetails, images) VALUES ('$pid', '$owneruserid', '$productname', '$description', '$price', '$discountprice', '$discountpercentage', '$producttype', '$sizes', '$productdetails', '$images')";
	}

	public static function getImage($imageid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select image FROM ImagesTable WHERE imageid = '$imageid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$imagedata = "no Image data";
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
				 $imagedata = $row['image'];
			}
		}
		return $imagedata;

	}

	public static function getAllOffers($owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM offerstable WHERE owneruserid = '$owneruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["offerimages"] =  $row['offerimages']; 
					$objects["offerpercentage"] =  $row['offerpercentage'];
					// array_push($array, $objects);
					$arrylist->add($objects);
			}
		} 
		mysqli_close($con);
		return $arrylist->toArray();
	}

//TODO: get all product and getimages respectiveproduct
	// public static function getALLProducts($owneruserid) {
	// 	$con = Dboperations::dbConnection();
	// 	$insertQuery = "select * FROM Products WHERE owneruserid = '$owneruserid'";
	// 	$result = mysqli_query($con, $insertQuery);
	// 	$rowcount = mysqli_num_rows($result);
	// 	$array = [];
	// 	if ($rowcount > 0) {
	// 		while($row = mysqli_fetch_array($result)) {
	// 				if($row['password'] == $password) {
	// 				$array["owneruserid"] =  $row['owneruserid']; 
	// 				$array["ownername"] =  $row['name']; 
	// 				$array["email"] =  $row['email'];
	// 				$array["phonenumber"] =  $row['phonenumber'];
	// 				} else {
	// 					$array["error"] = "password wrong";
	// 				}
	// 		}
	// 	} 
	// 	return $array;
	// }


}

/**
 * 
 */
class CustomersOperations
{
	
	public static function registerCustomer($data) {

			 if (Dboperations::iscustomerRegister($data["email"]) == TRUE) {
			 	$array = [
						    "status" => "failure", 
						];
				 $array["error"] = "email registered already";
				echo json_encode($array);
			 	exit();
			 }
			 $customername = $data["customername"];
			 $email = $data["email"];
			 $password = $data["password"];
			 $phonenumber = $data["phoneNumber"];
			 $owneruserid = $data["owneruserid"];
			 $custid = UserIDOperations::createUserid();
			 $status = Dboperations::insertintoCustomerTable($custid,$owneruserid,$customername, $email, $password, $phonenumber);
			$array = [
						    "status" => "success",
						];
			header('Content-type: application/json');
			if($status) {
				echo json_encode($array);
			}
			
	}

	public static function getProducts($data) {
			$owneruserid = $data["owneruserid"];
			$array = Dboperations::getAllProducts($owneruserid);
			header('Content-type: application/json');
			if(count($array) > 0) {
				$array["status"] = "success";
			}
			echo json_encode($array);
	}

	public static function customerlogin($data) {
		$email = $data["email"];
		$password = $data["password"];
		$array = Dboperations::isregisterCustomer($email, $password);
		header('Content-type: application/json');
		if(count($array) > 0) {
			$array["status"] = "success";
		} else {
			$array["status"] = "failure";
			$array["error"]  = "user not registered";
		}
		echo json_encode($array);
	}

	public static function getOrders($data) {

	}

	public static function getImagedata($data) {
		$imageid = $data["imageid"];
		$imagedata = Dboperations::getImage($imageid);
		echo $imagedata;
	}

	public static function getAddress($data) {
		$customeruserid = $data["customeruserid"];
		$array = Dboperations::getAllAddress($customeruserid);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);

	}

	public static function getoffers($data) {
		$owneruserid = $data["owneruserid"];
		$array = Dboperations::getAllOffers($owneruserid);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);
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

		$status =  Dboperations::insertintoAddressTable($customeruserid, $plotno, $street, $nearby, $colony, $village, $pincode);

		$array = $array = [
						    "status" => "success",
						];
			header('Content-type: application/json');
			if($status) {
				echo json_encode($array);
			}
	}

	public static function placeOrder($data) {
		//insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype)
		$customeruserid = $data["customeruserid"];
		$owneruserid = $data["owneruserid"];
		$orderid = UserIDOperations::createUserid();
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

		$status = Dboperations::insertintoOrders($customeruserid, $owneruserid, $orderid, $productname, $orderprice, $orderdiscount, $productid, $orderdate, $orderstatus, $orderaddress, $orderplacedtype, $orderdetails, $producttype);


		$array = $array = [
						    "status" => "success",
						];
			header('Content-type: application/json');
			if($status) {
				echo json_encode($array);
			}

	}


	 
}

/**
 * 
 */
class OwnerOperations
{
	public static function registerOwner($data) {

			 if (Dboperations::isOwnerRegister($data["email"]) == TRUE) {
			 	$array = [
						    "status" => "failure", 
						];
				 $array["error"] = "email registered already";
				echo json_encode($array);
			 	exit();
			 }

		 	 $ownserUserid = UserIDOperations::createUserid();
		 	 $ownername = $data["ownername"];
			 $email = $data["email"];
			 $password = $data["password"];
			 $phonenumber = $data["phoneNumber"];
			 $status = Dboperations::insertIntoOwnersTable($ownserUserid, $ownername, $email, $password, $phonenumber);

			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}
	}

	public static function getAllOrders($owneruserid) {

	}


	public static function ownerlogin($data) {
		$email = $data["email"];
		$password = $data["password"];
		$array = Dboperations::isregisterOwner($email, $password);
		header('Content-type: application/json');
		if(count($array) > 0) {
			$array["status"] = "success";
		} else {
			$array["status"] = "failure";
			$array["error"]  = "user not registered";
		}
		echo json_encode($array);
	}

	public static function getAllCustomers($owneruserid) {

	}

	public static function deleteProduct($productid) {

	}

	public static function addProduct($data) {
			$productid = UserIDOperations::createUserid();
			$owneruserid = $data["owneruserid"];
			$productname = $data["productname"];
			$description = $data["description"];
			$price = $data["price"];
			$discountprice = $data["discountprice"];
			$discountpercentage = $data["discountpercentage"];
			$producttype = $data["producttype"];
			$sizes = $data["sizes"];
			$productdetails = $data["productdetails"];		
			$images = $data['images'];	
			$status = Dboperations::insertintoProducts($productid, $owneruserid, $productname, $description,$price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images);
			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}


	}

	public static function addoffers($data) {
			$owneruserid = $data["owneruserid"];;
			$offerimages = $data["offerimages"];
			$offerpercentage = $data["offerpercentage"];
			$status = Dboperations::insertintoOffersTable($owneruserid, $offerimages, $offerpercentage);
			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}
	}

	public static function addImages($data) {
			$productid = "productod";
			$imageid = UserIDOperations::createUserid();
			$image = $data["image"];
			$imagename = $data["imagename"];
			$owneruserid = $data["owneruserid"];

			$status = Dboperations::insertintoImagesTable($productid, $owneruserid, $imageid, $image, $imagename);
			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}
	}


}

/**
 * 
 */


?>
