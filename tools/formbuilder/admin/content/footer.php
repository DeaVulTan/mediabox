
	</div>
	<?php
echo $content->getJs();	
	?>
	<?php
		echo $content->getContent('ajaxIndicator');
	?>
</body>
</html>

<?php
	$db->disconnect();
	$msg->displayPopupMsg();
?>