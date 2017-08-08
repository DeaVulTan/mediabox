<div class="clsDataDisplaySection">
      <div class="clsDataHeadSection">	
            <div>	
                  {$LANG.manage_banner_template}:
                  <select name="template_name" id="template_name" onchange="tempalteNav()">
                        {foreach from=$CFG.html.template.allowed item=allowed_templates}
                              <option value="{$allowed_templates}"{if $allowed_templates==$myobj->getFormField('template_name')} selected="selected"{/if}>{$allowed_templates}</option>
                        {/foreach}
                  </select>            
            </div>
          <table class="clsFormSection clsNoBorder">
          <tr>
            <th class="clsSelectColumn">{$LANG.manage_banner_details_sno}</th>
            <th>{$LANG.manage_banner_details_banner_name}</th>
            <th>{$LANG.manage_banner_details_banner_size}</th>
          </tr>
          {assign var=sno value=1}
          {foreach key=item item=value from=$banner_details_arr}
          <tr>
            <td class="clsSelectColumn" align="center">{$sno++}</td>
            <td>{$item}</td>
            <td align="center">{$value}</td>
          </tr>
          {/foreach}
        </table>
   </div>
</div>
{literal}
  <script type="text/javascript">
	function tempalteNav()
		{
			bannerUrl = {/literal}'{$CFG.site.url}admin/bannerDetails.php';{literal}
			bannerUrl = bannerUrl+'?template_name='+document.getElementById('template_name').value;
			window.location = bannerUrl;
		}
  </script>        
{/literal}
