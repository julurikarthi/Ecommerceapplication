 <?php

include('ArrayList.php');
include('DBValues.php');
 //Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){

//Make sure that the content type of the POST request has been set to application/json
		
		$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

		// if(strcasecmp($contentType, 'application/json') != 0){
  //  			 throw new Exception('Content type must be: application/json');
		// }

		//Receive the RAW post data.
		error_log(print_r("content-type ".$contentType, TRUE)); 
		$content = trim(file_get_contents("php://input"));

		//Attempt to decode the incoming RAW post data from JSON.
		$decoded = json_decode($content, true);
		error_log(print_r($decoded, TRUE));

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
		} else if ($decoded["params"]["method"] == Constants::$getOrders) {
			OwnerOperations::getOrders($decoded["params"]["data"]);
		} if ($decoded["params"]["method"] == Constants::$getCustomerOrders) {
			CustomersOperations::getCustomerOrders($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$deleteOwnerProduct) {
			OwnerOperations::deleteOwnerProduct($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addcategory) {
			OwnerOperations::addcategory($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$addsubcategory) {
			OwnerOperations::addsubcategory($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$getcategories) {
			OwnerOperations::getcategories($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$getSubcategories) {
			OwnerOperations::getSubcategories($decoded["params"]["data"]);
		} else if ($decoded["params"]["method"] == Constants::$getcatProducts) {
			CustomersOperations::getcatProducts($decoded["params"]["data"]);
		}
		
}

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0){

	if (!empty($_GET['test'])) {
		header('Content-Type: application/json');
		echo "working";
		exit();
		return;
	}

	if(!empty($_GET['imageid'])) {
		//Attempt to decode the incoming RAW post data from JSON.
		// $decoded = json_decode($_GET["params"],true);

		//If json_decode failed, the JSON is invalid.
		// if(!is_array($decoded)){
  // 			  throw new Exception('Received content contained invalid JSON!');
		// }
		// echo $_GET["image"];
		CustomersOperations::getImage($_GET["imageid"]);
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
	 public static $getImage = "getImage";
	 public static $getOrders = "getOrders";
	 public static $getCustomerOrders = "getCustomerOrders";
	 public static $deleteOwnerProduct = "deleteOwnerProduct";
	 public static $addcategory = "addcategory";
	 public static $addsubcategory = "addsubcategory";
	 public static $getcategories = "getcategories";
	 public static $getSubcategories = "getSubcategories";
	 public static $getcatProducts = "getcatProducts";

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
		$servername = DBValues::$servername;
	    $username = DBValues::$username;
	    $password = DBValues::$password;
	    $dbname = DBValues::$dbname;

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

	public static function insertintoCategory($parentcatid, $categoryId, $category, $subcategoryname, $owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO Categorys(parentId, categoryId, category, subcategory, owneruserid) VALUES ('$parentcatid', '$categoryId', '$category', '$subcategoryname', '$owneruserid')";
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

	public static function insertSubcategory($parentcatid, $categoryId, $subcategoryname) {
		$con = Dboperations::dbConnection();
		$insertQuery = "UPDATE Categorys SET subcategory='$subcategoryname', categoryId='$categoryId' WHERE parentId='$parentcatid'";
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


	public static function insertintoProducts($pid, $owneruserid, $productname, $description, $price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images, $category) {
		$con = Dboperations::dbConnection();
		
		$insertQuery = "INSERT INTO Products(productid, owneruserid, productname, description, price, discountprice, discountpercentage, producttype, sizes, productdetails, images, category) VALUES ('$pid', '$owneruserid', '$productname', '$description', '$price', '$discountprice', '$discountpercentage', '$producttype', '$sizes', '$productdetails', '$images', '$category')";

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


	public static function insertintoOrders($customeruserid, $owneruserid, $orderid, $ordertotalamount, $orderdate, $orderplacedtype, $orderstatus, $addressid, $productid, $productname, $productprice, $productdiscount, $productdescription, $productquantity) {
		$con = Dboperations::dbConnection();
		$insertQuery = "INSERT INTO Orders(customeruserid, owneruserid, orderid, ordertotalamount, orderdate, orderplacedtype, orderstatus, addressid, productid, productname, productprice, productdiscount, productdescription, productquantity) 
		VALUES ('$customeruserid', '$owneruserid', '$orderid', '$ordertotalamount', '$orderdate', '$orderplacedtype', '$orderstatus', '$addressid', '$productid', '$productname', '$productprice', '$productdiscount', '$productdescription', '$productquantity')";
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
		$array["address"] = $arrylist->toArray();
		return $array;
	}


	public static function getAllProducts($owneruserid, $offset) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Products WHERE owneruserid = '$owneruserid' LIMIT 40 OFFSET $offset";
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
					$objects["category"] = $row['category'];
					$arrylist->add($objects);
			}
		}
		mysqli_close($con);
		$array["products"] = $arrylist->toArray();
		return $array;
	}

	public static function getcatAllproduct($owneruserid, $offset, $categoryId) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Products WHERE owneruserid = '$owneruserid' and category = '$categoryId' LIMIT 40 OFFSET $offset";
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
					$objects["category"] = $row['category'];
					$arrylist->add($objects);
			}
		}
		mysqli_close($con);
		$array["products"] = $arrylist->toArray();
		return $array;
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
		$array["offers"] = $arrylist->toArray();
		return $array;
	}

	public static function getAllOrders($owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Orders WHERE owneruserid = '$owneruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["customeruserid"] = $row['customeruserid'];
					$objects["owneruserid"] = $row['owneruserid'];
					$objects["orderid"] = $row['orderid'];
					$objects["ordertotalamount"] = $row['ordertotalamount'];
					$objects["orderdate"] = $row['orderdate'];
					$objects["orderplacedtype"] = $row['orderplacedtype'];
					$objects["addressid"] = $row['addressid'];
					$objects["orderstatus"] = $row['orderstatus'];
					$objects["productid"] = $row['productid'];
					$objects["productname"] = $row['productname'];
					$objects["productprice"] = $row['productprice'];
					$objects["productdiscount"] = $row['productdiscount'];
					$objects["productdescription"] = $row['productdescription'];
					$objects["productquantity"] = $row['productquantity'];
					// array_push($array, $objects);

					$arrylist->add($objects);
			}
		} 
		mysqli_close($con);
		$array["orders"] = $arrylist->toArray();
	    return $array;
	}

	public static function getCustomerAllOrders($owneruserid, $customeruserid){
		$con = Dboperations::dbConnection();
		$insertQuery = "select * FROM Orders WHERE owneruserid = '$owneruserid' and customeruserid = '$customeruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["customeruserid"] = $row['customeruserid'];
					$objects["owneruserid"] = $row['owneruserid'];
					$objects["orderid"] = $row['orderid'];
					$objects["ordertotalamount"] = $row['ordertotalamount'];
					$objects["orderdate"] = $row['orderdate'];
					$objects["orderplacedtype"] = $row['orderplacedtype'];
					$objects["addressid"] = $row['addressid'];
					$objects["orderstatus"] = $row['orderstatus'];
					$objects["productid"] = $row['productid'];
					$objects["productname"] = $row['productname'];
					$objects["productprice"] = $row['productprice'];
					$objects["productdiscount"] = $row['productdiscount'];
					$objects["productdescription"] = $row['productdescription'];
					$objects["productquantity"] = $row['productquantity'];
					// array_push($array, $objects);

					$arrylist->add($objects);
			}
		}
		$array["orders"] = $arrylist->toArray();
		mysqli_close($con);
	    return $array;
	}

	public static function getparentcategories($owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select parentId, category FROM Categorys WHERE owneruserid = '$owneruserid'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["parentId"] =  $row['parentId']; 
					$objects["category"] =  $row['category']; 
					$arrylist->add($objects);
				}
		}
		$array["categories"] = $arrylist->toArray();
		mysqli_close($con);
		return $array;

	}

	public static function getsubcategories($parentId) {
		$con = Dboperations::dbConnection();
		$insertQuery = "select categoryId, subcategory FROM Categorys WHERE parentId = '$parentId'";
		$result = mysqli_query($con, $insertQuery);
		$rowcount = mysqli_num_rows($result);
		$array = array();
		$arrylist = new ArrayList;
		if ($rowcount > 0) {
			while($row = mysqli_fetch_array($result)) {
					$objects = [];
					$objects["categoryId"] =  $row['categoryId']; 
					$objects["subcategory"] =  $row['subcategory']; 
					$arrylist->add($objects);
				}
		}
		$array["categories"] = $arrylist->toArray();
		mysqli_close($con);
		return $array;

	}

	public static function deleteProduct($productid,$owneruserid) {
		$con = Dboperations::dbConnection();
		$insertQuery = "DELETE FROM Orders WHERE owneruserid = '$owneruserid' and productid = '$productid'";
		// $result = mysqli_query($con, $insertQuery);
		$array = array();
		if ($con->query($insertQuery) === TRUE) {
			$array[ "status"] =  "success";
			} else {
				$array["status"] = "failure";
				$array["error"] = $con->error;
			}  
		return $array;
	}

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
			$offcet = $data["pagenumber"];
			$offcet = $offcet * 40;

			$array = Dboperations::getAllProducts($owneruserid, $offcet);
			header('Content-type: application/json');
			if(count($array) > 0) {
				$array["status"] = "success";
			}
			echo json_encode($array);
	}

	public static function getcatProducts($data) {
			$owneruserid = $data["owneruserid"];
			$offcet = $data["pagenumber"];
			$offcet = $offcet * 40;
			$category = $data["categoryId"];
			$array = Dboperations::getcatAllproduct($owneruserid, $offcet, $category);
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
		$status = FALSE;
		$customeruserid = $data["customeruserid"];
		$owneruserid = $data["owneruserid"];
		$orderid = UserIDOperations::createUserid();
		$ordertotalamount = $data["ordertotalamount"];
		$orderdate = $data["orderdate"];
		$orderplacedtype = $data["orderplacedtype"];
		$addressid = $data["addressid"];
		$products = $data["products"];
		$orderstatus = "New";
		foreach ($products as $product) {
			$productid = $product["productid"];
			$productname = $product["productname"];
			$productprice = $product["productprice"];
			$productdiscount = $product["productdiscount"];
			$productdescription = $product["productdescription"];
			$productquantity = $product["productquantity"];
			$status = Dboperations::insertintoOrders($customeruserid, $owneruserid, $orderid, $ordertotalamount, $orderdate, $orderplacedtype, $orderstatus, $addressid, $productid, $productname, $productprice, $productdiscount, $productdescription, $productquantity);

		}
		$array = $array = [
						    "status" => "success",
						];
			header('Content-type: application/json');
			if($status) {
				echo json_encode($array);
			}

	}

	public static function getImage($imageid) {
		$data = "";
		$imagebase64 = Dboperations::getImage($imageid);
		$array = array();
		$array["status"] = "success";
		$array["image"] = $imagebase64;
		echo json_encode($array);
		// echo '<img src="' . $imagebase64 . '" />';
	}

	public static function getCustomerOrders($data) {
		$customeruserid = $data["customeruserid"];
		$owneruserid = $data["owneruserid"];
		$array = Dboperations::getCustomerAllOrders($owneruserid, $customeruserid);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);
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

	public static function getOrders($data) {
		$owneruserid = $data["owneruserid"];
		$array = Dboperations::getAllOrders($owneruserid);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);
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

	public static function deleteOwnerProduct($data) {
		$productid = $data["productid"];
		$owneruserid = $data["owneruserid"];
		$array = Dboperations::deleteProduct($productid, $owneruserid);
		echo json_encode($array);
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
			$category = $data['category'];
			$status = Dboperations::insertintoProducts($productid, $owneruserid, $productname, $description,$price, $discountprice, $discountpercentage, $producttype, $sizes, $productdetails, $images, $category);
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
			$productid = "productid";
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

	public static function addcategory($data) {
		$category = $data["title"];
		$owneruserid = $data["owneruserid"];
		$parentcatid = UserIDOperations::createUserid();
		$categoryId = "";
		$subcategoryname = "";
		$status = Dboperations::insertintoCategory($parentcatid, $categoryId, $category, $subcategoryname, $owneruserid);
			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}

	}

	public static function addsubcategory($data) {
		$catname = $data["title"];
		$parentId = $data["parentId"];
		$subcategoryId = UserIDOperations::createUserid();
		$status = Dboperations::insertSubcategory($parentId, $subcategoryId, $catname);
			$array = $array = [
							    "status" => "success",
							];
				header('Content-type: application/json');
				if($status) {
					echo json_encode($array);
				}

	}

	public static function getcategories($data) {
		$owneruserid = $data["owneruserid"];
		$array = Dboperations::getparentcategories($owneruserid);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);
	}

	public static function getSubcategories($data) {
		$parentId = $data["parentId"];
		$array = Dboperations::getsubcategories($parentId);
		header('Content-type: application/json');
		$array["status"] = "success";
		echo json_encode($array);

	}

}

/**
 * 
 */


?>
