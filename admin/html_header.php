<?php
$HeaderHandler = new HeaderHandler();
$smartyObj->assign_by_ref('header', $HeaderHandler);

//assign for populate the language list in header
$HeaderHandler->populateLanguageDetails();
//To hide template switcher for admin section
//$HeaderHandler->CFG['html']['template']['is_template_support'] = false;

$HeaderHandler->populateTemplateDetails();

$smartyObj->assign('isMember', isMember());
$smartyObj->assign('isAdmin', isAdmin());

//display the header tpl file
setTemplateFolder('admin/');
$smartyObj->display('html_header.tpl');
?>
<script language="javascript" type="text/javascript">
	//** Admin side show hide**//
    function adminMenuNavigation(divID) {
		for(i=0;i<divArray.length;i++) {
			if(!document.getElementById(divArray[i])) {
				continue;
			}

			if(divID != divArray[i]) {
				var str = divArray[i]+'_head';
				document.getElementById(divArray[i]).style.display = 'none';
				document.getElementById(str).className='clsInActiveSideHeading';
			} else {
				var str = divArray[i]+'_head';
				document.getElementById(divArray[i]).style.display = 'block';
				document.getElementById(str).className='clsActiveSideHeading';
			}
		}
	};
	function adminMenuLeftNavigationPage(divID) {
		for(i=0;i<divArray.length;i++) {
			if(!document.getElementById(divArray[i])) {
				continue;
			}

			if(divID == divArray[i]) {
				var str = divArray[i]+'_head';
				if(document.getElementById(divArray[i]).style.display == 'none') {
					document.getElementById(divArray[i]).style.display = 'block';
					document.getElementById(str).className='clsActiveSideHeading';
				} else {
					document.getElementById(divArray[i]).style.display = 'none';
					document.getElementById(str).className='clsInActiveSideHeading';
				}
			}
		}
	};
</script>
