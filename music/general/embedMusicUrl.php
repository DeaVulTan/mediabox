<?php
/**
 * This File embedMusicUrl
 *
 * @category	Rayzz
 * @package		embedMusicUrl
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
function ob_makejavascripthandler($output)
	{
	  return sprintf('document.write(unescape("%s"));',
					 rawurlencode($output));
	}

ob_start("ob_makejavascripthandler");
if(isset($_GET['mid']))
	{
		$musicId=mvFileRayzz($_GET['mid']);
	}
else
	exit;

if(isset($_GET['width']) && isset($_GET['height']))
	{
		$width=$_GET['width'];
		$height=$_GET['height'];
	}
else
	{
		$width = $CFG['admin']['musics']['single_player']['width'];
		$height = $CFG['admin']['musics']['single_player']['height'];
	}
?>

<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript">
function JSFCommunicator(A){this.init(A)}JSFCommunicator.prototype.init=function(A){if(A=="undefined"){var A=null}this.setMovie(A);this.functionToCall=null;this.functionLocationinFlash=null;this.functionArgs=null};JSFCommunicator.prototype.setMovie=function(A){this.flashMovie=A};JSFCommunicator.prototype.setVariable=function(A,B){this.flashMovie.SetVariable(A,B)};JSFCommunicator.prototype.getVariable=function(B){var A=this.flashMovie.GetVariable(B);return A};JSFCommunicator.prototype.callFunction=function(E,D,C){if(this.flashMovie==null){return false}var B=this.getVariable("/:triggerFn");var A=false;if(D==""){return false}if(E==""){var E="_level0"}this.setVariable("/:fnLocation",E);this.setVariable("/:fnName",D);if(typeof (C)=="object"){this.setVariable("/:fnArgs",C.join("$@$$"))}else{if(typeof (C)=="number"||typeof (C)=="string"){this.setVariable("/:fnArgs",C)}}this.setVariable("/:triggerFn",!B);A=this.getVariable("triggerFnStatus");this.setVariable("/:triggerFnStatus",false);return A};
function thisMovie(movieName)
	{
	 if (navigator.appName.indexOf ("Microsoft") !=-1) {

		return window[movieName]


	  } else {
	   return window.document[movieName]
	  }
	}
function createJSFCommunicatorObject(playerObj)
	{
	 fc = new JSFCommunicator(playerObj);
	}
function callUrl()
	{
		var loc = location.href;
		fc.callFunction("_root","js_setRef",[loc])
	}
</script>
<?php
$flv_player_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['player_path'].
								$CFG['admin']['musics']['single_player']['swf_name'].'.swf';
$configXmlcode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['config_name'].'.php?';
$playlistXmlcode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['playlist_name'].'.php?';
$addsXmlCode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['ad_name'].'.php';
$themesXml_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['theme_path'].
									$CFG['admin']['musics']['single_player']['xml_theme'];
$configXmlcode_url .= 'pg=music_'.$_GET['mid'].'_extsite';
$playlistXmlcode_url .= 'pg=music_'.$_GET['mid'];
?>
<embed src="<?php echo $CFG['site']['music_url'].'embedMusicPlayer.php?mid='.$_GET['mid'].'_'.$musicId;?>" FlashVars="configXmlPath=<?php echo $configXmlcode_url;?>&playListXmlPath=<?php echo $playlistXmlcode_url; ?>&themes=<?php echo $themesXml_url; ?>" quality="high" bgcolor="#000000" width="<?php echo $width;?>" height="<?php echo $height;?>" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true" />
<script language="JavaScript">
	//make sure this object JSFCommunicator is created only when Object or Embed tags are initialized.
		createJSFCommunicatorObject(thisMovie("flvplayer"));
</script>




