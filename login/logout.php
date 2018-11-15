<?php
	session_start();
	if(isset($_SESSION['user'])){
        $_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
    }
    header('Location: ../index.php?msg=' . urlencode(base64_encode("You have been successfully logged out!")));
?>