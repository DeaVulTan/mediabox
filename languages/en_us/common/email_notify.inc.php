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
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: email_notify.inc.php 138 2008-03-31 07:43:22Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * @var string Registration Activation Code Subject
 * @cfg_label Subject
 * @cfg_key activation_subject
 * @cfg_sub_head Registration Activation Code <ul><li>VAR_USER_NAME</li><li>VAR_ACTIVATION_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_sec_name Allowed common variables inside the template subject and content <ul><li>VAR_SITE_NAME</li><li>VAR_SITE_URL</li><li>VAR_SITE_HOST</li></ul>
 * @cfg_section general
 */
$LANG['activation_subject'] = 'Ваш код активации';
/**
 * @var string Registration Activation Code Content
 * @cfg_label Content
 * @cfg_key activation_message
 */
$LANG['activation_message'] = 'Уважаемый VAR_USER_NAME ,

Ваша учетная уже готова.

Пожалуйста, нажмите на ссылку ниже, чтобы подтвердить свой адрес электронной почты и активировать свою учетную запись.
VAR_ACTIVATION_LINK

Чтобы узнать больше, посетите  VAR_LINK

С уважением,
VAR_SITE_NAME';
/**
 * @var string welcome email subject
 * @cfg_label Subject
 * @cfg_sub_head Welcome email <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key welcome_email_subject
 */
$LANG['welcome_email_subject'] = 'Добро пожаловать на VAR_SITE_NAME';
/**
 * @var string welcome email content
 * @cfg_label Content
 * @cfg_key welcome_email_content
 */
$LANG['welcome_email_content'] = 'Уважаемый VAR_USER_NAME ,

Добро пожаловать на VAR_SITE_NAME ,

посещение url: VAR_SITE_URL

от
VAR_SITE_NAME';
/**
 * @#var string This is used in groupInvite.php. This is used while sending invitation to join group for internal messages
 * @#cfg_label Subject
 * @#cfg_sub_head Sending invitation to join group for internal messages <ul><li>VAR_GROUP_NAME</li><li>VAR_FRIEND_NAME</li><li>VAR_USER_NAME</li><li>VAR_ACCEPTANCE_FORM</li><li>VAR_ADMIN_NAME</li></ul>
 * @#cfg_key mail_group_invite_member_subject
 */
$LANG['mail_group_invite_member_subject'] = 'Приглашение в группу  VAR_GROUP_NAME ';
/**
 * @#var string This is used in groupInvite.php. This is used while sending invitation to join group for internal messages
 * @#cfg_label Content
 * @#cfg_key mail_group_invite_member_message
 */
$LANG['mail_group_invite_member_message'] = 'Уважаемый VAR_FRIEND_NAME ,

VAR_USER_NAME приглашает Вас присоединиться к VAR_GROUP_NAME .

VAR_ACCEPTANCE_FORM

С уважением,
VAR_ADMIN_NAME ';
/**
 * @var string New mail received
 * @cfg_label Subject
 * @cfg_sub_head New mail received <ul><li>VAR_RECEIVER_NAME</li><li>VAR_SENDER_NAME</li><li>VAR_MAIL_LINK</li></ul>
 * @cfg_key new_mail_received_subject
 */
$LANG['new_mail_received_subject'] = 'Новая почта получила - VAR_SITE_NAME';
/**
 * @var string New mail received
 * @cfg_label Content
 * @cfg_key new_mail_received_content
 */
$LANG['new_mail_received_content'] = 'Уважаемый VAR_RECEIVER_NAME ,

Вы получили почту с VAR_SENDER_NAME ,

VAR_MAIL_LINK

Чтобы узнать больше, посетите VAR_SITE_URL
С уважением,
VAR_SITE_NAME';
/**
 * @var string This is used on mailInboxRead.php.This is used while send notification mail
 * @cfg_label Subject
 * @cfg_sub_head Send notification mail <ul><li>VAR_NAME</li><li>VAR_DATETIME</li></ul>
 * @cfg_key mail_opened_notify_subject
 */
$LANG['mail_opened_notify_subject'] = 'Сообщение об Уведомление для';
/**
 * @var string This is used on mailInboxRead.php. This is used while send notification mail
 * @cfg_label Content
 * @cfg_key mail_opened_notify_message
 */
$LANG['mail_opened_notify_message'] = 'Сообщение Уведомление:

Ваше письмо по адресу VAR_NAME было открыто VAR_DATETIME';
/**
 * @var string Friends request subject
 * @cfg_label Subject
 * @cfg_sub_head Friends request <ul><li>VAR_FRIEND_NAME</li><li>VAR_USER_NAME</li><li>VAR_BE_FRIEND_URL</li></ul>
 * @cfg_key friend_request_subject
 */
$LANG['friend_request_subject'] = 'Friends request from VAR_SITE_NAME';
/**
 * @var string Friends request content
 * @cfg_label Content
 * @cfg_key friend_request_content
 */
$LANG['friend_request_content'] = 'Hi VAR_FRIEND_NAME ,

VAR_USER_NAME хочет присоеденится к кругу вашех друзей, нажмите ссылку ниже, чтобы принять / отклонить запрос.

VAR_BE_FRIEND_URL

Чтобы узнать больше, посетите VAR_SITE_URL
С уважением,
VAR_SITE_NAME';
/**
 * @var string Reject Friends
 * @cfg_label Subject
 * @cfg_sub_head Declined to join in your Friends Circle <ul><li>VAR_USER_NAME</li><li>VAR_FRIEND_NAME</li><li>VAR_USER_PROFILE_LINK</li></ul>
 * @cfg_key decline_friend_subject
 */
$LANG['decline_friend_subject'] = 'VAR_USER_NAME  - отказался присоединиться к кругу вашех друзей';
/**
 * @var string Reject Friends
 * @cfg_label Content
 * @cfg_key decline_friend_content
 */
$LANG['decline_friend_content'] = 'Уважаемый VAR_FRIEND_NAME ,
VAR_USER_NAME отказался присоединиться к кругу вашех друзей.
VAR_USER_PROFILE_LINK';
/**
 * @var string Login Reactivation Code Subject
 * @cfg_label Subject
 * @cfg_sub_head Login Reactivation Code <ul><li>VAR_USER_NAME</li><li>VAR_ACTIVATION_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key reactivation_login_subject
 */
$LANG['reactivation_login_subject'] = 'Ваш код активации';
/**
 * @var string Login Reactivation Code Content
 * @cfg_label Content
 * @cfg_key reactivation_login_message
 */
$LANG['reactivation_login_message'] = 'Уважаемый VAR_USER_NAME ,

Ваш код активации. Пожалуйста, нажмите на следующую ссылку, чтобы активировать:
VAR_ACTIVATION_LINK

Чтобы узнать больше, посетите VAR_LINK

С Уважением,
VAR_SITE_NAME';
/**
 * @var string Forgot Password Reactivation Code Subject
 * @cfg_label Subject
 * @cfg_sub_head Forgot Password Reactivation Code <ul><li>VAR_USER_NAME</li><li>VAR_ACTIVATION_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key reactivation_forgotpass_subject
 */
$LANG['reactivation_forgotpass_subject'] = 'Ваш код активации';
/**
 * @var string Forgot Password Reactivation Code Content
 * @cfg_label Content
 * @cfg_key reactivation_forgotpass_message
 */
$LANG['reactivation_forgotpass_message'] = 'Уважаемый VAR_USER_NAME ,

Ваш код активации. Пожалуйста, нажмите на следующую ссылку, чтобы активировать:
VAR_ACTIVATION_LINK

Чтобы узнать больше, посетите VAR_LINK

С Уважением,
VAR_SITE_NAME';
/**
 * @var string Forgot Password Code Subject
 * @cfg_label Subject
 * @cfg_sub_head Forgot Password Code <ul><li>VAR_USER_NAME</li><li>VAR_ACTIVATION_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key forgot_subject
 */
$LANG['forgot_subject'] = 'Forgot Password code';
/**
 * @var string Forgot Password Code Content
 * @cfg_label Content
 * @cfg_key forgot_message
 */
$LANG['forgot_message'] = 'Уважаемый VAR_USER_NAME ,

имя пользователя аккаунта: VAR_USER_NAME

Пожалуйста, нажмите на следующую ссылку для сброса пароля

Вам будет предложено предоставить свои имя пользователя и новый пароль.

VAR_ACTIVATION_LINK

Чтобы узнать больше, посетите VAR_LINK

С Уважением,
VAR_SITE_NAME';
/**
 * @var string Invite Friends
 * @cfg_label Subject
 * @cfg_sub_head Request to Join in your Friends Circle <ul><li>VAR_FRIEND_NAME</li><li>VAR_USER_NAME</li><li>VAR_USER_MESSAGE</li><li>VAR_ACCEPTANCE_FORM</li><li>VAR_FRIEND_PROFILE_LINK</li></ul>
 * @cfg_key request_friend_subject
 */
$LANG['request_friend_subject'] = 'VAR_FRIEND_NAME - Отправить запрос на вступления в круг вашех друзей';
/**
 * @var string Invite Friends
 * @cfg_label Content
 * @cfg_key request_friend_content
 */
$LANG['request_friend_content'] = 'Уважаемый VAR_USER_NAME,
Я хотел бы присоединиться в Круг вашех друзей.

VAR_USER_MESSAGE

Пожалуйста, примите мою просьбу.
VAR_ACCEPTANCE_FORM

С Уважением,
VAR_FRIEND_PROFILE_LINK';
/**
 * @var string New friend request received
 * @cfg_label Subject
 * @cfg_sub_head New friend request received <ul><li>VAR_RECEIVER_NAME</li><li>VAR_SENDER_NAME</li><li>VAR_MAIL_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key new_friend_request_received_subject
 */
$LANG['new_friend_request_received_subject'] = 'New friend request received - VAR_SITE_NAME';
/**
 * @var string New friend request received
 * @cfg_label Content
 * @cfg_key new_friend_request_received_content
 */
$LANG['new_friend_request_received_content'] = 'Уважаемый VAR_RECEIVER_NAME ,
Вы получили предложение дружбы от VAR_SENDER_NAME ,

VAR_MAIL_LINK

Чтобы узнать больше, посетите VAR_LINK

С Уважением,
VAR_SITE_NAME';
/**
 * @var string Invite Friends
 * @cfg_label Subject
 * @cfg_sub_head Invite Friends <ul><li>VAR_USER_NAME</li><li>VAR_FRIEND_NAME</li><li>VAR_PERSONAL_MESSAGE</li><li>VAR_LINK</li><li>VAR_BLOCK_LINK</li></ul>
 * @cfg_key invite_friend_subject
 */
$LANG['invite_friend_subject'] = 'VAR_USER_NAME  - Регистрация со мной в VAR_SITE_NAME';
/**
 * @var string Invite Friends
 * @cfg_label Content
 * @cfg_key invite_friend_content
 */
$LANG['invite_friend_content'] = 'Уважаемый VAR_FRIEND_NAME ,

Я являюсь пользователем www.mediabox.uz .
И я хотел бы предложить вам такую ​​же возможность!

VAR_PERSONAL_MESSAGE

Чтобы узнать больше, посетите VAR_LINK
С уважением,
VAR_USER_NAME
www.mediabox.uz

Вы можете заблокировать VAR_USER_NAME на отправку Вам сообщения тут:
VAR_BLOCK_LINK

Можно заблокировать всех пользователей VAR_SITE_NAME на отправку Вам электронную почту тут:

VAR_BLOCK_LINK';
/**
 * @var string Default friend added subject
 * @cfg_label Subject
 * @cfg_sub_head Default friend added <ul><li>VAR_USER_NAME</li><li>VAR_FRIEND_NAME</li></ul>
 * @cfg_key default_friend_joined_subject
 */
$LANG['default_friend_joined_subject'] = 'VAR_FRIEND_NAME Welcomes You to VAR_SITE_NAME !';
/**
 * @var string Default friend added
 * @cfg_label Content
 * @cfg_key default_friend_joined_content
 */
$LANG['default_friend_joined_content'] = 'Привет VAR_USER_NAME ,

Добро пожаловать VAR_SITE_NAME , лучшее место для обмена информации и общения с друзьями!

I\'m VAR_FRIEND_NAME , и я нахожусь здесь, чтобы помочь вам с VAR_SITE_NAME и ответить на любые ваши вопросы. As a new member, automatically I become your friend. If there is anything you need, if you just want to say \'Hi\' or if you have recommendations, send me a message anytime!

<b>Как я могу помочь?</b>
<li>Вы можете проверить мой круг друзей и добавлять их, если хотите.</li>
<li>Если у Вас возникли трудности при переходе на сайт, дайте мне знать.</li>
<li>Или, если вам не нужна моя помощь, вы можете удалить меня, как друга, когда захотите.</li>

Я буду видеть Вас на VAR_SITE_NAME !

С Уважением,
VAR_FRIEND_NAME';
/**
 * @var string Accept Friends
 * @cfg_label Subject
 * @cfg_sub_head Joined in your Friends Circle <ul><li>VAR_USER_NAME</li><li>VAR_FRIEND_NAME</li><li>VAR_USER_PROFILE_LINK</li></ul>
 * @cfg_key accept_friend_subject
 */
$LANG['accept_friend_subject'] = 'VAR_USER_NAME - вступил в круг вашех друзей';
/**
 * @var string Accept Friends
 * @cfg_label Content
 * @cfg_key accept_friend_content
 */
$LANG['accept_friend_content'] = 'Уважаемый VAR_FRIEND_NAME ,
VAR_USER_NAME Вступил в круг вашех друзей.
VAR_USER_PROFILE_LINK';
/**
 * @var string New User Welcome Message
 * @cfg_label Subject
 * @cfg_sub_head New User Welcome Message <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key welcome_message_subject
 */
//$LANG['welcome_message_subject'] = 'Добро пожаловать на VAR_SITE_NAME';
$LANG['welcome_message_subject'] = 'Добро пожаловать на www.mediabox.uz';
/**
 * @var string New User Welcome Message
 * @cfg_label Content
 * @cfg_key welcome_message_content
 */
$LANG['welcome_message_content'] = 'Уважаемый VAR_USER_NAME ,

Добро пожаловать на наш медиа портал Mediabox.uz . Пожалуйста объязательно ознакомьтесь с <a href="http://mediabox.uz/static/useterms.html">"Условиями пользования"</a> данным ресурсом!

С Уважением,
Администрация портала!';
/**
 * @#var string Problem in video file
 * @#cfg_label Subject
 * @#cfg_sub_head Problem in video file upload <ul><li>VAR_USER_NAME</li><li>VAR_VIDEO_TITLE</li><li>VAR_LINK</li></ul>
 * @#cfg_key video_invalid_upload_subject
 */
$LANG['video_invalid_upload_subject'] = 'Invalid Uploaded File - VAR_SITE_NAME ';
/**
 * @#var string Problem in video file
 * @#cfg_label Content
 * @#cfg_key video_invalid_upload_content
 */
$LANG['video_invalid_upload_content'] = 'Dear VAR_USER_NAME ,

Sorry, some problem in your uploaded video file( VAR_VIDEO_TITLE ),
so we couldnt activate the file

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME ';
/**
 * @#var string Video file activated
 * @#cfg_label Subject
 * @#cfg_sub_head Video file activated <ul><li>VAR_USER_NAME</li><li>VAR_VIDEO_TITLE</li><li>VAR_VIDEO_LINK</li><li>VAR_LINK</li></ul>
 * @#cfg_key video_activate_subject
 */
$LANG['video_activate_subject'] = 'Видео активированный - VAR_SITE_NAME ';
/**
 * @#var string Video file activated
 * @#cfg_label Content
 * @#cfg_key video_activate_content
 */
$LANG['video_activate_content'] = 'Уважаемый VAR_USER_NAME ,

Ваш видео файл( VAR_VIDEO_TITLE ) активирован,

 VAR_VIDEO_LINK

Чтобы узнать больше, посетите VAR_LINK
С Уважением,
VAR_SITE_NAME ';
/**
 * @var string Registration By Admin Subject
 * @cfg_label Subject
 * @cfg_sub_head Registration By Admin <ul><li>VAR_USER_NAME</li><li>VAR_PASSWORD</li><li>VAR_ACTIVATION_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key activation_admin_subject
 */
$LANG['activation_admin_subject'] = 'Ваш код активации';
/**
 * @var string Registration By Admin Content
 * @cfg_label Content
 * @cfg_key activation_admin_message
 */
$LANG['activation_admin_message'] = 'Уважаемый VAR_USER_NAME ,

Ваша учетная запись создана администратором сайта.

информация

  имя пользователя: VAR_USER_NAME
  Пароль:  VAR_PASSWORD

Ваш код активации. Пожалуйста, нажмите на следующую ссылку, чтобы активировать:
 VAR_ACTIVATION_LINK

Чтобы узнать больше, посетите VAR_LINK

С Уважением,
VAR_SITE_NAME';
/**
 * @#var string Membership approve subject
 * @#cfg_label Subject
 * @#cfg_sub_head Membership approve <ul><li>VAR_USER_NAME</li><li>VAR_LINK</li></ul>
 * @#cfg_key membership_welcome_email_subject
 */
$LANG['membership_welcome_email_subject']='Your Membership approved';
/**
 * @#var string Membership approve Content
 * @#cfg_label Content
 * @#cfg_key membership_welcome_email_content
 */
$LANG['membership_welcome_email_content']='Dear VAR_USER_NAME ,

Your membership has been approved, You can now watch the full length video.

To learn more, please visit VAR_LINK

Regards,
VAR_SITE_NAME ';
/**
 * @#var string Report bugs subject
 * @#cfg_label Subject
 * @#cfg_sub_head Report bugs <ul><li>VAR_CATEGORY</li><li>VAR_REPORTER_NAME</li><li>VAR_REPORTER_EMAIL</li><li>VAR_SITE_IP</li><li>VAR_CONTENT</li></ul>
 * @#cfg_key report_bugs_email_subject
 */
$LANG['report_bugs_email_subject'] = 'Сообщить об ошибке - VAR_CATEGORY - VAR_SITE_URL';
/**
 * @#var string report bugs content
 * @#cfg_label Content
 * @#cfg_key report_bugs_email_content
 */
$LANG['report_bugs_email_content'] = 'Hi VAR_SITE_NAME,

Имя заявителя: VAR_REPORTER_NAME

Репортер Email: VAR_REPORTER_EMAIL

сайт Url: VAR_SITE_URL

IP: VAR_SITE_IP

Категория ошибке: VAR_CATEGORY

VAR_CONTENT ';
/**
 * @var string Profile Comment Received subject
 * @cfg_label Subject
 * @cfg_sub_head Profile Comment received <ul><li>VAR_USER_NAME</li><li>VAR_FROM_USER_NAME</li><li>VAR_SCRAP</li><li>VAR_PROFILE_LINK</li><li>VAR_LINK</li></ul>
 * @cfg_key profile_comment_received_subject
 */
$LANG['profile_comment_received_subject'] = 'New scrap for you';
/**
 * @var string Profile Comment Received
 * @cfg_label Content
 * @cfg_key profile_comment_received_content
 */
$LANG['profile_comment_received_content'] = 'Уважаемый VAR_USER_NAME ,

You have received a Scrap from VAR_FROM_USER_NAME,

Scrap Message:
	VAR_SCRAP

To read more go to the following link:
 VAR_PROFILE_LINK

To learn more, please visit VAR_LINK

Regards,
VAR_SITE_NAME';
/**
 * @var string Subscription Notification
 * @cfg_label Subject
 * @cfg_sub_head Subscription Notification <ul><li>VAR_SUBSCRIBER</li><li>VAR_CONTENT</li><li>VAR_LINK</li></ul>
 * @cfg_key subscription_notification_subject
 */
$LANG['subscription_notification_subject'] = 'Подписка Обновления';
/**
 * @var string Subscription Notification
 * @cfg_label Content
 * @cfg_key subscription_notification_content
 */
$LANG['subscription_notification_content'] = 'Уважаемый VAR_SUBSCRIBER ,

Ваши подписки,

VAR_CONTENT

Чтобы узнать больше, посетите VAR_LINK
С Уважением,
VAR_SITE_NAME';
/**
 * @var string Friends birthday reminder
 * @cfg_label Subject
 * @cfg_sub_head Friends birthday reminder <ul><li>VAR_BIRTH_PERSION_NAME</li><li>VAR_FRIEND_USER_NAME</li><li>VAR_LINK_BIRTH_PERSION_NAME</li><li>VAR_BIRTHDATE</li></ul>
 * @cfg_key friends_birthday_reminder_subject
 */
$LANG['friends_birthday_reminder_subject'] = 'VAR_BIRTH_PERSION_NAME день рождения близко VAR_FRIEND_USER_NAME';
/**
 * @var string Friends birthday reminder
 * @cfg_label Friends Content
 * @cfg_key friends_birthday_reminder_content
 */
$LANG['friends_birthday_reminder_content'] = 'привет VAR_FRIEND_USER_NAME,

VAR_LINK_BIRTH_PERSION_NAME день рождения на VAR_BIRTHDATE

Чтобы узнать больше, посетите VAR_SITE_URL
С уважением,
VAR_SITE_NAME';
/**
 * @var string Friend suggestion
 * @cfg_label Subject
 * @cfg_sub_head Firends suggestion <ul><li>VAR_USER_NAME</li><li>VAR_SUGGESTION_COUNT</li><li>VAR_SUGGESTION_CONTENT</li></ul>
 * @cfg_key friend_suggestion_subject
 */
$LANG['friend_suggestion_subject'] = 'Друзья предлагают вам - VAR_SITE_NAME';
/**
 * @var string Firends suggestion
 * @cfg_label Content
 * @cfg_key friend_suggestion_content
 */
$LANG['friend_suggestion_content'] = 'Уважаемый VAR_USER_NAME ,

У вас VAR_SUGGESTION_COUNT предложений дружб,

VAR_SUGGESTION_CONTENT

Чтобы узнать больше, посетите VAR_SITE_URL
С уважением,
VAR_SITE_NAME';
?>