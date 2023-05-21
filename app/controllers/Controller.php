<?php

class Controller
{

    /**
     * Check if user is not logged
     *
     * @return true
     * @throws
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
     * @return true
     * @throws
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
     * @return true
     * @throws
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
     * @param string $date
     *
     * @return string
     */

    public function formatDate($date) : string
    {
        $date = explode('-', $date);
        return $date[2].'/'.$date[1].'/'.$date[0];
    }

}
