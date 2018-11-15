<?php

require 'phpass-0.5/PasswordHash.php';

$account_page = "index.php";

$config = parse_ini_file('config.ini'); 

// Base-2 logarithm of the iteration count used for password stretching
$hash_cost_log2 = $config['hash_cost'] ?: 8;
// Do we require the hashes to be portable to older systems (less secure)?
$hash_portable = $config['portable'] ?: FALSE;

// Are we debugging this code?  If enabled, OK to leak server setup details.
$debug = $config['debug'] ?: FALSE;

function fail($pub, $pvt = '')
{
	global $debug;
	$msg = $pub;
	if ($debug && $pvt !== '')
		$msg .= ": $pvt";
/* The $pvt debugging messages may contain characters that would need to be
 * quoted if we were producing HTML output, like we would be in a real app,
 * but we're using text/plain here.  Also, $debug is meant to be disabled on
 * a "production install" to avoid leaking server setup details. */
	exit("An error occurred ($msg).\n");
}
//this function has to do with fixing an error on depreciated versions of php. 
function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}

header('Content-Type: text/plain');

$op = $_POST['op'];
if ($op !== 'new' && $op !== 'login' && $op !== 'change' && $op !== 'admin_pass')
	fail('Unknown request');

$user = strtolower(get_post_var('user'));
/* Sanity-check the username, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!preg_match('/^[a-zA-Z0-9_@.]{1,60}$/', $user))
	fail('Invalid username');

$pass = get_post_var('pass');
/* Don't let them spend more of our CPU time than we were willing to.
 * Besides, bcrypt happens to use the first 72 characters only anyway. */
if (strlen($pass) > 72)
	fail('The supplied password is too long');

$db = new mysqli($config['host'], $config['user'], $config['pass'], $config['name'], $config['port']);
if (mysqli_connect_errno())
	fail('MySQL connect', mysqli_connect_error());

$hasher = new PasswordHash($hash_cost_log2, $hash_portable);

if ($op === 'admin_pass'){
	session_start();
	$admin = $_SESSION['user'];
	$adminpass = get_post_var('admin_pass');
	$hash = '*'; // In case the user is not found
	($stmt = $db->prepare('SELECT pass, admin FROM accounts WHERE user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $admin)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($hash, $perm)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);
	if ($hasher->CheckPassword($adminpass, $hash) && $perm === 1) {
		$stmt->close();
		admin_password_change($hasher,$db,$user,$pass);
		
	} else {
		$stmt->close();
		$db->close();
		$what = 'Authentication failed';
		$op = 'fail'; // Definitely not 'change'
		header('Location: ../administration.php?msg=' . urlencode(base64_encode("This password has Failed to be changed!")));
	}
}
function admin_password_change($hasher,$db,$user,$pass){
	
	$hash = $hasher->HashPassword($pass);
	if (strlen($hash) < 20)
		fail('Failed to hash new password');
	unset($hasher);

	($stmt = $db->prepare('update accounts set pass=? where user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('ss', $hash, $user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->close();
	$db->close();
	header('Location: ../administration.php?msg=' . urlencode(base64_encode("This password has successfully been changed!")));
	
}
if ($op === 'new') {
	$hash = $hasher->HashPassword($pass);
	if (strlen($hash) < 20)
		fail('Failed to hash new password');
	unset($hasher);

	($stmt = $db->prepare('insert into accounts (user, pass) values (?, ?)'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('ss', $user, $hash)
		|| fail('MySQL bind_param', $db->error);
	if (!$stmt->execute()) {
/* Figure out why this failed - maybe the username is already taken?
 * It could be more reliable/portable to issue a SELECT query here.  We would
 * definitely need to do that (or at least include code to do it) if we were
 * supporting multiple kinds of database backends, not just MySQL.  However,
 * the prepared statements interface we're using is MySQL-specific anyway. */
		if ($db->errno === 1062 /* ER_DUP_ENTRY */)
			fail('This username is already taken');
		else
			fail('MySQL execute', $db->error);
	}

	$what = 'User created';
	header('Location: ../'.$account_page.'?msg=' . urlencode(base64_encode("User successfully created!")));
} else {
	$hash = '*'; // In case the user is not found
	($stmt = $db->prepare('select pass, admin from accounts where user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($hash, $admin)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);

	if ($hasher->CheckPassword($pass, $hash)) {
		$what = 'Authentication succeeded';
		
	} else {
		$what = 'Authentication failed';
		$op = 'fail'; // Definitely not 'change'
	}
	if ($op === 'change') {
		$stmt->close();

		$newpass = get_post_var('newpass');
		if (strlen($newpass) > 72)
			fail('The new password is too long');
		$hash = $hasher->HashPassword($newpass);
		if (strlen($hash) < 20)
			fail('Failed to hash new password');
		unset($hasher);

		($stmt = $db->prepare('update accounts set pass=? where user=?'))
			|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $hash, $user)
			|| fail('MySQL bind_param', $db->error);
		$stmt->execute()
			|| fail('MySQL execute', $db->error);

		$what = 'Password changed';
	}
	unset($hasher);
}

$stmt->close();
$db->close();

echo "$what\n";
if($what === 'Authentication succeeded'){	
	session_start();
	$_SESSION['user'] = $user;
	$_SESSION['admin'] = $admin;
	header("location: ../".$account_page);
}
if($what === 'Password changed'){	
	header('Location: ../'.$account_page.'?msg=' . urlencode(base64_encode("Your password has successfully been changed!")));
}

?>
