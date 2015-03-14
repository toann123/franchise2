<?php
/**
 * $Id: password_funcs.php,v 1.10 2003/02/11 01:31:02 hpdl Exp $
 * osCommerce, Open Source E-Commerce Solutions
 * http://www.oscommerce.com
 * Copyright (c) 2003 osCommerce
 * Released under the GNU General Public License
*/
/**
 * Tests the value being passed in for being null.
 * @param $value    the value being tested.
 * @return bool     True if not null, false if null.
 */
function tep_not_null($value)
{
    if (is_array($value)) {
        if (sizeof($value) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if ((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * Validates a plain text password and a encrypted password.
 * @param $plain the plain text password
 * @param $encrypted the encrypted password
 * @return bool True if passwords match, false if not.
 */
function validate_password($plain, $encrypted)
{
    if (tep_not_null($plain) && tep_not_null($encrypted)) { // split apart the hash / salt
        $stack = explode(':', $encrypted);
        if (sizeof($stack) != 2) return false;
        if (sha1($stack[1] . $plain) == $stack[0]) {
            return true;
        }
    }
    return false;
}



/**
 * Random number generator used in order to seed and salt the password hashing
 * @param null $min
 * @param null $max
 * @return int|null
 */
function tep_rand($min = null, $max = null)
{
    static $seeded;
    if (!$seeded) {
        mt_srand((double)microtime() * 1000000);
        $seeded = true;
    }
    if (isset($min) && isset($max)) {
        if ($min >= $max) {
            return $min;
        } else {
            return mt_rand($min, $max);
        }
    } else {
        return mt_rand();
    }
}
/**
 * Creates a new hashed password from a plain text password
 * @param $plain    The plain text password
 * @return string   The newly encrypted password
 */
function encrypt_password($plain)
{
    $password = '';
    for ($i = 0; $i < 10; $i++) {
        $password .= tep_rand();
    }
    $salt = substr(sha1($password), 0, 2);
    $password = sha1($salt . $plain) . ':' . $salt;
    return $password;
}
?>
