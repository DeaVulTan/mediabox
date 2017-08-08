<?php
$CFG['trans']['allowed_array_variable_to_edit'] = array('LANG', 'LANG_LIST_ARR');
$CFG['trans']['primaryLang'] = 'en_us';

$CFG['trans']['folder'][0] = 'languages/%s/root/';
$CFG['trans']['folder'][1] = 'languages/%s/members/';
$CFG['trans']['folder'][2] = 'languages/%s/general/';
$CFG['trans']['folder'][3] = 'languages/%s/admin/';
$CFG['trans']['folder'][4] = 'languages/%s/lists_array/';
$CFG['trans']['folder'][5] = 'languages/%s/common/';

//Files which not needed to translate
$CFG['not_trans_files'][0] = array();
$CFG['not_trans_files'][1] = array();
$CFG['not_trans_files'][2] = array();
$CFG['not_trans_files'][3] = array();
$CFG['not_trans_files'][4] = array();
$CFG['not_trans_files'][5] = array();

$ct_inc = sizeof($CFG['trans']['folder']);
foreach($CFG['site']['modules_arr'] as $ct_module)
	{
		$CFG['trans']['folder'][$ct_inc] = 'languages/%s/'.$ct_module.'/';
		$ct_inc++;
		$CFG['trans']['folder'][$ct_inc] = 'languages/%s/'.$ct_module.'/admin/';
		$ct_inc++;
	}


$CFG['trans_pair']['en_us']['af'] = 'English to Afrikaans';

$CFG['trans_pair']['en_us']['sq'] = 'English to Albanian';

$CFG['trans_pair']['en_us']['ar'] = 'English to Arabic';


$CFG['trans_pair']['en_us']['be'] = 'English to Belarusian';
$CFG['trans_pair']['en_us']['bg'] = 'English to Bulgarian';


$CFG['trans_pair']['en_us']['ca'] 	= 'English to Catalan';
$CFG['trans_pair']['en_us']['zh'] = 'English to Chinese';
$CFG['trans_pair']['en_us']['zh-CN'] = 'English to Chinese(Simplified)';
$CFG['trans_pair']['en_us']['zh-TW'] = 'English to Chinese(Traditional)';
$CFG['trans_pair']['en_us']['hr'] = 'English to Croatian';
$CFG['trans_pair']['en_us']['cs'] = 'English to Czech';

$CFG['trans_pair']['en_us']['da'] 	= 'English to Danish';
$CFG['trans_pair']['en_us']['nl'] = 'English to Dutch';

$CFG['trans_pair']['en_us']['et'] 	= 'English to Estonian';

$CFG['trans_pair']['en_us']['tl'] 	= 'English to Filipino';
$CFG['trans_pair']['en_us']['fi'] = 'English to Finnish';
$CFG['trans_pair']['en_us']['fr'] = 'English to French';

$CFG['trans_pair']['en_us']['gl'] 	= 'English to Galician';
$CFG['trans_pair']['en_us']['de'] = 'English to German';
$CFG['trans_pair']['en_us']['el'] = 'English to Greek';

$CFG['trans_pair']['en_us']['iw'] 	= 'English to Hebrew';
$CFG['trans_pair']['en_us']['hi'] = 'English to Hindi';
$CFG['trans_pair']['en_us']['hu'] 	= 'English to Hungarian';

$CFG['trans_pair']['en_us']['is'] 	= 'English to Icelandic';
$CFG['trans_pair']['en_us']['id'] 	= 'English to Indonesian';
$CFG['trans_pair']['en_us']['ga'] 	= 'English to Irish';
$CFG['trans_pair']['en_us']['it'] = 'English to Italian';

$CFG['trans_pair']['en_us']['ja'] = 'English to Japanese';

$CFG['trans_pair']['en_us']['ko'] = 'English to Korean';

$CFG['trans_pair']['en_us']['lv'] 	= 'English to Latvian';
$CFG['trans_pair']['en_us']['lt'] 	= 'English to Lithuanian';

$CFG['trans_pair']['en_us']['mk'] 	= 'English to Macedonian';
$CFG['trans_pair']['en_us']['ms'] 	= 'English to Malay';
$CFG['trans_pair']['en_us']['mt'] 	= 'English to Maltese';

$CFG['trans_pair']['en_us']['nn'] 	= 'English to Norwegian (Nynorsk)';

$CFG['trans_pair']['en_us']['fa'] 	= 'English to Persian';
$CFG['trans_pair']['en_us']['pl'] 	= 'English to Polish';
$CFG['trans_pair']['en_us']['pt'] 	= 'English to Portuguese';


$CFG['trans_pair']['en_us']['ro'] 	= 'English to Romanian';
$CFG['trans_pair']['en_us']['ru'] = 'English to Russian';


$CFG['trans_pair']['en_us']['sk'] 	= 'English to Slovak';
$CFG['trans_pair']['en_us']['sl'] 	= 'English to Slovenian';
$CFG['trans_pair']['en_us']['es'] = 'English to Spanish';
$CFG['trans_pair']['en_us']['sv'] = 'English to Swedish';
$CFG['trans_pair']['en_us']['sw'] 	= 'English to Swahili';

$CFG['trans_pair']['en_us']['th'] 	= 'English to Thai';
$CFG['trans_pair']['en_us']['tr'] 	= 'English to Turkish';

$CFG['trans_pair']['en_us']['uk'] 	= 'English to Ukrainian';

$CFG['trans_pair']['en_us']['vi'] 	= 'English to Vietnamese';

$CFG['trans_pair']['en_us']['cy'] 	= 'English to Welsh';

$CFG['trans_pair']['en_us']['yi'] 	= 'English to Yiddish';


$CFG['trans_pair']['af']['en_us'] = 'Afrikaans To English';
$CFG['trans_pair']['sq']['en_us'] = 'Albanian To English';
$CFG['trans_pair']['ar']['en_us'] = 'Arabic To English';
$CFG['trans_pair']['be']['en_us'] = 'Belarusian To English';
$CFG['trans_pair']['bg']['en_us'] = 'Bulgarian To English';
$CFG['trans_pair']['ca']['en_us'] 	= 'Catalan To English';
$CFG['trans_pair']['zh']['en_us'] = 'Chinese To English';
$CFG['trans_pair']['zh-CN']['en_us'] = 'Chinese(Simplified) To English';
$CFG['trans_pair']['zh-TW']['en_us'] = 'Chinese(Traditional) To English';
$CFG['trans_pair']['hr']['en_us'] = 'Croatian To English';
$CFG['trans_pair']['cs']['en_us'] = 'Czech To English';
$CFG['trans_pair']['da']['en_us'] 	= 'Danish To English';
$CFG['trans_pair']['nl']['en_us'] = 'Dutch To English';
$CFG['trans_pair']['et']['en_us'] 	= 'Estonian To English';
$CFG['trans_pair']['tl']['en_us'] 	= 'Filipino To English';
$CFG['trans_pair']['fi']['en_us'] = 'Finnish To English';
$CFG['trans_pair']['fr']['en_us'] = 'French To English';
$CFG['trans_pair']['gl']['en_us'] 	= 'Galician To English';
$CFG['trans_pair']['de']['en_us'] = 'German To English';
$CFG['trans_pair']['el']['en_us'] = 'Greek To English';
$CFG['trans_pair']['iw']['en_us'] 	= 'Hebrew To English';
$CFG['trans_pair']['hi']['en_us'] = 'Hindi To English';
$CFG['trans_pair']['hu']['en_us'] 	= 'Hungarian To English';
$CFG['trans_pair']['is']['en_us'] 	= 'Icelandic To English';
$CFG['trans_pair']['id']['en_us'] 	= 'Indonesian To English';
$CFG['trans_pair']['ga']['en_us'] 	= 'Irish To English';
$CFG['trans_pair']['it']['en_us'] = 'Italian To English';
$CFG['trans_pair']['ja']['en_us'] = 'Japanese To English';
$CFG['trans_pair']['ko']['en_us'] = 'Korean To English';
$CFG['trans_pair']['lv']['en_us'] 	= 'Latvian To English';
$CFG['trans_pair']['lt']['en_us'] 	= 'Lithuanian To English';
$CFG['trans_pair']['mk']['en_us'] 	= 'Macedonian To English';
$CFG['trans_pair']['ms']['en_us'] 	= 'Malay To English';
$CFG['trans_pair']['mt']['en_us'] 	= 'Maltese To English';
$CFG['trans_pair']['nn']['en_us'] 	= 'Norwegian (Nynorsk) To English';
$CFG['trans_pair']['fa']['en_us'] 	= 'Persian To English';
$CFG['trans_pair']['pl']['en_us'] 	= 'Polish To English';
$CFG['trans_pair']['pt']['en_us'] 	= 'Portuguese To English';
$CFG['trans_pair']['ro']['en_us'] 	= 'Romanian To English';
$CFG['trans_pair']['ru']['en_us'] = 'Russian To English';
$CFG['trans_pair']['sk']['en_us'] 	= 'Slovak To English';
$CFG['trans_pair']['sl']['en_us'] 	= 'Slovenian To English';
$CFG['trans_pair']['es']['en_us'] = 'Spanish To English';
$CFG['trans_pair']['sv']['en_us'] = 'Swedish To English';
$CFG['trans_pair']['sw']['en_us'] 	= 'Swahili To English';
$CFG['trans_pair']['th']['en_us'] 	= 'Thai To English';
$CFG['trans_pair']['tr']['en_us'] 	= 'Turkish To English';
$CFG['trans_pair']['uk']['en_us'] 	= 'Ukrainian To English';
$CFG['trans_pair']['vi']['en_us'] 	= 'Vietnamese To English';
$CFG['trans_pair']['cy']['en_us'] 	= 'Welsh To English';
$CFG['trans_pair']['yi']['en_us'] 	= 'Yiddish To English';





$CFG['trans_pair']['zh-CN']['zh-TW'] = 'Chinese(Simplified to Traditional)';
$CFG['trans_pair']['zh-TW']['zh-CN'] = 'Chinese (Traditional to Simplified)';
$CFG['trans_pair']['fr']['de'] = 'French to German';
$CFG['trans_pair']['de']['fr'] = 'German to French';

$CFG['trans_name']['en_us'] = 'English';
$CFG['trans_name']['ar'] = 'Arabic';
$CFG['trans_name']['bg'] = 'Bulgarian';
$CFG['trans_name']['zh'] = 'Chinese';
$CFG['trans_name']['zh-CN'] = 'Chinese(Simplified)';
$CFG['trans_name']['zh-TW'] = 'Chinese(Traditional)';
$CFG['trans_name']['hr'] = 'Croatian';
$CFG['trans_name']['cs'] = 'Czech';
$CFG['trans_name']['nl'] = 'Dutch';
$CFG['trans_name']['fi'] = 'Finnish';
$CFG['trans_name']['fr'] = 'French';
$CFG['trans_name']['de'] = 'German';
$CFG['trans_name']['el'] = 'Greek';
$CFG['trans_name']['hi'] = 'Hindi';
$CFG['trans_name']['it'] = 'Italian';
$CFG['trans_name']['ja'] = 'Japanese';
$CFG['trans_name']['ko'] = 'Korean';
$CFG['trans_name']['no'] = 'Norwegian';
$CFG['trans_name']['pt-PT'] = 'Portuguese';
$CFG['trans_name']['pt'] = 'Portuguese';
$CFG['trans_name']['ru'] = 'Russian';
$CFG['trans_name']['es'] = 'Spanish';
$CFG['trans_name']['sv'] = 'Swedish';


$CFG['trans_name']['af']		= 'Afrikaans';
$CFG['trans_name']['ak']		= 'Akan';
$CFG['trans_name']['sq']		= 'Albanian';
$CFG['trans_name']['am'] 		= 'Amharic';
$CFG['trans_name']['hy'] 		= 'Armenian';
$CFG['trans_name']['az'] 		= 'Azerbaijani';
$CFG['trans_name']['eu'] 		= 'Basque';
$CFG['trans_name']['be'] 		= 'Belarusian';
$CFG['trans_name']['bn'] 		= 'Bengali';
$CFG['trans_name']['bh'] 		= 'Bihari';
$CFG['trans_name']['xx-bork'] 	= 'Bork, bork, bork!';
$CFG['trans_name']['bs'] 		= 'Bosnian';
$CFG['trans_name']['br'] 		= 'Breton';
$CFG['trans_name']['km'] 	= 'Cambodian';
$CFG['trans_name']['ca'] 	= 'Catalan';
$CFG['trans_name']['co'] 	= 'Corsican';
$CFG['trans_name']['da'] 	= 'Danish';
$CFG['trans_name']['xx-elmer'] 	= 'Elmer Fudd';
$CFG['trans_name']['eo'] 	= 'Esperanto';
$CFG['trans_name']['et'] 	= 'Estonian';
$CFG['trans_name']['fo'] 	= 'Faroese';
$CFG['trans_name']['tl'] 	= 'Filipino';
$CFG['trans_name']['fy'] 	= 'Frisian';
$CFG['trans_name']['gl'] 	= 'Galician';
$CFG['trans_name']['ks'] 	= 'Georgian';
$CFG['trans_name']['gn'] 	= 'Guarani';
$CFG['trans_name']['gu'] 	= 'Gujarati';
$CFG['trans_name']['xx-hacker'] 	= 'Hacker';
$CFG['trans_name']['ha'] 	= 'Hausa';
$CFG['trans_name']['haw'] 	= 'Hawaiian';
$CFG['trans_name']['iw'] 	= 'Hebrew';

$CFG['trans_name']['hu'] 	= 'Hungarian';
$CFG['trans_name']['is'] 	= 'Icelandic';
$CFG['trans_name']['ig'] 	= 'Igbo';
$CFG['trans_name']['id'] 	= 'Indonesian';
$CFG['trans_name']['ia'] 	= 'Interlingua';
$CFG['trans_name']['ga'] 	= 'Irish';
$CFG['trans_name']['jw'] 	= 'Javanese';
$CFG['trans_name']['kn'] 	= 'Kannada';
$CFG['trans_name']['kk'] 	= 'Kazakh';
$CFG['trans_name']['rw'] 	= 'Kinyarwanda';
$CFG['trans_name']['rn'] 	= 'Kirundi';
$CFG['trans_name']['xx-klingon'] 	= 'Klingon';
$CFG['trans_name']['ku'] 	= 'Kurdish';
$CFG['trans_name']['ky'] 	= 'Kyrgyz';
$CFG['trans_name']['lo'] 	= 'Laothian';
$CFG['trans_name']['la'] 	= 'Latin';
$CFG['trans_name']['lv'] 	= 'Latvian';
$CFG['trans_name']['ln'] 	= 'Lingala';
$CFG['trans_name']['lt'] 	= 'Lithuanian';
$CFG['trans_name']['lg'] 	= 'Luganda';
$CFG['trans_name']['mk'] 	= 'Macedonian';
$CFG['trans_name']['mg'] 	= 'Malagasy';
$CFG['trans_name']['ms'] 	= 'Malay';
$CFG['trans_name']['ml'] 	= 'Malayalam';
$CFG['trans_name']['mt'] 	= 'Maltese';
$CFG['trans_name']['mi'] 	= 'Maori';
$CFG['trans_name']['mr'] 	= 'Marathi';
$CFG['trans_name']['mfe'] 	= 'Mauritian Creole';
$CFG['trans_name']['mo'] 	= 'Moldavian';
$CFG['trans_name']['mn'] 	= 'Mongolian';
$CFG['trans_name']['sr-ME'] 	= 'Montenegrin';
$CFG['trans_name']['ne'] 	= 'Nepali';
$CFG['trans_name']['nn'] 	= 'Norwegian (Nynorsk)';
$CFG['trans_name']['oc'] 	= 'Occitan';
$CFG['trans_name']['or'] 	= 'Oriya';
$CFG['trans_name']['om'] 	= 'Oromo';
$CFG['trans_name']['ps'] 	= 'Pashto';
$CFG['trans_name']['fa'] 	= 'Persian';
$CFG['trans_name']['xx-pirate'] 	= 'Pirate';
$CFG['trans_name']['pl'] 	= 'Polish';
$CFG['trans_name']['pt-BR'] 	= 'Portuguese (Brazil)';
$CFG['trans_name']['pt-PT'] 	= 'Portuguese (Portugal)';
$CFG['trans_name']['pa'] 	= 'Punjabi';
$CFG['trans_name']['qu'] 	= 'Quechua';
$CFG['trans_name']['ro'] 	= 'Romanian';
$CFG['trans_name']['rm'] 	= 'Romansh';
$CFG['trans_name']['gd'] 	= 'Scots Gaelic';
$CFG['trans_name']['sr'] 	= 'Serbian';
$CFG['trans_name']['sh'] 	= 'Serbo-Croatian';
$CFG['trans_name']['st'] 	= 'Sesotho';
$CFG['trans_name']['sn'] 	= 'Shona';
$CFG['trans_name']['sd'] 	= 'Sindhi';
$CFG['trans_name']['si'] 	= 'Sinhalese';
$CFG['trans_name']['sk'] 	= 'Slovak';
$CFG['trans_name']['sl'] 	= 'Slovenian';
$CFG['trans_name']['so'] 	= 'Somali';
$CFG['trans_name']['su'] 	= 'Sundanese';
$CFG['trans_name']['sw'] 	= 'Swahili';
$CFG['trans_name']['tg'] 	= 'Tajik';
$CFG['trans_name']['ta'] 	= 'Tamil';
$CFG['trans_name']['tt'] 	= 'Tatar';
$CFG['trans_name']['te'] 	= 'Telugu';
$CFG['trans_name']['th'] 	= 'Thai';
$CFG['trans_name']['ti'] 	= 'Tigrinya';
$CFG['trans_name']['to'] 	= 'Tonga';
$CFG['trans_name']['tr'] 	= 'Turkish';
$CFG['trans_name']['tk'] 	= 'Turkmen';
$CFG['trans_name']['tw'] 	= 'Twi';
$CFG['trans_name']['ug'] 	= 'Uighur';
$CFG['trans_name']['uk'] 	= 'Ukrainian';
$CFG['trans_name']['ur'] 	= 'Urdu';
$CFG['trans_name']['uz'] 	= 'Uzbek';
$CFG['trans_name']['vi'] 	= 'Vietnamese';
$CFG['trans_name']['cy'] 	= 'Welsh';
$CFG['trans_name']['xh'] 	= 'Xhosa';
$CFG['trans_name']['yi'] 	= 'Yiddish';
$CFG['trans_name']['yo'] 	= 'Yoruba';
$CFG['trans_name']['zu'] 	= 'Zulu';

/**
 * @var				string Google translate url version
 * @cfg_label 		Google translate url version
 * @cfg_key 		google_trans_url_version
 * @cfg_sub_head 	Google translate url <br />WARNING: Do not touch these settings unless you are absolutely 100% sure you know what they mean and what they will do. These are advanced settings only for programmers and should not be touched by an untrained person. Editing these options could result in your website no longer working.
 * @cfg_sec_name    Google Translator Setting
 * @cfg_section 	google_translate_url
 */
$CFG['google_trans_url_version'] = '1.0';
$CFG['google_trans_url'] = 'http://ajax.googleapis.com/ajax/services/language/translate?key='.$CFG['admin']['google_api']['key'].'&v=VAR_TRANS_VERSION&q=VAR_TRANS_TEXT&langpair=en%7CVAR_NEW_LANG';
?>