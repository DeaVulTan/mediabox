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
 * @var string Blog Post file activated
 * @cfg_label Blog Post file activated subject -- {site_name}
 * @cfg_key blog_post_activate_subject
 */
$LANG['blog_post_activate_subject'] = 'Blog Post activated - VAR_SITE_NAME';
/**
 * @var string Blog Post file activated
 * @cfg_label Blog Post file activated content -- {user_name}{blog_post_name}{blog_post_link}{link}{site_name}
 * @cfg_key blog_post_activate_content
 */
$LANG['blog_post_activate_content'] = 'Dear VAR_USER_NAME,

Your Post <b>VAR_BLOG_POST_NAME</b> has been activated,

VAR_BLOG_POST_LINK

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

/**
 * @var string Blog Post
 * @cfg_label Share Blog post subject -- {user_name}
 * @cfg_key blog_post_share_subject
 */
$LANG['blog_post_share_subject'] = 'VAR_USER_NAME sent you a blog post!';
/**
 * @var string Blog Post
 * @cfg_label Share Blog Post content -- {user_name}{blog_post_name}{blog_description}{personal_message}{link}{user_name}{site_name}
 * @cfg_key blog_post_share_content
 */
$LANG['blog_post_share_content'] = 'VAR_USER_NAME wants to share the following blog post with you:

<b>Blog Post Title: BLOG_POST_NAME </b>

<b>Blog Post Description</b>

BLOG_POST_DESCRIPTION <a href="VIEW_BLOG_POST">View full Blog Post</a>

or copy and paste the link below

VIEW_BLOG_POST

<b>Personal Message</b>

PERSONAL_MESSAGE

To learn more, please visit VAR_SITE_URL

Regards,
VAR_USER_NAME
VAR_SITE_URL';

 /**
 * @var string Blog Post
 * @cfg_label Flagged blog post subject -- {user_name}{blog_post_name}
 * @cfg_key blog_post_flagged_subject
 */
$LANG['blog_post_flagged_subject'] = 'VAR_USER_NAME flagged this post VAR_BLOG_POST_NAME!';
/**
 * @var string Blog Post
 * @cfg_label Flagged Blog post content -- {user_name}{blog_post_name}{blog_post_description}{flagged_title}{flagged_content}{user_name}{site_name}
 * @cfg_key blog_post_flagged_content
 */
$LANG['blog_post_flagged_content'] = '

<b>Blog Post Title</b>
VAR_BLOG_POST_NAME
<b>Blog Post Description</b>

VAR_BLOG_POST_DESCRIPTION

VAR_FLAGGED_TITLE

VAR_FLAGGED_CONTENT

By,
<b>VAR_USER_NAME</b>
VAR_SITE_NAME
';
/**
 * @var string Blog Post disapproved
 * @cfg_label  Blog Post disapproved subject -- {site_name}
 * @cfg_key blog_post_disapproved_subject
 */
$LANG['blog_post_disapproved_subject'] = 'Blog Post disapproved - VAR_SITE_NAME';
/**
 * @var string Blog Post disapproved
 * @cfg_label Blog Post dispparoved content -- {user_name}{blog_post_name}{blog_post_link}{link}{site_name}
 * @cfg_key blog_post_disapproved_content
 */
$LANG['blog_post_disapproved_content'] = 'Dear VAR_USER_NAME,

Your Post <b>VAR_BLOG_POST_NAME</b> has been disapproved by administrator,

<b>Admin Comment for Disapproval</b> : VAR_ADMIN_COMMENTS_FOR_POST_DISAPPORVAL

VAR_BLOG_POST_LINK

To learn more, please visit VAR_LINK
Regards,
VAR_SITE_NAME';

?>