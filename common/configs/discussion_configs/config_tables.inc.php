<?php
/**
 * settings for $CFG['db']['hostname']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-18
 * @filesource
 **/
$CFG['db']['tbl']['prefix'] = 'discuzz_';
$CFG['db']['tbl']['discussions'] = $CFG['db']['tbl']['prefix'].'discussions';
$CFG['db']['tbl']['abuse_solutions'] = $CFG['db']['tbl']['prefix'].'abuse_solutions';
$CFG['db']['tbl']['abuse_boards'] = $CFG['db']['tbl']['prefix'].'abuse_boards';
$CFG['db']['tbl']['solutions'] = $CFG['db']['tbl']['prefix'].'solutions';
$CFG['db']['tbl']['attachments'] = $CFG['db']['tbl']['prefix'].'attachments';
$CFG['db']['tbl']['cron_master'] = $CFG['db']['tbl']['prefix'].'cron_master';
$CFG['db']['tbl']['boards'] = $CFG['db']['tbl']['prefix'].'boards';
$CFG['db']['tbl']['category'] = $CFG['db']['tbl']['prefix'].'category';
$CFG['db']['tbl']['users_board_log'] = $CFG['db']['tbl']['prefix'].'users_board_log';
$CFG['db']['tbl']['users_stared_solution'] = $CFG['db']['tbl']['prefix'].'users_stared_solution';
$CFG['db']['tbl']['users_stared_board'] = $CFG['db']['tbl']['prefix'].'users_stared_board';
$CFG['db']['tbl']['user_bookmarked'] = $CFG['db']['tbl']['prefix'].'user_bookmarked';
$CFG['db']['tbl']['tags'] = $CFG['db']['tbl']['prefix'].'tags';
$CFG['db']['tbl']['advanced_search'] = $CFG['db']['tbl']['prefix'].'advanced_search';
$CFG['db']['tbl']['view_weekly_experts'] = $CFG['db']['tbl']['prefix'].'view_weekly_experts';
$CFG['db']['tbl']['rightbar_settings'] = $CFG['db']['tbl']['prefix'].'rightbar_settings';
$CFG['db']['tbl']['board_comment'] = $CFG['db']['tbl']['prefix'].'board_comment';
$CFG['db']['tbl']['view_log'] = $CFG['db']['tbl']['prefix'].'view_log';
$CFG['db']['tbl']['common_words'] = $CFG['db']['tbl']['prefix'].'common_words';
$CFG['db']['tbl']['discussions_activity'] = $CFG['db']['tbl']['prefix'].'discussions_activity';

$CFG['db']['tbl']['discuzz_board_rating'] = $CFG['db']['tbl']['prefix'].'board_rating';
$CFG['db']['tbl']['discuzz_solution_rating'] = $CFG['db']['tbl']['prefix'].'solution_rating';
?>
