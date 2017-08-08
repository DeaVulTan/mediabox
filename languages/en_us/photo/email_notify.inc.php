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
 * @var string Photo file activated
 * @cfg_label Photo file activated subject -- <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_activate_subject
 */
$LANG['photo_activate_subject'] = 'Photo activated - VAR_SITE_NAME';
/**
 * @var string Photo file activated
 * @cfg_label Photo file activated content -- <ul><li>VAR_USER_NAME</li><li>VAR_PHOTO_TITLE</li><li>VAR_PHOTO_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_activate_content
 */
$LANG['photo_activate_content'] = 'Dear VAR_USER_NAME,

Your Photo VAR_THUMB_IMAGE(VAR_PHOTO_TITLE) is activated,

VAR_PHOTO_LINK

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Deleted Photo
 * @cfg_label Deleted your photo subject -- <ul><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_delete_subject
 */
$LANG['photo_delete_subject'] = 'Delete your photo - VAR_SITE_NAME';
/**
 * @var string Deleted Photo
 * @cfg_label Deleted your photo content -- <ul><li>VAR_SITE_NAME</li><li>VAR_PHOTO_TITLE</li><li>VAR_LINK</li><li>VAR_SITE_NAME<li></ul>
 * @cfg_key photo_delete_content
 */
$LANG['photo_delete_content'] = 'Dear VAR_USER_NAME,

Sorry, some problem in your photo, so we have to delete your photo(VAR_PHOTO_TITLE)

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Photo
 * @cfg_label Share photo subject -- <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key photo_share_subject
 */
$LANG['photo_share_subject'] = 'VAR_USER_NAME sent you a photo!';
/**
 * @var string Photo
 * @cfg_label Share Photo content -- <ul><li>VAR_USER_NAME</li><li>VAR_PHOTO_IMAGE</li><li>VAR_PHOTO_DESCRIPTION</li><li>VAR_PERSONAL_MESSAGE</li><li>VAR_LINK</li><li>VAR_USER_NAME</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_share_content
 */
$LANG['photo_share_content'] = 'VAR_USER_NAME wants to share the following photo with you:

VAR_PHOTO_IMAGE

<b>Photo Description</b>

VAR_PHOTO_DESCRIPTION

<b>Personal Message</b>

VAR_PERSONAL_MESSAGE

To learn more, please visit VAR_LINK

Regards,
VAR_USER_NAME
VAR_SITE_NAME';

/**
 * @var string Photo
 * @cfg_label Flagged photo subject -- <ul><li>VAR_USER_NAME</li><li>VAR_PHOTO_TITLE</li></ul>
 * @cfg_key photo_flagged_subject
 */
$LANG['photo_flagged_subject'] = 'VAR_USER_NAME flagged this photo VAR_PHOTO_TITLE!';
/**
 * @var string Photo
 * @cfg_label Flagged photo content -- <ul><li>VAR_USER_NAME</li><li>VAR_PHOTO_IMAGE</li><li>VAR_PHOTO_TITLE</li><li>VAR_PHOTO_DESCRIPTION</li><li>VAR_FLAGGED_TITLE</li><li>VAR_FLAGGED_CONTENT</li><li>VAR_USER_NAME</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_flagged_content
 */
$LANG['photo_flagged_content'] = '

VAR_PHOTO_IMAGE

<b>Photo Title</b>
VAR_PHOTO_TITLE
<b>Photo Description</b>

VAR_PHOTO_DESCRIPTION

VAR_FLAGGED_TITLE

VAR_FLAGGED_CONTENT

By,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';
/**
 * @var string Photo
 * @cfg_label Tagged photo subject -- <ul><li>VAR_USER_NAME</li></ul>
 * @cfg_key photo_tagged_subject
 */
$LANG['photo_tagged_subject'] = 'Your photo(s) tagged on VAR_SITE_NAME!';
/**
 * @var string Photo
 * @cfg_label Tagged photo content -- <ul><li>VAR_USER_NAME</li><li>VAR_PHOTO_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_tagged_content
 */
$LANG['photo_tagged_content'] = '

<b>Hi VAR_USER_NAME </b>

The following photo(s) tagged on VAR_SITE_NAME.

VAR_PHOTO_LINK

To learn more, please visit VAR_LINK

By,
VAR_SITE_NAME
';
/**
 * @var string Photo
 * @cfg_label Tagged photo subject -- <ul><li>VAR_USER_NAME</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_tagged_subject
 */
$LANG['photo_tagged_associated_subject'] = 'VAR_USER_NAME tagged you in a photo!';
/**
 * @var string Photo
 * @cfg_label Tagged photo content -- <ul><li>VAR_USER_NAME</li><li>VAR_TAG_NAME</li><li>VAR_PHOTO_LINK</li><li>VAR_LINK</li><li>VAR_SITE_NAME</li></ul>
 * @cfg_key photo_tagged_content
 */
$LANG['photo_tagged_associated_content'] = '

<b>Hi</b>

VAR_USER_NAME tagged you in a photo on VAR_SITE_NAME.

VAR_PHOTO_IMAGE

Click here to view the photo : VAR_PHOTO_LINK

To learn more, please visit VAR_LINK

By,
VAR_SITE_NAME
';
?>