<?php

namespace Snapp;

/**
 * access control for delivery system
 *
 * User account  and information, client interactions, user information
 * Creates accounts and roles for user
 *
 * PHP version 7.2
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 * 
 * User creation failures result in following messages:
 * "email required"
 * "username required"
 * "password required" 
 * 
 * Login failures result in following messages:
 * login_fail:username or email not found
 * Invalid Credentials
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */
 /*
class Fault {
	
	public function __construct(){
		
		
		
	}
	
}
*/
class User {

    /**
     * The activity that the class object is 
     * being used for
     *
     * @var string
     * @access public
     */	public $Mode;
	
    /**
     * The status of the current operation
     *
     * Is instantiated during class construction
     * as true and should be set to false whenever
     * the intended operation is not going to be
     * able to be executed..
     *
     * @var bool
     * @access public
     */	public $Result;
     
    /**
     * Error or failure information
     *
     * This should be used to store a message or concise 
     * explanation regarding a failure or problem.
     *
     * @var string
     * @access public
     */	public $Fault;
	
    /**
     * Used to store verification of whether 
     * email is a required identifier needed
     * to create a user account.
     *
     * Set by required_identifiers() during construct
     *
     * @var bool
     * @access private
     */	private $_email_required;
	
    /**
     * Used to store verification of whether a
     * username is required to create a user account.
     *
     * Set by required_identifiers() during construct
     *
     * @var bool
     * @access private
     */	private $_username_required;
	
    /**
     * Used to store current timestamp that
     * may be used to verify a user login.
     *
     * @var int
     * @access private
     */	private $_run_time;	
	
	
	
	
	
	// ----------------------------
	// USER DATA VARIABLES
	public $id;

    public $email;
    
    public $username;
    
    public $password;
    
    public $registered;
    
    public $last_login;
    
 //   public $ip_address;
    
   // public $reg_code;
    
  //  private $error;
    
  //  public $errors;
    
  //  private $error_i;
	
	// user
	// `id`, `email`, `password`,  `username`, `status`, 
	//` verified`, `resettable`, `roles_mask`, `registered`, `
	// last_login`, `force_logout`
	
	//`users_details`
	// `user_id`, `first_name`, `last_name`, `organization`, 
	//` titles`, `city`, `country`, `about_me`, `email`, `website`, 
	// `telephone`, `cellular`, `social_profile_url`, `updated`

  //  private $reqs;
	
	
    /**
     * __construct( $params )
     * 
     * - Instantiates the User object
     * - Discerns intended use (Mode)
     * - Prepares data or executes necessary
     *   actions to actualize a user using
     *   the information given to it
     *
     * Everything mentioned above should be mostly completed within
     * the class contructor.
     *
     * Examples:
     *	 __construct( array() )
     * 
     *   + Sets property Mode to "New User"
     *   + Checks config file to see if username and/or email
     *	   is required for user account creation
     *   + Checks that required identifies are present
     *	   and if not, calls abort() with error message
     *	 + Checks for password and creates hash for
     *	   insertion into database
     *		TODO: check password for strength
     *	 + Inserts basic user details into 'users' table
     *   + Assigns $id from lastInsertId func in dbase class

     *
     * @param string $arg1 the string to quote
     * @param int    $arg2 an integer of how many problems happened.
     *                     Indent to the description's starting point
     *                     for long ones.
     *
     * @return int the integer of the set mode used. FALSE if foo
     *             foo could not be set.
     * @throws exceptionclass [description]
     *
     * @access public
     * @static
     * @see Net_Sample::$foo, Net_Other::someMethod()
     * @since Method available since Release 1.2.0
     * @deprecated Method deprecated in Release 2.0.0
     */	
	public function __construct( $params ){
		
		$this->Result = true;
		
		$this->_run_time = time();
		
		if( is_array( $params ) ){
			
			$this->Mode = "NEW USER";
			
			$this->required_identifiers();
			
			if( $this->_email_required ){
				
				if( $params["email"] && $this->is_email( $params["email"] ) ){
					
					$this->email = $params["email"];
					
				}else{
					
					$this->abort( "email required" );
					
				}
				
			}
			
			if( $this->_username_required ){
				
				if( $params["username"] ){
					
					$this->username = $params["username"];
					
				}else{
					
					$this->abort( "username required" );
					
				}
				
			}
			
			if( $params["password"] ){

		        $options = [
		            'salt' => "123456abcdefghijk7890l", //write your own code to generate a suitable salt
		            'cost' => 12 // the default cost is 10
		        ];

        		$this->password = password_hash( $params["password"], PASSWORD_DEFAULT, $options );

			}else{
				
				$this->abort( "password required" );
				
			}
			
			if( $this->Result ){
				
				$this->id = $this->create_user();
				
				
			}
			
			
		}else if( is_int( $params ) ){
			
			$this->Mode = "USER DATA";
			
			
		}else if( is_string( $params ) ){
			
			if( $this->is_email( $params ) ){
				
				// put a property in config to specify
				// if email, username or both used to login
				
				$this->Mode = "EMAIL LOGIN";
				
				
			}else{
				
				$this->Mode = "USERNAME LOGIN";
				
				
			}
			
			$info = $this->look( $params );
			
			if( $info ){
			
				$this->password = $info["password"];
				$this->username = $info["username"];
				$this->email = $info["email"];
				$this->id = $info["id"];
				$this->registered = $info["registered"];
				$this->last_login = $info["last_login"];
				
			}else{
				
				$this->abort( "login_fail:username or email not found" );
				
			}
			
		}
		
	}
	
	// Checks if the string provided appears to be an email address
	protected function is_email( $string ) {
		
    	return !!filter_var($string, FILTER_VALIDATE_EMAIL);
	
	}
	
	/*
		Checks the configuration file to determine what user id details
		are required for registration.
	*/
	protected function required_identifiers(){
		
		global $config;

		$this->_email_required = ( in_array("email", $config["registration"]["required"]) ) ? true : false; 

		$this->_username_required = ( in_array("username", $config["registration"]["required"]) ) ? true : false; 
		
	}
	
	protected function abort( $message ){
		
    	$this->Result = false;
	
		$this->Fault = $message;		
		
	}
	
	protected function create_user(){
		
		global $database;
		
		$details = array(	"email"			=>	$this->email,
							"password"		=>	$this->password,
							"username"		=>	$this->username,
							"status"		=>	1,
							"registered"	=>	$this->_run_time,
							"last_login"	=>	$this->_run_time);
		
		$database->insert("users", $details);
		
        return $database->id();
		
	}
	
	public function look( $ident ){
		
		global $database;
		
		$details = array("id", "email", "password", "username", "registered", "last_login");
		
		if( $this->Mode == "EMAIL LOGIN" ){
			
			$method = "email";
			
		}else if( $this->Mode == "USERNAME LOGIN" ){
			
			$method = "username";
			
		}
		
		$info = $database->select("users", $details, [$method => $ident]);
		
		if( $info ){
			
			return $info[0];
			
		}else{
			
			return false;
			
		}
		
	}
	
    public function Recognize( $password ){
    	
    	global $database;

        if( password_verify( $password, $this->password ) ){
        	
        	$this->last_login = $this->_run_time;
        	
        	// update the 'users' table with last_login time
            return $database->update("users", ['last_login'=>$this->last_login], ['id'=>$this->id]);
            
        }else{
            // Invalid credentials
            $this->abort("login_fail: Invalid Credentials");
            
            return false;

        }

    }

	public function Account(){
		
		if( $this->last_login == $this->_run_time ){
			
			return array(	"id"			=>	$this->id,
							"username"		=>	$this->username,
							"email"			=>	$this->email,
							"last_login"	=>	$this->last_login,
							"registered"	=>	$this->registered	);
			
		}else{
			
			false;
			
		}
		
		
	}
	
	
	
}

?>