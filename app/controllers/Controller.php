<?php

class Controller
{

	/**
	 * Check if user is not logged
	 */
	public function isNotLogged()
	{
		if ($_SESSION['is_logged'] === false) {
			return true;
		} else {
			throw new Exception("no_perms_logged");
		}
	}

	/**
	 * Check if user is logged
	 */
	public function isLogged()
	{
		if ($_SESSION['is_logged'] === true) {
			return true;
		} else {
			throw new Exception("no_perms");
		}
	}

	/**
	 * Check if user is logged and admin
	 */
	public function isAdmin()
	{
		if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) {
			return true;
		} else {
			throw new Exception("no_perms");
		}
	}

	/**
	 * Format date
	 */
	public function formatDate($date)
	{
		$date = explode('-', $date);
		return $date[2] . '/' . $date[1] . '/' . $date[0];
	}
}
