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
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: email_notify.inc.php 138 2008-03-31 07:43:22Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * @var string send board to friend
 * @cfg_label Subject -- VAR_BOARD
 * @cfg_key send_board_to_friend_subject
 * @cfg_sec_name
 * @cfg_sub_head Email this Board
 */
$LANG['send_board_to_friend_subject'] = 'VAR_BOARD';
/**
 * @var string send quesion to friend
 * @cfg_label Body -- VAR_USERNAME, VAR_SENDER_NAME, VAR_BOARD, VAR_SITENAME, VAR_DESCRIPTION_OF_QUESTION
 * @cfg_key send_board_to_friend_content
 */
$LANG['send_board_to_friend_content'] = 'Hi VAR_USERNAME,

Your friend, VAR_SENDER_NAME, asked us to let you know about the board VAR_BOARD asked online at VAR_SITENAME.

Description of the Board
----------------------------------------------------------------------
VAR_DESCRIPTION_OF_QUESTION

<b>Personal Message</b>

VAR_PERSONAL_MESSAGE

Regards,
The VAR_SITENAME team';
/**
 * @var string send solution reply mail subject
 * @cfg_label Subject -- VAR_USERNAME, VAR_SENDER_NAME
 * @cfg_key solutions_reply_email_subject
 * @cfg_sub_head Reply posted for board asked
 */
$LANG['solutions_reply_email_subject'] = 'Dear VAR_USERNAME - VAR_SENDER_NAME has replied your board';
/**
 * @var string send solution reply mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_SITENAME, VAR_SENDER_NAME, VAR_BOARD_POSTED, VAR_BOARD_REPLY, VAR_LINK
 * @cfg_key solutions_reply_email_content
 */
$LANG['solutions_reply_email_content'] = 'Dear VAR_USERNAME,

VAR_SITENAME member, VAR_SENDER_NAME, replied for your board
VAR_BOARD_POSTED

Reply from VAR_SENDER_NAME
VAR_BOARD_REPLY

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string send board added mail subject
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key board_added_email_subject
 * @cfg_sub_head Email reminder to send added board details
 */
$LANG['board_added_email_subject'] = 'Dear VAR_USERNAME - Board added related to your subscribed keywords';
/**
 * @var string send board added mail body
 * @cfg_label Body - VAR_USERNAME, VAR_SITENAME, VAR_POSTED_BY, VAR_BOARD_POSTED, VAR_LINK
 * @cfg_key board_added_email_content
 */
$LANG['board_added_email_content'] = 'Dear VAR_USERNAME,

VAR_SITENAME member, VAR_POSTED_BY, asked board related to your subscribed keywords.
VAR_BOARD_POSTED

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string send best solution mail subject
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key best_solution_email_subject
 * @cfg_sub_head Sending email notification for best solution chosen
 */
$LANG['best_solution_email_subject'] = 'Dear VAR_USERNAME - Your solution is best';
/**
 * @var string send best solution mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_SITENAME, VAR_SENDER_NAME, VAR_BOARD_POSTED, VAR_BOARD_REPLY, VAR_LINK
 * @cfg_key best_solution_email_content
 */
$LANG['best_solution_email_content'] = 'Dear VAR_USERNAME,

VAR_SITENAME member, VAR_SENDER_NAME, selected your solution as best for the board.
VAR_BOARD_POSTED

Best solution of VAR_USERNAME
VAR_BOARD_REPLY

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string Removed best solution mail subject
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key remove_best_solution_email_subject
 * @cfg_sub_head Sending email notification for removed best solution chosen
 */
$LANG['remove_best_solution_email_subject'] = 'Dear VAR_USERNAME - Your solution is removed as best';
/**
 * @var string send remove best solution mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_SITENAME, VAR_SENDER_NAME, VAR_BOARD_POSTED, VAR_BOARD_REPLY, VAR_LINK
 * @cfg_key remove_best_solution_email_content
 */
$LANG['remove_best_solution_email_content'] = 'Dear VAR_USERNAME,

VAR_SITENAME member, VAR_SENDER_NAME, removed your solution as best for the board.
VAR_BOARD_POSTED

The solution of VAR_USERNAME
VAR_BOARD_REPLY

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string send abuse solution mail subject
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key abuse_solution_email_subject
 * @cfg_sub_head Sending email notification for abused solution
 */
$LANG['abuse_solution_email_subject'] = 'Dear VAR_USERNAME - Your solution is abused';
/**
 * @var string send abuse solution mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_SITENAME, VAR_BOARD_POSTED, VAR_USERNAME, VAR_BOARD_REPLY, VAR_LINK
 * @cfg_key abuse_solution_email_content
 */
$LANG['abuse_solution_email_content'] = 'Dear VAR_USERNAME,

One of VAR_SITENAME member, abused your solution for the board.
VAR_BOARD_POSTED

Abused solution of VAR_USERNAME
VAR_BOARD_REPLY

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string send abuse board mail subject
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key abuse_board_email_subject
 * @cfg_sub_head Sending email notification for abused board
 */
$LANG['abuse_board_email_subject'] = 'Dear VAR_USERNAME - Your board is abused';
/**
 * @var string send abuse board mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_SITENAME, VAR_LINK, VAR_BOARD_POSTED
 * @cfg_key abuse_board_email_content
 */
$LANG['abuse_board_email_content'] = 'Dear VAR_USERNAME,

One of VAR_SITENAME member, abused your board.
VAR_BOARD_POSTED

Use the below link to view the board
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string send favorite board
 * @cfg_label Subject -- VAR_USERNAME
 * @cfg_key board_subscribed_email_subject
 * @cfg_sub_head Alert for Favorite Board
 */
$LANG['board_subscribed_email_subject'] = 'Dear VAR_USERNAME - Reply posted related to your Favorite Board';
/**
 * @var string send favorite board reply added mail body
 * @cfg_label Body -- VAR_USERNAME, VAR_BOARD, VAR_SITENAME, VAR_LINK
 * @cfg_key board_subscribed_email_content
 */
$LANG['board_subscribed_email_content'] = 'Dear VAR_USERNAME,

Your favorite board VAR_BOARD in VAR_SITENAME has got a reply.

Use the below link to view the replies.
VAR_LINK

Regards,
The VAR_SITENAME team';
/**
 * @var string Board Publish Mail recieved
 * @cfg_label Board Publish mail received subject -- VAR_SITENAME
 * @cfg_key board_publish_subject
 * @cfg_sub_head Publish Mail alert
 */
$LANG['board_publish_subject'] = 'Your Board has Published - VAR_SITENAME';
/**
 * @var string Board Publish mail received
 * @cfg_label Board Publish mail received content -- VAR_USERNAME, VAR_BOARD,  VAR_LINK, VAR_SITENAME
 * @cfg_key board_publish_message
 */
$LANG['board_publish_message'] = 'Dear VAR_USERNAME,

Your Board VAR_BOARD posted in VAR_SITENAME has been Published by the site Admin,

Description of your Board
-----------------------------------
VAR_DESCRIPTION_OF_QUESTION

To learn more, please visit VAR_LINK

Regards,
VAR_SITENAME';
/**
 * @var string Solution Publish Mail recieved
 * @cfg_label Solution Publish mail received subject -- VAR_SITENAME
 * @cfg_key solution_publish_subject
 */
$LANG['solution_publish_subject'] = 'Your Solution has Published - VAR_SITENAME';
/**
 * @var string Solution Publish mail received
 * @cfg_label Solution Publish mail received content -- VAR_USERNAME, VAR_BOARD,  VAR_LINK, VAR_DESCRIPTION_OF_QUESTION, VAR_SITENAME
 * @cfg_key new_mail_received_content_for_solutions
 */
$LANG['solution_publish_message'] = 'Dear VAR_USERNAME,

Your Solution for the board VAR_BOARD, posted in  VAR_SITENAME has Published.

Your solution for this board
-----------------------------------
VAR_DESCRIPTION_OF_QUESTION

To learn more, please visit VAR_LINK
Regards,
VAR_SITENAME';
/**
 * @var string Solution Publish Mail recieved
 * @cfg_label Solution Publish mail received subject -- VAR_SITENAME
 * @cfg_key solution_publish_owner_subject
 */
$LANG['solution_publish_owner_subject'] = 'Reply for your Board has Published - VAR_SITENAME';
/**
 * @var string Solution Publish mail received
 * @cfg_label Solution Publish mail received content -- VAR_USERNAME, VAR_BOARD,  VAR_LINK, VAR_DESCRIPTION_OF_QUESTION, VAR_SITENAME
 * @cfg_key solution_publish_owner_message
 */
$LANG['solution_publish_owner_message'] = 'Dear VAR_USERNAME,

Reply for your board VAR_BOARD, posted in  VAR_SITENAME has Published.

Reply for your board
-----------------------------------
VAR_DESCRIPTION_OF_QUESTION

To learn more, please visit VAR_LINK
Regards,
VAR_SITENAME';
/**
 * @var string Discussion Title Publish Mail recieved
 * @cfg_label Discussion Title Publish mail received subject -- VAR_SITENAME
 * @cfg_key discussion_publish_subject
 */
$LANG['discussion_publish_subject'] = 'Your discussion title has Published - VAR_SITENAME';
/**
 * @var string Discussion Publish mail received
 * @cfg_label Discussion Publish mail received content -- VAR_USERNAME, VAR_DISCUSSION, VAR_DESCRIPTION_OF_DISCUSSION, VAR_LINK, VAR_SITENAME
 * @cfg_key discussion_publish_message
 */
$LANG['discussion_publish_message'] = 'Dear VAR_USERNAME,

Your discussion VAR_DISCUSSION posted in  VAR_SITENAME has Published.

Description of your discussion
--------------------------------
VAR_DESCRIPTION_OF_DISCUSSION

To learn more, please visit VAR_LINK
Regards,
VAR_SITENAME';
$LANG['users_board_details_msg'] = 'VAR_SITENAME member, SUBSCRIBED_USER, posted the following boards recently';
$LANG['users_solution_details_msg'] = 'VAR_SITENAME member, SUBSCRIBED_USER, posted the solutions to the following boards recently';
/**
 * @var string Subscribed users mail
 * @cfg_label Subscribed users mail subject -- VAR_SITENAME
 * @cfg_key subscribed_users_subject
 */
$LANG['subscribed_users_subject'] = 'Dear VAR_USERNAME - Recent updates';
/**
 * @var string Discussion Subscribed users mail
 * @cfg_label Discussion Subscribed users mail content -- VAR_USERNAME, VAR_DISCUSSION, VAR_DESCRIPTION_OF_DISCUSSION, VAR_LINK, VAR_SITENAME
 * @cfg_key subscribed_users_content
 */
$LANG['subscribed_users_content'] = 'Dear VAR_USERNAME,

VAR_BOARD_POSTED
VAR_SOLUTION_POSTED

Regards,
VAR_SITENAME';
?>