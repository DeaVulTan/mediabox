<form id="form">
    <table width="97%" align="center" class="clsPabeBreak">
        <tr width="40%">
            <td class="key" class="{$myobj->getCSSFormLabelCellClass('title')}">
                <label for="title">{$LANG.pagebreak_title}</label>
            </td>
            <td>
                <input type="text" id="title" name="title" class="clsTextBox"/>
            </td>
        </tr>
        <tr width="60%">
            <td class="key" class="{$myobj->getCSSFormLabelCellClass('alias')}">
                <label for="alias" >{$LANG.pagebreak_alias}</label>
            </td>
            <td>
                <input type="text" id="alt" name="alt" class="clsTextBox"/>
            </td>
       </tr>
       <tr>
            <td>
            </td>
            <td>
				<button onclick="insertPagebreak();" class="clsSubmitButton">{$LANG.pagebreak_pagebreak}</button>
            </td>
        </tr>
    </table>
</form>