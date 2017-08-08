<?php

/**
* @author EASY APPLICATIONS
* @copyright 2008
*/
require_once('../common/configs/config.inc.php');

include_once ('includes/config.php');

$CFG['html']['header'] = 'general/html_header_popup.php';
$CFG['html']['footer'] = 'general/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;

$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
class inteliloginPage extends FormHandler
	{
	}
$inteliloginPage = new inteliloginPage();
$vcopy_right_year = $CFG['admin']['coppy_rights_year'];
$vsite_name = $CFG['site']['name'];
$vsite_url = $CFG['site']['url'];
$vall_rights = $LANG['header_all_rights_reserved'];
$vdefault_template = $CFG['html']['template']['default'];
$vdefault_stylesheet = $CFG['html']['stylesheet']['screen']['default'];

$inteliloginPage->includePopUpHeader();


$show_result = 0;
//parse email address to determine service

list($notneeded,$domain_name) = split('@',$username);

$domain_first_part = explode(".",$domain_name);

$switch = strtolower($domain_first_part[0]);
switch ($switch) {

    case 'hotmail':
        $script = "myhotmail.php";
        break;

    case 'live':
        $script = "myhotmail.php";
        break;

    case 'gmail':
        $script = "mygmail.php";
        break;

    case 'googlemail':
        $script = "mygmail.php";
        break;

    case 'yahoo':
        $script = "myyahoo.php";
        break;

    case 'lycos':
        $script = "mylycos.php";
        break;

    case 'icq':
        $script = "myicq.php";
        break;

    case 'icqmail':
        $script = "myicq.php";
        break;

    case 'windowslive':
        $script = "mylive.php";
        break;

    case 'aol':
        $script = "myaol.php";
        break;

    case 'rediffmail':
        $script = "myrediffmail.php";
        break;

    case 'fastmail':
        $script = "myfastmail.php";
        break;

    case 'rambler':
        $script = "myrambler.php";
        break;



        ///////////////////////////////
        //All the mail.com domain name
        ///////////////////////////////

    case 'mail':
        $script = "mymail.php";
        break;

    case 'email':
        $script = "mymail.php";
        break;

    case 'iname':
        $script = "mymail.php";
        break;

    case 'cheerful':
        $script = "mymail.php";
        break;

    case 'consultant':
        $script = "mymail.php";
        break;

    case 'europe':
        $script = "mymail.php";
        break;

    case 'mindless':
        $script = "mymail.php";
        break;

    case 'earthling':
        $script = "mymail.php";
        break;

    case 'myself':
        $script = "mymail.php";
        break;

    case 'post':
        $script = "mymail.php";
        break;

    case 'techie':
        $script = "mymail.php";
        break;

    case 'writeme':
        $script = "mymail.php";
        break;

    case 'alumni':
        $script = "mymail.php";
        break;

    case 'alumnidirector':
        $script = "mymail.php";
        break;

    case 'graduate':
        $script = "mymail.php";
        break;

    case 'berlin':
        $script = "mymail.php";
        break;

    case 'dallasmail':
        $script = "mymail.php";
        break;

    case 'delhimail':
        $script = "mymail.php";
        break;

    case 'dublin':
        $script = "mymail.php";
        break;

    case 'london':
        $script = "mymail.php";
        break;

    case 'madrid':
        $script = "mymail.php";
        break;

    case 'moscowmail':
        $script = "mymail.php";
        break;

    case 'munich':
        $script = "mymail.php";
        break;

    case 'nycmail':
        $script = "mymail.php";
        break;

    case 'paris':
        $script = "mymail.php";
        break;

    case 'paris':
        $script = "mymail.php";
        break;

    case 'rome':
        $script = "mymail.php";
        break;

    case 'sanfranmail':
        $script = "mymail.php";
        break;

    case 'singapore':
        $script = "mymail.php";
        break;

    case 'tokyo':
        $script = "mymail.php";
        break;

    case 'torontomail':
        $script = "mymail.php";
        break;

    case 'australiamail':
        $script = "mymail.php";
        break;

    case 'brazilmail':
        $script = "mymail.php";
        break;

    case 'chinamail':
        $script = "mymail.php";
        break;

    case 'germanymail':
        $script = "mymail.php";
        break;

    case 'indiamail':
        $script = "mymail.php";
        break;

    case 'irelandmail':
        $script = "mymail.php";
        break;

    case 'israelmail':
        $script = "mymail.php";
        break;

    case 'italymail':
        $script = "mymail.php";
        break;

    case 'japan':
        $script = "mymail.php";
        break;

    case 'koreamail':
        $script = "mymail.php";
        break;

    case 'mexicomail':
        $script = "mymail.php";
        break;

    case 'polandmail':
        $script = "mymail.php";
        break;

    case 'russiamail':
        $script = "mymail.php";
        break;

    case 'scotlandmail':
        $script = "mymail.php";
        break;

    case 'singapore':
        $script = "mymail.php";
        break;

    case 'spainmail':
        $script = "mymail.php";
        break;

    case 'swedenmail':
        $script = "mymail.php";
        break;

    case 'angelic':
        $script = "mymail.php";
        break;

    case 'atheist':
        $script = "mymail.php";
        break;

    case 'minister':
        $script = "mymail.php";
        break;

    case 'muslim':
        $script = "mymail.php";
        break;

    case 'oath':
        $script = "mymail.php";
        break;

    case 'orthodox':
        $script = "mymail.php";
        break;

    case 'priest':
        $script = "mymail.php";
        break;

    case 'protestant':
        $script = "mymail.php";
        break;

    case 'reborn':
        $script = "mymail.php";
        break;

    case 'religious':
        $script = "mymail.php";
        break;

    case 'saintly':
        $script = "mymail.php";
        break;

    case 'artlover':
        $script = "mymail.php";
        break;

    case 'bikerider':
        $script = "mymail.php";
        break;

    case 'birdlover':
        $script = "mymail.php";
        break;

    case 'catlover':
        $script = "mymail.php";
        break;

    case 'collector':
        $script = "mymail.php";
        break;

    case 'comic':
        $script = "mymail.php";
        break;

    case 'cutey':
        $script = "mymail.php";
        break;

    case 'disciples':
        $script = "mymail.php";
        break;

    case 'doglover':
        $script = "mymail.php";
        break;

    case 'elvisfan':
        $script = "mymail.php";
        break;

    case 'fan':
        $script = "mymail.php";
        break;

    case 'fan':
        $script = "mymail.php";
        break;

    case 'gardener':
        $script = "mymail.php";
        break;

    case 'hockeymail':
        $script = "mymail.php";
        break;

    case 'madonnafan':
        $script = "mymail.php";
        break;

    case 'musician':
        $script = "mymail.php";
        break;

    case 'petlover':
        $script = "mymail.php";
        break;

    case 'reggaefan':
        $script = "mymail.php";
        break;

    case 'rocketship':
        $script = "mymail.php";
        break;

    case 'rockfan':
        $script = "mymail.php";
        break;

    case 'thegame':
        $script = "mymail.php";
        break;

    case 'cyberdude':
        $script = "mymail.php";
        break;

    case 'cybergal':
        $script = "mymail.php";
        break;

    case 'cyber-wizard':
        $script = "mymail.php";
        break;

    case 'email':
        $script = "mymail.php";
        break;

    case 'mail':
        $script = "mymail.php";
        break;

    case 'webname':
        $script = "mymail.php";
        break;

    case 'who':
        $script = "mymail.php";
        break;

    case 'writeme':
        $script = "mymail.php";
        break;

    case 'accountant':
        $script = "mymail.php";
        break;

    case 'adexec':
        $script = "mymail.php";
        break;

    case 'allergist':
        $script = "mymail.php";
        break;

    case 'alumnidirector':
        $script = "mymail.php";
        break;

    case 'archaeologist':
        $script = "mymail.php";
        break;

    case 'bartender':
        $script = "mymail.php";
        break;

    case 'brew-master':
        $script = "mymail.php";
        break;

    case 'chef':
        $script = "mymail.php";
        break;

    case 'chemist':
        $script = "mymail.php";
        break;

    case 'clerk':
        $script = "mymail.php";
        break;

    case 'columnist':
        $script = "mymail.php";
        break;

    case 'comic':
        $script = "mymail.php";
        break;

    case 'consultant':
        $script = "mymail.php";
        break;

    case 'contractor':
        $script = "mymail.php";
        break;

    case 'counsellor':
        $script = "mymail.php";
        break;

    case 'count':
        $script = "mymail.php";
        break;

    case 'deliveryman':
        $script = "mymail.php";
        break;

    case 'diplomats':
        $script = "mymail.php";
        break;

    case 'doctor':
        $script = "mymail.php";
        break;

    case 'dr':
        $script = "mymail.php";
        break;

    case 'engineer':
        $script = "mymail.php";
        break;

    case 'execs':
        $script = "mymail.php";
        break;

    case 'financier':
        $script = "mymail.php";
        break;

    case 'fireman':
        $script = "mymail.php";
        break;

    case 'footballer':
        $script = "mymail.php";
        break;

    case 'gardener':
        $script = "mymail.php";
        break;

    case 'geologist':
        $script = "mymail.php";
        break;

    case 'graphic-designer':
        $script = "mymail.php";
        break;

    case 'hairdresser':
        $script = "mymail.php";
        break;

    case 'instructor':
        $script = "mymail.php";
        break;

    case 'insurer':
        $script = "mymail.php";
        break;

    case 'journalist':
        $script = "mymail.php";
        break;

    case 'lawyer':
        $script = "mymail.php";
        break;

    case 'legislator':
        $script = "mymail.php";
        break;

    case 'lobbyist':
        $script = "mymail.php";
        break;

    case 'mad.scientist':
        $script = "mymail.php";
        break;

    case 'minister':
        $script = "mymail.php";
        break;

    case 'monarchy':
        $script = "mymail.php";
        break;

    case 'optician':
        $script = "mymail.php";
        break;

    case 'orthodontist':
        $script = "mymail.php";
        break;

    case 'pediatrician':
        $script = "mymail.php";
        break;

    case 'photographer':
        $script = "mymail.php";
        break;

    case 'physicist':
        $script = "mymail.php";
        break;

    case 'politician':
        $script = "mymail.php";
        break;

    case 'popstar':
        $script = "mymail.php";
        break;

    case 'presidency':
        $script = "mymail.php";
        break;

    case 'priest':
        $script = "mymail.php";
        break;

    case 'programmer':
        $script = "mymail.php";
        break;

    case 'publicist':
        $script = "mymail.php";
        break;

    case 'radiologist':
        $script = "mymail.php";
        break;

    case 'realtyagent':
        $script = "mymail.php";
        break;

    case 'registerednurses':
        $script = "mymail.php";
        break;

    case 'repairman':
        $script = "mymail.php";
        break;

    case 'representative':
        $script = "mymail.php";
        break;

    case 'rescueteam':
        $script = "mymail.php";
        break;

    case 'salesperson':
        $script = "mymail.php";
        break;

    case 'scientist':
        $script = "mymail.php";
        break;

    case 'secretary':
        $script = "mymail.php";
        break;

    case 'socialworker':
        $script = "mymail.php";
        break;

    case 'sociologist':
        $script = "mymail.php";
        break;

    case 'songwriter':
        $script = "mymail.php";
        break;

    case 'teachers':
        $script = "mymail.php";
        break;

    case 'techie':
        $script = "mymail.php";
        break;

    case 'technologist':
        $script = "mymail.php";
        break;

    case 'therapist':
        $script = "mymail.php";
        break;

    case 'tvstar':
        $script = "mymail.php";
        break;

    case 'umpire':
        $script = "mymail.php";
        break;

    case 'worker':
        $script = "mymail.php";
        break;

    case 'africamail':
        $script = "mymail.php";
        break;

    case 'americamail':
        $script = "mymail.php";
        break;

    case 'arcticmail':
        $script = "mymail.php";
        break;

    case 'asia':
        $script = "mymail.php";
        break;

    case 'asia-mail':
        $script = "mymail.php";
        break;

    case 'australiamail':
        $script = "mymail.php";
        break;

    case 'berlin':
        $script = "mymail.php";
        break;

    case 'brazilmail':
        $script = "mymail.php";
        break;

    case 'californiamail':
        $script = "mymail.php";
        break;

    case 'chinamail':
        $script = "mymail.php";
        break;

    case 'dallasmail':
        $script = "mymail.php";
        break;

    case 'delhimail':
        $script = "mymail.php";
        break;

    case 'dublin':
        $script = "mymail.php";
        break;

    case 'dutchmail':
        $script = "mymail.php";
        break;

    case 'englandmail':
        $script = "mymail.php";
        break;

    case 'europe':
        $script = "mymail.php";
        break;

    case 'europemail':
        $script = "mymail.php";
        break;

    case 'germanymail':
        $script = "mymail.php";
        break;

    case 'indiamail':
        $script = "mymail.php";
        break;

    case 'irelandmail':
        $script = "mymail.php";
        break;

    case 'israelmail':
        $script = "mymail.php";
        break;

    case 'italymail':
        $script = "mymail.php";
        break;

    case 'japan':
        $script = "mymail.php";
        break;

    case 'koreamail':
        $script = "mymail.php";
        break;

    case 'london':
        $script = "mymail.php";
        break;

    case 'madrid':
        $script = "mymail.php";
        break;

    case 'mexicomail':
        $script = "mymail.php";
        break;

    case 'moscowmail':
        $script = "mymail.php";
        break;

    case 'munich':
        $script = "mymail.php";
        break;

    case 'nycmail':
        $script = "mymail.php";
        break;

    case 'pacific-ocean':
        $script = "mymail.php";
        break;

    case 'pacificwest':
        $script = "mymail.php";
        break;

    case 'paris':
        $script = "mymail.php";
        break;

    case 'paris':
        $script = "mymail.php";
        break;

    case 'polandmail':
        $script = "mymail.php";
        break;

    case 'rome':
        $script = "mymail.php";
        break;

    case 'russiamail':
        $script = "mymail.php";
        break;

    case 'safrica':
        $script = "mymail.php";
        break;

    case 'samerica':
        $script = "mymail.php";
        break;

    case 'sanfranmail':
        $script = "mymail.php";
        break;

    case 'scotlandmail':
        $script = "mymail.php";
        break;

    case 'singapore':
        $script = "mymail.php";
        break;

    case 'spainmail':
        $script = "mymail.php";
        break;

    case 'swedenmail':
        $script = "mymail.php";
        break;

    case 'swissmail':
        $script = "mymail.php";
        break;

    case 'tokyo':
        $script = "mymail.php";
        break;

    case 'torontomail':
        $script = "mymail.php";
        break;

    case 'amorous':
        $script = "mymail.php";
        break;

    case 'caress':
        $script = "mymail.php";
        break;

    case 'couple':
        $script = "mymail.php";
        break;

    case 'feelings':
        $script = "mymail.php";
        break;

    case 'yours':
        $script = "mymail.php";
        break;

    case 'mail':
        $script = "mymail.php";
        break;

    case 'mail':
        $script = "mymail.php";
        break;

    case 'cliffhanger':
        $script = "mymail.php";
        break;

    case 'count':
        $script = "mymail.php";
        break;

    case 'disposable':
        $script = "mymail.php";
        break;

    case 'doubt':
        $script = "mymail.php";
        break;

    case 'email':
        $script = "mymail.php";
        break;

    case 'homosexual':
        $script = "mymail.php";
        break;

    case 'hour':
        $script = "mymail.php";
        break;

    case 'iname':
        $script = "mymail.php";
        break;

    case 'instruction':
        $script = "mymail.php";
        break;

    case 'mail':
        $script = "mymail.php";
        break;

    case 'mobsters':
        $script = "mymail.php";
        break;

    case 'monarchy':
        $script = "mymail.php";
        break;

    case 'nastything':
        $script = "mymail.php";
        break;

    case 'nightly':
        $script = "mymail.php";
        break;

    case 'nonpartisan':
        $script = "mymail.php";
        break;

    case 'null':
        $script = "mymail.php";
        break;

    case 'post':
        $script = "mymail.php";
        break;

    case 'reborn':
        $script = "mymail.php";
        break;

    case 'revenue':
        $script = "mymail.php";
        break;

    case 'royal':
        $script = "mymail.php";
        break;

    case 'sister':
        $script = "mymail.php";
        break;

    case 'snakebite':
        $script = "mymail.php";
        break;

    case 'soon':
        $script = "mymail.php";
        break;

    case 'surgical':
        $script = "mymail.php";
        break;

    case 'theplate':
        $script = "mymail.php";
        break;

    case 'toke':
        $script = "mymail.php";
        break;

    case 'toothfairy':
        $script = "mymail.php";
        break;

    case 'tvstar':
        $script = "mymail.php";
        break;

    case 'wallet':
        $script = "mymail.php";
        break;

    case 'winning':
        $script = "mymail.php";
        break;

    case 'earthling':
        $script = "mymail.php";
        break;

    case 'inorbit':
        $script = "mymail.php";
        break;

    case 'humanoid':
        $script = "mymail.php";
        break;

    case 'rocketship':
        $script = "mymail.php";
        break;

    case 'weirdness':
        $script = "mymail.php";
        break;

    case '2die4':
        $script = "mymail.php";
        break;

    case 'activist':
        $script = "mymail.php";
        break;

    case 'aroma':
        $script = "mymail.php";
        break;

    case 'been-there':
        $script = "mymail.php";
        break;

    case 'bigger':
        $script = "mymail.php";
        break;

    case 'cheerful':
        $script = "mymail.php";
        break;

    case 'comfortable':
        $script = "mymail.php";
        break;

    case 'feelings':
        $script = "mymail.php";
        break;

    case 'hilarious':
        $script = "mymail.php";
        break;

    case 'hot-shot':
        $script = "mymail.php";
        break;

    case 'howling':
        $script = "mymail.php";
        break;

    case 'humanoid':
        $script = "mymail.php";
        break;

    case 'innocent':
        $script = "mymail.php";
        break;

    case 'loveable':
        $script = "mymail.php";
        break;

    case 'mindless':
        $script = "mymail.php";
        break;

    case 'myself':
        $script = "mymail.php";
        break;

    case 'playful':
        $script = "mymail.php";
        break;

    case 'poetic':
        $script = "mymail.php";
        break;

    case 'popstar':
        $script = "mymail.php";
        break;

    case 'saintly':
        $script = "mymail.php";
        break;

    case 'seductive':
        $script = "mymail.php";
        break;

    case 'sizzling':
        $script = "mymail.php";
        break;

    case 'tempting':
        $script = "mymail.php";
        break;

    case 'tough':
        $script = "mymail.php";
        break;

    case 'weirdness':
        $script = "mymail.php";
        break;

    case 'whoever':
        $script = "mymail.php";
        break;

    case 'witty':
        $script = "mymail.php";
        break;

    case 'alabama':
        $script = "mymail.php";
        break;

    case 'alaska':
        $script = "mymail.php";
        break;

    case 'arizona':
        $script = "mymail.php";
        break;

    case 'arkansas':
        $script = "mymail.php";
        break;

    case 'california':
        $script = "mymail.php";
        break;

    case 'colorado':
        $script = "mymail.php";
        break;

    case 'connecticut':
        $script = "mymail.php";
        break;

    case 'delaware':
        $script = "mymail.php";
        break;

    case 'florida':
        $script = "mymail.php";
        break;

    case 'georgia':
        $script = "mymail.php";
        break;

    case 'hawaii':
        $script = "mymail.php";
        break;

    case 'idaho':
        $script = "mymail.php";
        break;

    case 'illinois':
        $script = "mymail.php";
        break;

    case 'indiana':
        $script = "mymail.php";
        break;

    case 'iowa':
        $script = "mymail.php";
        break;

    case 'kansas':
        $script = "mymail.php";
        break;

    case 'kentucky':
        $script = "mymail.php";
        break;

    case 'louisiana':
        $script = "mymail.php";
        break;

    case 'maine':
        $script = "mymail.php";
        break;

    case 'maryland':
        $script = "mymail.php";
        break;

    case 'massachusetts':
        $script = "mymail.php";
        break;

    case 'michigan':
        $script = "mymail.php";
        break;

    case 'minnesota':
        $script = "mymail.php";
        break;

    case 'mississippi':
        $script = "mymail.php";
        break;

    case 'missouri':
        $script = "mymail.php";
        break;

    case 'montana':
        $script = "mymail.php";
        break;

    case 'nebraska':
        $script = "mymail.php";
        break;

    case 'nevada':
        $script = "mymail.php";
        break;

    case 'newhampshire':
        $script = "mymail.php";
        break;

    case 'newjersey':
        $script = "mymail.php";
        break;

    case 'newmexico':
        $script = "mymail.php";
        break;

    case 'newyork':
        $script = "mymail.php";
        break;

    case 'northcarolina':
        $script = "mymail.php";
        break;

    case 'northdakota':
        $script = "mymail.php";
        break;

    case 'ohio':
        $script = "mymail.php";
        break;

    case 'oklahoma':
        $script = "mymail.php";
        break;

    case 'oregon':
        $script = "mymail.php";
        break;

    case 'pennsylvania':
        $script = "mymail.php";
        break;

    case 'rhodeisland':
        $script = "mymail.php";
        break;

    case 'southcarolina':
        $script = "mymail.php";
        break;

    case 'southdakota':
        $script = "mymail.php";
        break;

    case 'tennessee':
        $script = "mymail.php";
        break;

    case 'texas':
        $script = "mymail.php";
        break;

    case 'utah':
        $script = "mymail.php";
        break;

    case 'vermont':
        $script = "mymail.php";
        break;

    case 'virginia':
        $script = "mymail.php";
        break;

    case 'washington':
        $script = "mymail.php";
        break;

    case 'westvirginia':
        $script = "mymail.php";
        break;

    case 'wisconsin':
        $script = "mymail.php";
        break;

    case 'wyoming':
        $script = "mymail.php";
        break;

    case 'katamail':
        $script = "mykatamail.php";
        break;

}

//check for other domaines

switch ($domain) {

    case 'email.it':
        $script = "myemailit.php";
        break;

}

if ($script == "") {
    $script = 'mymail.php';
}
include_once ($script);
$inteliloginPage->includePopupFooter();
?>