<?php
class hive {
var $username;
var $password;
var $servername;
var $dbname;

public function logincode() {
	$url = htmlentities(trim($_SERVER['PHP_SELF']));
	return <<< THEHTML
	<form class="login" action="$url" method="POST">
	<label for="username">Username</label>
	<input name="username" type="text" /><br/>
	<label for="password">Password</label>
	<input name="password" type="password" /><br/>
	<input id="submit" type="submit" value="Enter My Hive"/>
	</form>
THEHTML;
}

public function connect() {
	@mysql_connect($this->servername,$this->username,$this->password) or die("Failed to connect to MySQL Server");
	mysql_select_db($this->dbname) or die("Failed to select the database <b>$this->dbname</b>. Please makes sure it exists or create one.");
	return $this->database();
}

function images() {
	$limit=$this->findmax();
	$random=rand()%10;
	$nextrand=$random;
	while($nextrand==$random)
		$nextrand=rand()%$limit;
	$resource=$this->query("SELECT * FROM $this->tablename WHERE sno=$random OR sno=$nextrand");
	while($res=mysql_fetch_row($resource)) {
		echo $res['image'];
	}
	//<td><img src="owl.png" height=100 width=100/></td>
	//<td><img src="ae.gif" height=100 width=100/></td>
}

function findmax() {
	$query=$this->query("SELECT count(*) FROM $this->tablename");
	if($count=mysql_fetch_row($query)) {
		if($count[0]>0)
		return $count[0];
		else {
		echo "No images found! Use the upload button to add images";
		exit;
		}
	  }
	else {
	echo "Internal SELECT error. Contact the Web Administrator";
	exit;
	}
}

function query($sql) {
	return mysql_query($sql) or die("Query Failed");
}

private function database() {
	return $this->buildaccounts();
}

private function buildaccounts() {
/* Builds the table to store the accounts
 * Maximum of 99999 users can be accommodated as int(5)
 * Username and Password is of length 30. Use Server Side checking to validate this
 * on registration as well as login to prevent buffer overflow (hack) attacks
 * beename is the real full name of the person
 * dob is a string to represent Dob fields
 * Social fields may or may not be specified
 * Education is | delimited sequence of fields for different institutions
 * nol is number of logins used for statistical reasons. When it cross 99999 must be reset
 * Maximum email ID size is 50 even though the standard is 254 (validate this field too)
 * Secondary Mail ID is used for rescue purposes
 * address field is | delimited field for each address line
 * wordaddr field is also | delimited values
 * Secret Qn and Answer is obviously for rescue purpose
 * creation defines the time of creating the account
 * active 0 -> not activated, 1 -> active, 2 -> blocked
 */
	$sql = <<< BUILACCOUNTSTABLE
	CREATE TABLE IF NOT EXISTS accounts (
	sno INT(5) PRIMARY KEY,
	hivename VARCHAR(30) NOT NULL,
	hivepass VARCHAR(30) NOT NULL,
	beename VARCHAR(40) NOT NULL,
	mobile VARCHAR(13) NOT NULL,
	landline VARCHAR(10) DEFAULT 0,
	dob VARCHAR(30) NOT NULL,
	facebook VARCHAR(30),
	twitter VARCHAR(30),
	linkedin VARCHAR(30),
	googleplus VARCHAR(30),
	skype VARCHAR(30),
	education MEDIUMTEXT NOT NULL,
	nol int(5) NOT NULL,
	emailid VARCHAR(50) NOT NULL,
	addr MEDIUMTEXT NOT NULL,
	workaddr MEDIUMTEXT NOT NULL,
	secemailid VARCHAR(50) DEFAULT 0,
	secqn VARCHAR(150),
	secans VARCHAR(50),
	creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	active ENUM(  '0',  '1',  '2' ) NOT NULL DEFAULT  '0'
	)
BUILACCOUNTSTABLE;
	mysql_query($sql);
}

}
?>