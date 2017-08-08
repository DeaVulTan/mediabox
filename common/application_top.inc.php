<?php
/**
*
*
* @	Author			: By Haking Br
* @	Author			: Por Haking Br
* @ Brasil
* @	Release on		:	03.10.2011
*
*/
require_once( $CFG['site']['project_path']."common/formatting.php" );
require_once( $CFG['site']['project_path']."common/classes/smarty/libs/Smarty.class.php" );
require_once( $CFG['site']['project_path']."common/smartyFunctions.php" );
$CFG['mods']['include_files'][] = 'common/classes/class_AgCache.lib.php';
if ( !isset( $CFG['site']['is_module_page'] ) && !chkAllowedModule( array(
    $CFG['site']['is_module_page']
) ) )
{
    Redirect2URL( $CFG['redirect']['dsabled_module_url'] );
}
foreach ( $CFG['site']['modules_arr'] as $value )
{
    if ( chkAllowedModule( array(
        strtolower( $value )
    ) ) )
    {
        populateConfigData( "config_data_".$value );
        if ( is_file( $CFG['site']['project_path']."common/configs/config_".strtolower( $value ).".inc.php" ) )
        {
            require_once( $CFG['site']['project_path']."common/configs/config_".strtolower( $value ).".inc.php" );
        }
        if ( is_file( $CFG['site']['project_path']."common/".strtolower( $value )."_common_functions.php" ) )
        {
            require_once( $CFG['site']['project_path']."common/".strtolower( $value )."_common_functions.php" );
        }
    }
}
if ( !$CFG['mods']['is_include_only']['html_header'] )
{
    global $DEBUG_TRACE;

   if ( $CFG['feature']['gzip']['is_use_gzip'] && extension_loaded('zlib') && (PHP_VERSION >= '4') )
		{
			if ( (int)ini_get('zlib.output_compression') < 1 )
				{
					if (PHP_VERSION >= '4.0.4')
						ob_start('ob_gzhandler');
				}
				else
					ini_set('zlib.output_compression_level', $CFG['feature']['gzip']['level']);
		}
	if ($CFG['debug']['is_custom_handler'])
		{
			/**
			 * Errohandler class file
			 */
		    require_once($CFG['site']['project_path'].'common/classes/class_ErrorHandler.lib.php');
			$errHandler = new ErrorHandler();
			$errHandler->setErrorLevel($CFG['debug']['error_level']);
			$errHandler->setIsDebugMode($CFG['debug']['is_debug_mode']);
			$errHandler->setNumSourceToFetch($CFG['debug']['source_before_errline'],
											 $CFG['debug']['source_after_errline']);
			$errHandler->setIsCatchFatalError($CFG['debug']['is_catch_fatal_error']);
			$errHandler->setErrorNotifyEmail($CFG['debug']['notify_email']);
			$errHandler->setDebugCSSURL($CFG['debug']['debug_css_url']);
		}
    if ( $CFG['lang']['is_multi_lang_support'] )
    {
        require_once($CFG['site']['project_path']."common/select_language.inc.php");
    }
    if ( $CFG['admin']['include_en_lang_file'] && $CFG['lang']['default'] != "en_us" && $CFG['published_languages']['en_us'])
    {
        require_once( $CFG['site']['project_path']."languages/en_us/common/common.inc.php" );
        require_once( $CFG['site']['project_path']."languages/en_us/lists_array/months_list_array.inc.php" );
    }
    require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/common/common.inc.php" );
    require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/lists_array/months_list_array.inc.php" );
    require_once( $CFG['site']['project_path']."languages/meta_details.php" );
    foreach ( $CFG['site']['modules_arr'] as $value )
    {
        if ( chkAllowedModule( array(
            strtolower( $value )
        ) ) )
        {
            if ( is_file( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/".strtolower( $value )."/common.inc.php" ) )
            {
                require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/".strtolower( $value )."/common.inc.php" );
            }
            if ( $CFG['site']['is_module_page'] == $value && $CFG['site']['is_module_page'] == $value && is_file( $CFG['site']['project_path']."languages/".strtolower( $value )."_meta_details.php" ) )
            {
                require_once( $CFG['site']['project_path']."languages/".strtolower( $value )."_meta_details.php" );
            }
        }
    }
    require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/common/help.inc.php" );
    if ( isset( $CFG['lang']['include_files'] ) )
    {
        foreach ( $CFG['lang']['include_files'] as $include_file )
        {
            if ( $CFG['admin']['include_en_lang_file'] && $CFG['lang']['default'] != "en_us" && $CFG['published_languages']['en_us'] )
            {
                require_once( $CFG['site']['project_path'].sprintf( $include_file, "en_us" ) );
            }
            require_once( $CFG['site']['project_path'].sprintf( $include_file, $CFG['lang']['default'] ) );
        }
    }
 /*   if ( $CFG['ssl']['is_use_ssl'] && ( is_string( $CFG['ssl']['secure_pages'] ) && $CFG['ssl']['secure_pages'] == "*" || is_array( $CFG['ssl']['secure_pages'] ) && in_array( $_SERVER['PHP_SELF'], $CFG['ssl']['secure_pages'] ) ) )
    {
        if ( empty( $_SERVER['HTTPS'] ) )
        {
            Redirect2URL( "https://".substr( $CFG['site']['current_url'], strlen( "http://" ) ) );
        }
    }
    else if ( !empty( $_SERVER['HTTPS'] ) )
    {
        Redirect2URL( "http://".substr( $CFG['site']['current_url'], strlen( "https://" ) ) );
    }*/

	if ($CFG['http_headers']['is_default_http_headers'])
		{
	//Session...
		    if ($CFG['session']['is_session'])
				{
					if (!empty($CFG['session']['cache_limiter']))
							session_cache_limiter($CFG['session']['cache_limiter']);
					if ($CFG['session']['is_custom_handler']
						 && $CFG['db']['is_use_db'])
						{
							/**
							 * Including session handling class file
							 */
							require_once($CFG['site']['project_path'].'common/classes/class_CustomSession.lib.php');
						}
						else //in custom hanlder session is started, so no need to start
							session_start();
				}
			/**
			 * Including http_header.inc.php file
			 */
			require_once($CFG['site']['project_path'].'common/http_headers.inc.php');
		}
    chkIsSiteUnderMaintenance( );
    require_once( $CFG['site']['project_path']."common/classes/swiftmailer/lib/EasySwift.php" );
    setUserConfigVariables( );
    require_once( $CFG['site']['project_path']."common/authentication/authenticate_user.inc.php" );
    require_once( $CFG['site']['project_path']."common/select_template.inc.php" );
    require_once( $CFG['site']['project_path']."common/configs/config_styles.inc.php" );
    foreach ( $CFG['site']['modules_arr'] as $value )
    {
        if ( !chkAllowedModule( array(
            strtolower( $value )
        ) ) && !is_file( $CFG['site']['project_path']."common/configs/config_".strtolower( $value )."_styles.inc.php" ) )
        {
            require_once( $CFG['site']['project_path']."common/configs/config_".strtolower( $value )."_styles.inc.php" );
        }
    }
  	//modules or clasess...
	if (isset($CFG['mods']['include_files']))
		{

		    foreach($CFG['mods']['include_files'] as $include_file)
		    	{
					/**
					 * Including neccessary language filess
					 */
		    		require_once($CFG['site']['project_path'].sprintf($include_file, $CFG['lang']['default']));

				}
		}
    
}
if (!$CFG['mods']['is_include_only']['non_html_header_files'])
	{
	//html header...
	if ($CFG['html']['is_use_header'])
		{
			/**
			 * Including html header file
			 */
			require_once($CFG['site']['project_path'].sprintf($CFG['html']['header'], $CFG['lang']['default']));
		}
	}
require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/general/headerLanguage.php" );
require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/general/mainMenu.php" );
require_once( $CFG['site']['project_path']."languages/".$CFG['lang']['default']."/general/searchModules.php" );
?>
