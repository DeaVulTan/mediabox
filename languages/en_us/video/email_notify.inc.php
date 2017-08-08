<?php
/**
 * Language file to handle email templates
 *
 * This file has the email messages necessary for mail sending for various
 * pages. The admin can change the email template values from the admin interface.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Email_templates###
 * @author 		selvaraj_47ag04
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: email_notify.inc.php 138 2008-03-31 07:43:22Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * @var string Problem in video file
 * @cfg_label Problem in video file upload subject -- {site_name}
 * @cfg_sec_name Video related Email Templates
 * @cfg_key video_invalid_upload_subject
 */
$LANG['video_invalid_upload_subject'] = 'Неправильно загруженный файл - VAR_SITE_NAME';
/**
 * @var string Problem in video file
 * @cfg_label Problem in video file upload content -- {user_name}{video_title}{link}{site_name}
 * @cfg_key video_invalid_upload_content
 */
$LANG['video_invalid_upload_content'] = 'Уважаемый VAR_USER_NAME,

К сожелению, в загруженном видео файле были некоторые проблемы(VAR_VIDEO_TITLE),
поэтому файл не может быть активирован

Для получения подробной информации, поситите пожалуйста VAR_LINK
С уважением,
VAR_SITE_NAME';
/**
 * @var string Video file activated
 * @cfg_label Video file activated subject -- {site_name}
 * @cfg_key video_activate_subject
 */
$LANG['video_activate_subject'] = 'Видео активировано - VAR_SITE_NAME';
/**
 * @var string Video file activated
 * @cfg_label Video file activated content -- {user_name}{video_title}{video_link}{link}{site_name}
 * @cfg_key video_activate_content
 */
$LANG['video_activate_content'] = 'Уважаемый {user_name},

Ваш видео файл({video_title}) активирован,

{video_link}

Для получения подробной информации, поситите пожалуйста {link}
С уважением,
{site_name}';
/**
 * @var string Video
 * @cfg_label Share video subject -- {user_name}
 * @cfg_key video_share_subject
 */
$LANG['video_share_subject'] = 'VAR_USER_NAME отправил вам видео!';
/**
 * @var string Video
 * @cfg_label Share video content -- {user_name}{video_image}{video_description}{personal_message}{link}{user_name}{site_name}
 * @cfg_key video_share_content
 */
$LANG['video_share_content'] = 'VAR_USER_NAME хочет поделиться с вами следуйшим видео:

VAR_VIDEO_IMAGE

<b>Видео Описание</b>

VAR_Видео_Описание

<b>Личное сообщение</b>

VAR_Личное_сообщение

Для получения подробной информации, поситите пожалуйста VAR_SITE_URL

С уважением,
VAR_USER_NAME
VAR_SITE_NAME';
/**
 * @var string Video
 * @cfg_label Flagged video subject -- {user_name}{video_title}
 * @cfg_key video_flagged_subject
 */
$LANG['video_flagged_subject'] = 'VAR_USER_NAME flagged this video VAR_VIDEO_TITLE!';

/**
 * @var string Video
 * @cfg_label Flagged video content -- {user_name}{video_image}{video_title}{video_description}{flagged_title}{flagged_content}{user_name}{site_name}
 * @cfg_key video_flagged_content
 */
$LANG['video_flagged_content'] = '

VAR_VIDEO_IMAGE

<b>Название видео</b>
VAR_VIDEO_TITLE
<b>Видео Описание</b>

VAR_Видео_Описание

VAR_FLAGGED_TITLE

VAR_FLAGGED_CONTENT

By,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';
/**
 * @var string Video
 * @cfg_label Request for video activation subject -- {user_name}{video_title}
 * @cfg_key video_activate_request_subject
 */
$LANG['video_activate_request_subject'] = 'VAR_USER_NAME хочет активизировать это видео VAR_VIDEO_TITLE!';
/**
 * @var string Video
 * @cfg_label Request for video activation subject -- {user_name}{video_image}{video_title}{video_description}{user_name}{site_name}{video_title_admin_link}
 * @cfg_key video_activate_request_content
 */
$LANG['video_activate_request_content'] = '

<b>Video Title</b>
VAR_VIDEO_TITLE
<b>Видео Описание</b>

VAR_Видео_Описание

VAR_USER_NAME want to VAR_VIDEO_TITLE_ADMIN_LINK this video VAR_VIDEO_TITLE

By,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';

/**
 * @var string Deleted Video
 * @cfg_label Deleted your video subject -- {site_name}
 * @cfg_key video_delete_subject
 */
$LANG['video_delete_subject'] = 'Delete your video - VAR_SITE_NAME';
/**
 * @var string Deleted Video
 * @cfg_label Deleted your video content -- {user_name}{video_title}{link}{site_name}
 * @cfg_key video_delete_content
 */
$LANG['video_delete_content'] = 'Уважаемый VAR_USER_NAME,

К сожелению, некоторая проблема в Вашем видео, поэтому, мы должны удалить Ваше видео(VAR_VIDEO_TITLE)

Для получения подробной информации, поситите пожалуйста VAR_LINK
С уважением,
VAR_SITE_NAME';

/**
 * @var string Video Comment Received
 * @cfg_label Comment received for Video subject -- {site_name}
 * @cfg_key video_comment_received_subject
 */
$LANG['video_comment_received_subject'] = 'Пользователь прокомментировал Ваше Видео - {site_name}';
/**
 * @var string Video Comment Received
 * @cfg_label Comment received for Video content -- {user_name}{video_title}{video_link}{link}{site_name}
 * @cfg_key video_comment_received_content
 */
$LANG['video_comment_received_content'] = 'Dear VAR_USER_NAME,

VAR_USER прокомментировал Ваше Видео (VAR_VIDEO_TITLE),

Комментарий:
	VAR_COMMENT

Для получения подробной информации, перейдите:
VAR_VIDEO_LINK

Для получения подробной информации, поситите пожалуйста VAR_LINK
С уважением,
VAR_SITE_NAME';

/**
 * @var string Video Response Received
 * @cfg_label Response received for Video subject -- {site_name}
 * @cfg_key video_response_received_subject
 */
$LANG['video_response_received_subject'] = 'Пользователь Ответил на Ваше Видео - VAR_SITE_NAME';
/**
 * @var string Video Response Received
 * @cfg_label Response received for Video content -- {user_name}{video_title}{video_link}{link}{site_name}
 * @cfg_key video_response_received_content
 */
$LANG['video_response_received_content'] = 'Уважаемый VAR_USER_NAME,

VAR_USER Ответил на Ваше Видео (VAR_VIDEO_TITLE),

	RESPONDED_VIDEO_IMG  <br />
	RESPONDED_VIDEO_TITLE

Для получения подробной информации, перейдите:
VAR_VIDEO_LINK

Для получения подробной информации, поситите пожалуйстаVAR_LINK
С уважением,
VAR_SITE_NAME';


?>