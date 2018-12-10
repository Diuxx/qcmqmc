
<?php

class Session {

	public function __construct() {
		if(!session_id()) @ session_start();
	}

	public function destroy() {
		$_SESSION = array();
		session_destroy();
	}

	public function redirect($url, $statusCode = 303) {
		header('Location: ' . $url, true, $statusCode);
	}
}

?>