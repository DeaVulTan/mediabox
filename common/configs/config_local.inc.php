<?php
//all the variables will be replaced by db data, if db is connected..
$CFG['admin']['is_demo_site'] = false;
$CFG['admin']['module']['media_server'] = true;
$CFG['admin']['module']['translate'] = true;
$CFG['admin']['module']['distributed_encoding'] = false;
$CFG['admin']['module']['discussions'] = true;
$CFG['site']['media_server_for'] = array('Photos');

$CFG['admin']['coppy_rights_year'] = '2010';
$CFG['site']['name'] = 'Rayzz';
$CFG['dev']['url'] = 'https://www.mediabox.uz';
$CFG['dev']['name'] = 'Uzdc';
$CFG['admin']['mailer']['mailer'] = 'smtp';
$CFG['admin']['mailer']['host'] = 'ssl://smtp.gmail.com';
$CFG['admin']['mailer']['port'] = '465';
$CFG['admin']['mailer']['smtp_encryption'] = false;
$CFG['admin']['mailer']['sendmail_path'] = '/usr/sbin/sendmail -bs';
$CFG['admin']['mailer']['username'] = 'rayzzdev.mail@gmail.com';
$CFG['admin']['mailer']['password'] = 'rayzzdevmailer#123';
$CFG['site']['dev_bug_email'] = 'rayzzdev@gmail.com';
$CFG['site']['add_default_banner'] = true;
$CFG['admin']['google_api']['key'] = 'ABQIAAAA3MjfvVGnf_MjrOe3zh8fSxT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQkcxAgTNno2NMYrJ6CYP4KhHeOvg';
$CFG['admin']['html_editor']['strip_tags'] = array('script', 'style', 'link');

$CFG['fieldsize']['profile']['info_description'] = '500';
$CFG['fieldsize']['contactus']['description'] = '500';
$CFG['fieldsize']['reportus']['description'] = '500';
$CFG['fieldsize']['friendadd']['description'] = '500';
$CFG['fieldsize']['invitation']['description'] = '500';

$CFG['image_small_width'] = '76';
$CFG['image_small_height'] = '76';
$CFG['image_small_name'] = 'S';

$CFG['image_thumb_width'] = '100';
$CFG['image_thumb_height'] = '100';
$CFG['image_thumb_name'] = 'T';

$CFG['image_large_width'] = '0';
$CFG['image_large_height'] = '0';
$CFG['image_large_name'] = 'L';

$CFG['image_medium_width'] = '130';
$CFG['image_medium_height'] = '130';
$CFG['image_medium_name'] = 'L';

$CFG['admin']['module']['email_template'] = true;
$CFG['auth']['session']['check_invalid_login_tries'] = false;
$CFG['auth']['session']['allowed_num_invalid_tries'] = 5;
$CFG['auth']['session']['retry_duration_after_invalid_tries'] = 1;//hour
$CFG['media']['folder']='files';


?>