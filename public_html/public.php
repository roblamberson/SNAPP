<?php



/**
 * Hander file for public testing of php class or whatever
 *
 *
 * PHP version 7.2
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
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


$config = include('../config.php');

require $config["php_dir"]."/Database.php";

require $config["php_dir"]."/Community.php";

use Snapp\User;

/*
  _    _                 _    _ _   _ _ _ _   _           
 | |  | |               | |  | | | (_) (_) | (_)          
 | |  | |___  ___ _ __  | |  | | |_ _| |_| |_ _  ___  ___ 
 | |  | / __|/ _ \ '__| | |  | | __| | | | __| |/ _ \/ __|
 | |__| \__ \  __/ |    | |__| | |_| | | | |_| |  __/\__ \
  \____/|___/\___|_|     \____/ \__|_|_|_|\__|_|\___||___/*/

/*			CREATING A USER			*/
/*
$details = array( "username"=>"bullshit", "email"=>"brian@mydomain.com", "password"=>"whatever" );

$Client = new User( $details );
//echo $Client->username_required;
 echo $Client->Mode;
 echo "<br>";

if( $Client->Result ){
	
	echo "new user id is ".$Client->id;
	
}else{
	
	echo "new user creation failed - ".$Client->Fault;
	
}
*/

/*		LOGIN		*/
/*
// instatiate the User object with either the username
// or the email as it's only parameter
$Client = new User( "bullshit" );
// Use the Recognize function to apply the 
// supposed password for validation
if( $Client->Recognize('whatever') ){
	
	// if Recognize does not fail access the basic
	// account details using Account()
	$details = $Client->Account();
	
	echo "User \"".$details["username"]."\" with email address \"".$details["email"]."\" is reported to be logged in at ".date('m/d/Y H:i:s', $details["last_login"]);

}else{
	
	echo "fail: ".$Client->Fault;
}
*/

 
 
 
 ?>