<?php

/**
 * This is a user "DB" for demo purposes only.  We strongly recommend
 * that a more robust mechanism be used for real application use.
 */

class UserDB
{
    private $_userfile;

    public function __construct($userfile)
    {
        $this->_userfile = $userfile;
    }

    public function getName($id)
    {
        if (!$id) {
            return;
        }

        $db = dba_open($this->_userfile, "r", "flatfile");
        if (!$db) {
            error_log("Error: Web Auth sample: Problem while reading the profile database.");
            return;
        }

        $name = dba_fetch($id, $db);
        dba_close($db);
        return $name;
    }

    public function setName($id, $name)
    {
        if (!$id) {
            return;
        }

        $db = dba_open($this->_userfile, "c", "flatfile");
        if (!$db) {
            error_log("Error: Web Auth sample: Problem while writing the profile database.");
            return;
        }

        if (!dba_replace($id, $name, $db) ) {
            error_log("Error: Web Auth sample: Problem while writing the profile database.");
        }
        dba_close($db);
    }
}
?>
