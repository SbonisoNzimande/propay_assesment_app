<?php
/**
 * @package  
 * @author   Sboniso Nzimande
 * @abstract
 */
abstract class AppModel 
{
	/* Connection variable */
	static public $mysqli;
	// static public $web_mysqli;
	static public $mssql;

	public function __construct() {
		self::$mysqli      = new PDODB;
		
		// self::$mssql       = new MsSqlDB;// Connect to a MsSql database

		self::change_timezone();
	}


	/**
	 * @param  
	 * @return 
	 */
	static public function get_all_people_db () {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM `people`");

			$statement->execute();

			$row 		= $statement->fetchAll(); 
			// var_dump($row);

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_user_by_name_db ($username) {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM users WHERE username = :username");
			$statement->execute(array(":username" => $username));

			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}
	
	/**
	 * @param  
	 * @return 
	 */
	static public function get_user_by_password_db ($password) {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM users WHERE password = :password");
			$statement->execute(array(":password" => $password));

			$row 		= $statement->fetch(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}


	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_user_db ($Username, $Email, $Password) {

		try{
			$statement 	= self::$mysqli->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
			$return 	= $statement->execute(
								array(
									":username" => $Username,
									":email" => $Email,
									":password" => $Password
							));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_person_db (
								$first_name,
								$last_name,
								$language,
								$dob,
								$mobile,
								$email
							) {

		try{

			$query 		= "
							INSERT INTO people (
							  first_name,
							  surname,
							  mobile,
							  email,
							  language,
							  date_of_birth
							) 
							VALUES
							  (
							  :first_name, 
							  :surname, 
							  :mobile, 
							  :email, 
							  :language, 
							  :date_of_birth
							  );
							";


			$statement 	= self::$mysqli->prepare($query);
			$return 	= $statement->execute(
								array(
									":first_name" 		=> $first_name,
									":surname" 			=> $last_name,
									":mobile" 			=> $mobile,
									":email" 			=> $email,
									":language" 		=> $language,
									":date_of_birth" 	=> $dob
							));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}




	////////////////-------- VIP -----////////////////
	/**
	 * @param  
	 * @return 
	 */
	static public function change_timezone () {

		$query 		= "SET @@session.time_zone = '+02:00';";

		$stmt   	= self::$mysqli->query($query) or die('Failed to prepare: ' . self::$mysqli->error());

		return $stmt;
	}

	/**
	 * Escape string
	 * 
	 * @param  $string
	 * @return string
	 */
	static public function clean_string ($string) {
		return self::$mysqli->escape_string ($string);
		// return $string;
	}

	/**
	 * Fomat query results to an array
	 * 
	 * @param  $salesCode 
	 * @return boolen
	 */
	static public function fetch_array_mssql ($result) {
		$results = array();
		$count   = 0;
		if (!$result) {
			return 'Error: ' . self::$mysqli->error();
		}else{
			/* fetch value */
			while($row = self::$mssql->fetch_array($result)) {
				// Push results in array
				array_push($results, $row);
				$count++;
			}
			return $results;
		}

	}

	/**
	 * Fetch Assoc
	 * 
	 * @param  $salesCode 
	 * @return boolen
	 */
	static public function fetch_assoc_arr ($result) {
		$results = array();
		$count   = 0;

		if (!$result) {
			printf("Error: %s\n", self::$mysqli->error());
			exit();
		} else {
			/* fetch value */
			while($row = $result->fetch_array (MYSQLI_ASSOC)){
				// Push results in array
				array_push($results, $row);
				$count++;
			}
			return $results;
		}

	}

}