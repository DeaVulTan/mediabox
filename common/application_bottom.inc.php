<?php
/**
 * File handling the necessary information displaying at the footer
 *
 * This file includes the html_footer file. Also on the basis of config
 * variable setting this will display executed queries and parsing time
 * to the developer. By changing the config setting the admin can hide this.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: application_bottom.inc.php 763 2008-06-20 06:24:35Z selvaraj_47ag04 $
 * @since 		2006-13-17
 */
/*
echo '<pre>'."\n";
print_r($GLOBALS);
echo '</pre>'."\n";
*/
updateAdvertisementCount();
if ($CFG['feature']['external_links_open_new_window'])
    {
?>
<script language="javascript" type="text/javascript">
externalLinks();
</script>
<?php
    }
    global $mainmenu_channel, $mainmenu_more;
?>
<script type="text/javascript">
//Events for Channel and Menu More sub Menus
//document.observe("dom:loaded", function() {
$Jq(document).ready(function(){
<?php if ($mainmenu_channel) { ?>
	$Jq("#channelMoreContent").mouseover(function(){
		$Jq("#channel_menu_anchor").addClass('clsActiveMenu');
	});
	$Jq("#channelMoreContent").mouseout(function(){
		$Jq('#channel_menu_anchor').removeClass('clsActiveMenu');
	});
<?php } if($mainmenu_more) { ?>
	$Jq("#menuMoreContent").mouseout(function(){
		$Jq('#menu_more_anchor').addClass('clsActiveMenu');
	});
	//listen('mouseover', $('menuMoreContent'), function (){ $('menu_more_anchor').addClassName('clsActiveMenu'); });
	$Jq("#menuMoreContent").mouseout(function(){
		$Jq('#menu_more_anchor').removeClass('clsActiveMenu');
	});
	//listen('mouseout', $('menuMoreContent'), function (){ $('menu_more_anchor').removeClassName('clsActiveMenu'); });
<?php } ?>
});
//document.observe("dom:loaded", function() {
$Jq(document).ready(function(){
	<?php if($mainmenu_more) { ?>
	//hide menu more
	$Jq("#header").mouseover(function(){
		allowMenuMoreHide=true; hideMenuMore();
	});
	$Jq("#menu_empty").mouseover(function(){
		allowMenuMoreHide=true; hideMenuMore();
	});
	<?php }
	if($mainmenu_more and $mainmenu_channel) { ?>
	//hide menu more and channel
		$Jq("#menu_more_anchor").mouseover(function(){
			hideChannel()
		});
		$Jq("#channel_menu_anchor").mouseover(function(){
			hideMenuMore()
		});
		//listen('mouseover', $('menu_more_anchor'), hideChannel);
		//listen('mouseover', $('channel_menu_anchor'), hideMenuMore);
	<?php }
	if ($mainmenu_channel) { ?>
	//hide Channel Menu
		$Jq("#header").mouseover(function(){
			allowChannelHide=true;hideChannel();
		});
		//listen('mouseover', $('header'), function() { allowChannelHide=true;hideChannel();});
		$Jq("#menu_empty").mouseover(function(){
			allowChannelHide=true;hideChannel();
		});
		//listen('mouseover', $('menu_empty'), function() { allowChannelHide=true;hideChannel();});
	<?php } ?>
});
var forms_count = document.forms.length;

<?php
if ($CFG['feature']['auto_hide_success_block'])
    {
?>
if($Jq('#selMsgSuccess')){
		hideAnimateBlock('selMsgSuccess');
	}
<?php
	}
?>
</script>
<?php
	if(class_exists('ListRecordsHandler'))
		{
?>
<script language="javascript" type="text/javascript">
	$Jq(document).ready(function(){
<?php
			foreach($CFG['data_tbl']['css_alternative_row_classes'] as $key=>$value)
				{
					$class_name = 'clsDataRow.'.$value;
?>
		$Jq('tr.<?php echo $class_name;?>').mouseover(addClassNameForDataTable);
		$Jq('tr.<?php echo $class_name;?>').mouseout(removeClassNameForDataTable);
<?php
				}
?>
	});
</script>
<?php
		}
//html footer...
if ($CFG['html']['is_use_footer'])
	{
		/**
		 * Including the html_footer file
		 */
	    require_once($CFG['site']['project_path'] .sprintf($CFG['html']['footer'], $CFG['lang']['default']));
	}
?>
<script type="text/javascript">
//placed it below the body tag since IE is showing error as page could not be loaded
helpTipInitialize();
</script>
<?php

if ($CFG['debug']['is_debug_mode'])
	{
		if ($DEBUG_TRACE)
			{
				echo "\n\n".'<!--'."\n";
				echo '<debugtrace>'."\n";
				echo $DEBUG_TRACE;
				echo '</debugtrace>'."\n\n";
				echo '-->';
			}
	}
if ($CFG['debug']['is_db_debug_mode'] &&
		$CFG['db']['is_use_db'])
	{
		echo "\n\n".'<!--'."\n";
		echo '<benchmark>'."\n";
		echo $SQL_QUERIES;
		echo '</benchmark>'."\n";
		echo '-->';
	}
if ($CFG['benchmark']['query_time']['is_expose'] &&
		$CFG['db']['is_use_db'])
	{
		echo "\n\n".'<!--'."\n";
		echo '<benchmark>'."\n";
		echo '  <querytime>'."\n";
	    $query_timings_arr = $db->getQueryTimings();
		foreach($query_timings_arr as $key=>$query_and_time_arr)
			{
				foreach($query_and_time_arr as $query=>$query_time)
					{
						$query = ($CFG['benchmark']['query_time']['is_expose_query']) ? htmlspecialchars($query) : md5($query);
						echo '   <sec>'.$query_time.'</sec><sql>'.$query.'</sql>'."\n";
					}
			}
		echo '  </querytime>'."\n";
		echo '</benchmark>'."\n";
		echo '-->';
	}
//finishing up parsing work as by config...
if ($CFG['benchmark']['is_expose_parse_time'])
	{
		$CFG['parse_time']['end'] = explode(' ', microtime());
		$CFG['parse_time']['total'] = number_format(($CFG['parse_time']['end'][1] + $CFG['parse_time']['end'][0] - ($CFG['parse_time']['start'][1] + $CFG['parse_time']['start'][0])), 5);
		echo "\n\n".'<!--'."\n";
		echo '<benchmark>'."\n";
		echo '  <parsetime>'."\n";
		echo '    <sec>'.$CFG['parse_time']['total'].'</sec>'."\n";
		echo '  </parsetime>'."\n";
		echo '</benchmark>'."\n";
		echo '-->';
	}
if ($CFG['debug']['is_custom_handler'])
	{
		//cleanup
		echo $errHandler->processTrappedErrors();
	}
