$(document).ready(
	function()
	{
		tableRuler('.tableList tbody tr', 'fire_form_over');
		$('#siteName').click(
			function()
			{
				window.open('http://www.phpletter.com/Our-Projects/Ajax-Form-Builder-Project/', '', 'location=1,status=1,scrollbars=1,toolbar=1')
			}
		);
	}
);

function changeStatsDateRange(elem)
{
	$('input.inputStatsType').each(
		function()
		{
			if(this.value == elem.value)
			{
				$('#' + this.value).show();
				this.checked = true;
			}else
			{
				$('#' + this.value).hide();
				this.checked = false;				
			}
		}
	);
};