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
 * @author 		karthiselvam_045at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version
 * @since 		2009-08-11
 */

/**
 * @var string Music
 * @cfg_label Share playlist subject <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_sec_name Music related Email Templates
 * @cfg_key music_playlist_share_subject
 */
$LANG['music_playlist_share_subject'] = 'VAR_USER_NAME отправил вам плейлист!';
/**
 * @var string MusicPlaylist
 * @cfg_label Share playlist content <ul><li>VAR_USER_NAME</li><li>VAR_PLAYLIST_NAME</li><li>VAR_MUSIC_PLAYLIST_IMAGE</li><li>VAR_MUSIC_PLAYLIST_DESCRIPTION</li><li>VAR_PERSONAL_MESSAGE</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_playlist_share_content
 */
$LANG['music_playlist_share_content'] = 'VAR_USER_NAME хочет поделиться  с вами следующей музыкой:
VAR_PLAYLIST_NAME

VAR_PLAYLIST_IMAGE

<b>Описание плейлиста</b>

VAR_MUSIC_PLAYLIST_DESCRIPTION

<b>Личные Сообщения</b>

VAR_PERSONAL_MESSAGE

Чтобы узнать больше, посетите VAR_LINK

С уважением,
VAR_USER_NAME
VAR_SITE_NAME';
/**
 * @var string Audio file activated
 * @cfg_label Audio file activated subject <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_activate_subject
 */
$LANG['music_activate_subject'] = 'Аудио активировано - VAR_SITE_NAME';
/**
 * @var string Music file activated
 * @cfg_label Music file activated content <ul><li>VAR_USER_NAME</li><li>VAR_MUSIC_TITLE</li><li>VAR_MUSIC_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_activate_content
 */
$LANG['music_activate_content'] = 'Уважаемый VAR_USER_NAME,

Ваш аудио файл(VAR_MUSIC_TITLE) активируется,

VAR_MUSIC_LINK

Чтобы узнать больше, посетите VAR_LINK

С уважением,
VAR_SITE_NAME';
/**
 * @var string Music
 * @cfg_label Share music subject <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key music_share_subject
 */
$LANG['music_share_subject'] = 'VAR_USER_NAME отправил вам музыку';
/**
 * @var string Music
 * @cfg_label Share Music content <ul></li>VAR_USER_NAME</li><li>VAR_MUSIC_IMAGE</li><li>VAR_MUSIC_DESCRIPTION</li><li>VAR_PERSONAL_MESSAGE</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_share_content
 */
$LANG['music_share_content'] = 'VAR_USER_NAME хочет поделиться следующий музыкой с тобой:

VAR_MUSIC_IMAGE

<b>Описание Музыки</b>

VAR_MUSIC_DESCRIPTION

<b>Личные Сообщения</b>

VAR_PERSONAL_MESSAGE

Чтобы узнать больше, посетите VAR_LINK

С уважением,
VAR_USER_NAME
VAR_SITE_NAME';
/**
 * @var string Music
 * @cfg_label Flagged music subject <ul><li>VAR_USER_NAME</li><li>VAR_MUSIC_TITLE</li></ul>
 * @cfg_key music_flagged_subject
 */
$LANG['music_flagged_subject'] = 'VAR_USER_NAME flagged this music VAR_MUSIC_TITLE!';
/**
 * @var string Music
 * @cfg_label Flagged music content <ul><li>VAR_USER_NAME</li><li>VAR_MUSIC_IMAGE</li><li>VAR_MUSIC_TITLE</li><li>VAR_MUSIC_DESCRIPTION</li><li>VAR_FLAGGED_TITLE</li><li>VAR_FLAGGED_CONTENT</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_flagged_content
 */
$LANG['music_flagged_content'] = '

VAR_MUSIC_IMAGE

<b>Название музыки</b>
VAR_MUSIC_TITLE

<b>Описание музыки</b>

VAR_MUSIC_DESCRIPTION

VAR_FLAGGED_TITLE

VAR_FLAGGED_CONTENT

От,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';

/**
 * @var string Deleted Music
 * @cfg_label Deleted your music subject <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_delete_subject
 */
$LANG['music_delete_subject'] = 'Удалить вашу музыку - VAR_SITE_NAME';
/**
 * @var string Deleted Music
 * @cfg_label Deleted your music content <ul><li>VAR_USER_NAME</li><li>VAR_MUSIC_TITLE</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_delete_content
 */
$LANG['music_delete_content'] = 'Уважаемый VAR_USER_NAME,

К сожалению, некоторые проблемы с вашей музыкой, поэтому мы должны удалить вашу музыку(VAR_MUSIC_TITLE)

Чтобы узнать больше, посетите VAR_LINK

С уважением,
VAR_SITE_NAME';

/**
 * @var string Purchased Music
 * @cfg_label Purchased your music subject <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_purchased_subject
 */
$LANG['music_purchased_subject'] = 'Purchased Your Music - VAR_SITE_NAME';
/**
 * @var string Purchased Music
 * @cfg_label Purchased your music content <ul><li>VAR_USER_NAME</li><li>VAR_MUSIC_TITLE</li><li>VAR_MUSIC_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_purchased_content
 */
$LANG['music_purchased_content'] = 'Dear VAR_USER_NAME,
Your Music has been purchased(VAR_MUSIC_TITLE)
VAR_MUSIC_LINK
To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Purchased Album
 * @cfg_label Purchased your album subject <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key album_purchased_subject
 */
$LANG['album_purchased_subject'] = 'Purchased Your Album - VAR_SITE_NAME';
/**
 * @var string Purchased Music
 * @cfg_label Purchased your music content <ul><li>VAR_USER_NAME</li><li>VAR_ALBUM_TITLE</li><li>VAR_ALBUM_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key album_purchased_content
 */
$LANG['album_purchased_content'] = 'Dear VAR_USER_NAME,
Your Album has been purchased(VAR_ALBUM_TITLE)
VAR_ALBUM_LINK
To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Music Comment Received
 * @cfg_label Comment received for Music subject <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_comment_received_subject
 */
$LANG['music_comment_received_subject'] = 'Пользователь прокомментировал вашу музыки - VAR_SITE_NAME';
/**
 * @var string Music Comment Received
 * @cfg_label Comment received for Music content <ul><li>VAR_USER_NAME</li><li>VAR_USER</li><li>VAR_MUSIC_TITLE</li><li>VAR_COMMENT</li><li>VAR_MUSIC_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key music_comment_received_content
 */
$LANG['music_comment_received_content'] = 'Уважаемый VAR_USER_NAME,

VAR_USER прокомментировал вашу музыки (VAR_MUSIC_TITLE),

Комментарий:
	VAR_COMMENT

Для просмотра дополнительной информации перейти к следующей ссылке:
VAR_MUSIC_LINK

Чтобы узнать больше, посетите VAR_LINK

С уважением,
VAR_SITE_NAME';
?>