<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.base.php');
	require_once(DIR_INC_FF . 'function.form_edit.php');
	require_once(DIR_INC_FF . 'class.auth.php');
	$auth = new Auth($db, TBL_USER);