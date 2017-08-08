<?php
require_once('../common/configs/config.inc.php');
?>
<form id="form1" name="form1" method="post" action="http://www.facebook.com/logout.php">
  <input name="confirm" type="text" id="confirm" value="1" />
</form>

<script type="text/javascript" language="javascript" defer="defer">
    parent.top.document.location.href  = cfg_site_url+'logout.php';
	document.form1.submit();
</script>