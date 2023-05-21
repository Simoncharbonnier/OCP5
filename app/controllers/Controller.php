<?php

class Controller
{

    /**
     * Check if user is not logged
     *
     * @return boolean
     * @throws Exception
     */

    public function isNotLogged()
    {
        if ($_SESSION['is_logged'] === false) {
            return true;
        }

        throw new Exception("no_perms_logged");
    }

    /**
     * Check if user is logged
     *
     * @return boolean
     * @throws Exception
     */

    public function isLogged()
    {
        if ($_SESSION['is_logged'] === true) {
            return true;
        }

        throw new Exception("no_perms");
    }

    /**
     * Check if user is logged and admin
     *
     * @return boolean
     * @throws Exception
     */

    public function isAdmin()
    {
        if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) {
            return true;
        }

        throw new Exception("no_perms");
    }

    /**
     * Format date
     * @param string $date date to format
     *
     * @return string
     */

    public function formatDate($date) : string
    {
        $date = explode('-', $date);
        return $date[2].'/'.$date[1].'/'.$date[0];
    }

}
