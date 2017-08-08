<div id="pluginConfig">
	<h2>{$LANG.pluginconfig}</h2>
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('plugin_list_block')}
    	<form id="pluginConfig" name="pluginConfig" method="post" action="{$myobj->getCurrentUrl(true)}">
        	<table cellpadding="2" cellspacing="4" class="clsNoBorder">
            	{if $myobj->err_msg != ''}
            		<tr>
            			<td colspan="3"><h3>{$myobj->err_msg}</h3></td>
					</tr>
				{/if}
            	{if $myobj->plugin_list_block.displayPluginList_arr }
            		<tr>
                		<th>{$LANG.pluginconfig_title}</th>
                		<th>{$LANG.pluginconfig_version}</th>
                		<th>{$LANG.pluginconfig_description}</th>
                		<th>{$LANG.pluginconfig_status}</th>
            		</tr>
                    {foreach key=inc item=dplValue from=$myobj->plugin_list_block.displayPluginList_arr}
                    	<tr>
                      		<td class="clsSmallWidth">{$dplValue.title}</td>
                      		<td class="clsSmallWidth"><p>{$dplValue.version}</p></td>
                            <td><p>{$dplValue.description}</p></td>
                            <td class="clsSmallWidth">
                            	{if !$myobj->chkAlreadyExists($dplValue.title, $myobj->getFormField('action'))}
                                	<a href="{$CFG.site.url}{$dplValue.link}"  >
                                    	<b><font color="#006600">{$LANG.pluginconfig_install}</font></b>
                                    </a>
                                {else}
                                	<b><font color="#FF0000">{$LANG.pluginconfig_installed}</font></b>
									(<a href="{$CFG.site.url}{$dplValue.link}">
                                		<b><font color="#006600">{$LANG.pluginconfig_reinstalled}</font></b>
                                    </a>)
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                {else}
                	<tr>
                    	<td colspan="3" align="center" valign="middle"><div id="selMsgAlert">{$LANG.pluginconfig_no_record}</div></td>
                    </tr>
                {/if}
			</table>
		 	<input type="hidden" id="module_name" name="module_name"/>
			<input type="hidden" id="plugin_name" name="plugin_name"/>
      	</form>
	{/if}
</div>