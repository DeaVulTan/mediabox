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
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

/**
 * @var string Article file activated
 * @cfg_label Article file activated subject -- <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_activate_subject
 */
$LANG['article_activate_subject'] = 'Article activated - VAR_SITE_NAME';
/**
 * @var string Article file activated
 * @cfg_label Article file activated content -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_TITLE</li><li>VAR_ARTICLE_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME<li></ul>
 * @cfg_key article_activate_content
 */
$LANG['article_activate_content'] = 'Dear VAR_USER_NAME,

Your Article <b>VAR_ARTICLE_TITLE</b> is activated,

VAR_ARTICLE_LINK

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Article
 * @cfg_label Share article subject -- <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key article_share_subject
 */
$LANG['article_share_subject'] = 'VAR_USER_NAME sent you a article!';
/**
 * @var string Article
 * @cfg_label Share article content -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_IMAGE</li><li>VAR_ARTICLE_DESCRIPTION</li><li>VAR_PERSONAL_MESSAGE</li><li>VAR_LINK</li><li>VAR_USER_NAME</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_share_content
 */
$LANG['article_share_content'] = 'VAR_USER_NAME wants to share the following article with you:

<b>Article Title: VAR_ARTICLE_TITLE</b>

<b>Article Summary</b>

VAR_ARTICLE_SUMMARY <a href="VAR_VIEW_ARTICLE">View full article</a>

or copy and paste the link below

VAR_VIEW_ARTICLE

<b>Personal Message</b>

VAR_PERSONAL_MESSAGE

To learn more, please visit VAR_SITE_URL

Regards,
VAR_USER_NAME
VAR_SITE_NAME';

 /**
 * @var string Article
 * @cfg_label Flagged article subject -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_TITLE</li></ul>
 * @cfg_key article_flagged_subject
 */
$LANG['article_flagged_subject'] = 'VAR_USER_NAME flagged this article VAR_ARTICLE_TITLE!';
/**
 * @var string Article
 * @cfg_label Flagged article content -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_TITLE</li><li>VAR_ARTICLE_DESCRIPTION</li><li>VAR_FLAGGED_TITLE</li><li>VAR_FLAGGED_CONTENT</li><li>VAR_USER_NAME</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_flagged_content
 */
$LANG['article_flagged_content'] = '

<b>Article Title</b>
VAR_ARTICLE_TITLE
<b>Article Description</b>

VAR_ARTICLE_DESCRIPTION

VAR_FLAGGED_TITLE

VAR_FLAGGED_CONTENT

By,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';

/**
 * @var string Article file disapproved
 * @cfg_label Article file disapproved subject -- <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_disapproved_subject
 */
$LANG['article_disapproved_subject'] = 'Article disapproved - VAR_SITE_NAME';
/**
 * @var string Article file disapproved
 * @cfg_label Article file dispparoved content -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_TITLE</li><li>VAR_ARTICLE_ADMIN_COMMENT_FOR_DISAPPROVAL</li><li>VAR_ARTICLE_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_disapproved_content
 */
$LANG['article_disapproved_content'] = 'Dear VAR_USER_NAME,

Your Article <b>VAR_ARTICLE_TITLE</b> has been disapproved by administrator,

<b>Admin Comment for Disapproval</b> : VAR_ARTICLE_ADMIN_COMMENT_FOR_DISAPPROVAL

VAR_ARTICLE_LINK

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Deleted Article
 * @cfg_label Deleted your article subject -- <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_delete_subject
 */
$LANG['article_delete_subject'] = 'Your Article has been deleted - VAR_SITE_NAME';
/**
 * @var string Deleted Article
 * @cfg_label Deleted your article content -- <ul><li>VAR_USER_NAME</li><li>VAR_ARTICLE_TITLE</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key article_delete_content
 */
$LANG['article_delete_content'] = 'Dear VAR_USER_NAME,

Sorry, There is some problem in your article due to that we have deleted it(VAR_ARTICLE_TITLE)

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';
 ?>