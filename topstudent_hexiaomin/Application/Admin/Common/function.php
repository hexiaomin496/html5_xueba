<?php
function isLogin() {
	if (!isset($_SESSION['adm_username']) || $_SESSION['adm_username'] == '') {
		return false;
	}
	return true;
}