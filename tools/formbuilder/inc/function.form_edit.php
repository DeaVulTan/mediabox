<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */

		/**
		 * get the question container template html for form
		 *
		 * @param integer $qID the question id in question table
		 * @param integer $qNum the question number in the survey
		 * @param string $qBody the html
		 * @return string
		 */
		function  getQuestionUpdateTplHTML($qID, $question, $questionBody, $instructions)
		{
			$html = '<tr class="fireFormRow" id="fireFormRow' . $qID . '">';
			$html .= '<td  valign="top" class="fireFormQuestion"><label>' . $question . '</label></td>';
			$html .= '<td  valign="top" class="fireFormQBody">' . $questionBody . '</td>';
			$html .= '<td  valign="top" class="fireFormInstruction">' . $instructions . '</td>';
			$html .= '<td style="width:40px"  valign="top" class="fire_form_actions" nowrap><a href="#fireFormRow' . $qID . '" style="display:none" onclick="javascript:fireFormRemoveQ(' . $qID . ');" class="fireFormRowDelete">&nbsp;</a><a href="#fireFormRow' . $qID . '" style="display:none" onclick="javascript:fireFormEditQ(' . $qID . ');" class="fireFormRowEdit">&nbsp;</a></td>';

			$html .= '</tr>';
			return $html;


		}




		function getQuestionTplHTML($qID, $question, $questionBody, $instructions)
		{
			$html = '<tr class="fireFormRow" id="fireFormRow' . $qID . '">';
			$html .= '<th  valign="top" class="fireFormQuestion"><label>' . $question . '</label></th>';
			$html .= '<td  valign="top" class="fireFormQBody">' . $questionBody . '</td>';
			$html .= '<td  valign="top" class="fireFormInstruction">' . $instructions . '</td>';
			$html .= '</tr>';
			return $html;

		}




		/**
		 * get the html for the type of text input for question setting in the control panel
		 *
		 * @param string $name
		 * @return string
		 */
		function getQSettingText($name)
		{
			$html = '';
			$html .= '<input type="text" class="fireFormInput fireFormPanel_' . $name . '" name="' . $name . '" value=""> ';
			return $html;
		}


		/**
		 * get the html for the type of text input for question setting in the control panel
		 *
		 * @param string $name
		 * @return string
		 */
		function getQSettingTextarea($name, $rows=2)
		{
			$html = '';
			$html .= '<textarea class="fireFormTextarea fireFormPanel_' . $name . '" name="' . $name . '" rows="' . $rows . '"></textarea>';
			return $html;
		}
		/**
		 * get the html for the type of text input for question setting in the control panel
		 *
		 * @param string $name
		 * @return string
		 */
		function getQSettingRadio($name, $options, $itemDelimiter = '&nbsp;')
		{
			$html = '';
			foreach ($options as $k=>$v)
			{
				$html .= '<input type="radio" class="fireFormRadio fireFormPanel_' . $name . '" name="' . $name . '" value="' . $k . '"> ' . $v . $itemDelimiter;
			}
			return $html;
		}

		/**
		 * get the html for the type of text input for question setting in the control panel
		 *
		 * @param string $name
		 * @return string
		 */
		function getQSettingYesOrNo($name)
		{
			return getQSettingRadio($name, array(1=>CMM_YES, 0=>CMM_NO));
		}


		/**
		 * get the html for the type of text input for question setting in the control panel
		 *
		 * @param string $name
		 * @return string
		 */
		function getQSettingSelect($name, $options)
		{
			$html = '';
			$html .= '<select name="' . $name . '" class="fireFormSelect fireFormPanel_' . $name . '">';
			$html .= '<option value="">' . CMM_PLEASE_SELECT . '</option>';
			foreach ($options as $k=>$v)
			{
				$html .= '<option value="' . $k . '">' . $v . '</option>';
			}
			$html .= '</select>';
			return $html;
		}

		function getQSetting($qName, $qType, $body)
		{
			global $CFG, $LANG;
			$html =   '<!--fireFormSettingFor' . $qType . ' started	-->
			<div style="display:none" id="fireFormSettingFor' . $qType . '"><form action="" method="POST" id="fireFormFireForm' . $qType . '">
				<input type="hidden" name="form_id" value="">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="post_action" value="save_question">
				<input type="hidden" name="question_type" value="' . $qType . '">
				<table class="firmFromPanelTable" cellpadding="0" cellspacing="0">
					<thead><tr><th colspan="4">' . $qName . '</th></tr></thead>
					<tbody>
			' . $body . '
					</tbody>
					<tfoot>
					<tr>
						<th>&nbsp;</th>
						<td colspan="3">';
				if($CFG['admin']['is_demo_site'])
					{
						$html .=	'<input type="button" class="fireFormPanelButton" value="' . CMM_BTN_SAVE . '" onclick="alert_manual(\''.$LANG['general_config_not_allow_demo_site'].'\');">';
					}
				else
					{
						$html .=	'<input type="button" class="fireFormPanelButton" value="' . CMM_BTN_SAVE . '" onclick="javascript:return fireFormPanelSaveQ(\'' . $qType . '\');">';
					}
					$html .=	'</td>
					</tr>
					</tfoot>
					</table>
					</form></div>

			<!--fireFormSettingFor' . $qType . ' ended	-->	';
			return $html;
		}



		/**
		 * get Question add html
		 * @param $btnLabel the button label
		 * @param $qType the question type
		 * @return string
		 *
		 */
		function getQAddHTML($btnLabel, $qType)
		{
			return '<li><input type="button" class="buttonQAdd" value="' . $btnLabel . '" onclick="javascript:fireFormQAdd(\'' . $qType . '\');"></li>';
 		}


		function removeNewLineFromTextarea($str)
		{
			return str_replace("\r", '', $str);
		}