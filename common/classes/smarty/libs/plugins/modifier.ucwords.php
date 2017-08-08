<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty upper words modifier plugin
 *
 * Type:     modifier<br>
 * Name:     ucwords<br>
 * Purpose:  convert the first letter in the words to upper
 * @link http://smarty.php.net/manual/en/language.modifier.upper.php
 *          upper (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_ucwords($string)
{
    return ucwords($string);
}

?>
