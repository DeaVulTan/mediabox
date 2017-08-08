<?php
/**
 * ProfileHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ProfileHandler extends SignupAndLoginHandler
	{
		/**
    	 * EditProfileFormHandler::getUserDetailsArrFromDB()
		 * To get the user details from the DB
		 *
		 * @param 		string $table_name table name
		 * @param 		array $fields_arr Array of fields
		 * @param 		integer $user_id user id
		 * @return 		array has array with field values
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
					}
				$ret_fields_arr = array();
				$fields_arr = array_merge($fields_arr, $alias_fields_arr);
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				//$rs->Free();
				return $ret_fields_arr;
			}

		 /**
    	 * EditProfileFormHandler::updateFormFieldsInUsersTable()
		  * To update the form values into users table
		  *
		  * @param 		string $table_name Table name
		  * @param 		integer $user_id User id
		  * @param 		array $fields_to_update_arr Array of fields to update
		  * @return 	void
		  * @access 	public
		  */
		public function updateFormFieldsInUsersTable($table_name, $user_id, $fields_to_update_arr=array())
			{
				$sql = 'UPDATE '.$table_name.' SET ';
				foreach($fields_to_update_arr as $field_name)
					if (isset($this->fields_arr[$field_name]))
						{
							$sql .= $field_name.'='.$this->dbObj->Param($this->fields_arr[$field_name]).', ';
							$paramFields[] = $this->fields_arr[$field_name];
						}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE user_id ='.$this->dbObj->Param($user_id);
				$paramFields[] = $user_id;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$updated = 	($this->dbObj->Affected_Rows()>0);
				return $updated;
			}

		/**
    	 * EditProfileFormHandler::chkIsNotEditDuplicateEmail()
		 * To check for the duplicate email id
		 *
		 * @param 		string $table_name table name
		 * @param 		string $field_name email field name
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNotEditDuplicateEmail($table_name, $field_name, $user_id=0 , $err_tip='')
			{
				$sql = 'SELECT 1 FROM ' . $table_name .
				 	   ' WHERE user_id <>'.$this->dbObj->Param($user_id).' AND email = '.$this->dbObj->Param($this->fields_arr[$field_name]).' AND usr_status!=\'Deleted\' LIMIT 0,1';

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr[$field_name]));
                    if (!$rs)
                	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()<=0)
				    {
				        return true;
				    }
				else
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
			}

		/**
    	* EditProfileFormHandler::showOptionButtons()
		* Populates the option List
		*
		* @param array $sex_array Sex Array
		* @param string $field_name name of the radio button
		* @access public
		*
		**/
		public function showOptionButtons($list_array, $field_name)
			{
				if (empty($list_array))
				    {
				        return;
				    }
				?>
<ul>
					<?php
					foreach($list_array as $key=>$desc)
						{
						$checked = (strcmp($key, $this->fields_arr[$field_name])==0)?"Checked":"";
				?>
<li><input type="radio" class="clsCheckRadio" name="<?php echo $field_name;?>" <?php echo $checked;?> value="<?php echo $key;?>"  tabindex="<?php echo $this->getTabIndex();?>" />&nbsp;&nbsp;<?php echo $desc;?></li>
				<?php
						}
					?>
</ul>
				<?php
			}

		/**
		 * EditProfileFormHandler::populateDateYearValue()
		 * used to populate date,& year
		 *
		 * @param integer $start_no
		 * @param integer $end_no
		 * @param string $highlight_value
		 *
		 * @return void
		 * @access public
		 **/
		public function populateDateYearValue($start_no, $end_no, $highlight_value='')
			{
			   	       $showOption_arr = array();
				       $inc = 0;
						for($start_no;$start_no<=$end_no;$start_no++)
							{
							   	$showOption_arr[$inc]['values']=$start_no;
								$selected = trim($highlight_value) == trim($start_no)?' selected':'';
							    $showOption_arr[$inc]['selected']=$selected;
						 	   	$showOption_arr[$inc]['optionvalue']=$start_no;
						 	    $inc++;
						  }
						return $showOption_arr;
			}



		/**
		 * EditProfileFormHandler::chkIsSamePasswords()
		 * To check the confirmation of password and password are same
		 *
		 * @param 		string $field_name1 password Field name
		 * @param 		string $field_name2 confirmation password field name
		 * @param 		string $err_tip error tip message
		 * @return 		boolean $is_ok true/false
		 * @access 		public
		 */
		public function chkIsSamePasswords($field_name1, $field_name2, $err_tip='')
			{
				$is_ok = ($this->fields_arr[$field_name1]==$this->fields_arr[$field_name2]);
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name1] = $this->fields_err_tip_arr[$field_name2] = $err_tip;
				return $is_ok;
			}



		/**
		 * EditProfileFormHandler::populateListArray()
		 * To list the options in drop down
		 *
		 * @param array $array
		 * @param string $selected
		 * @param array $start_arrayr
		 * @param array $end_array
		 * @param $err_tip error ti
		 * @access public
		 **/
		public function populateListArray($array, $selected='', $start_array=array(), $end_array=array())
			{
			$array = $start_array + $array + $end_array;

			   	$showOption_arr = array();
				$inc = 0;

				if(is_array($array) and !empty($array))
					{
					foreach($array as $val=>$txt)
						{
						 $showOption_arr[$inc]['values']=$val;
						 $selected_val=($selected==$val or $selected==$txt)? ' selected="selected"' : '';
						 $showOption_arr[$inc]['selected']=$selected_val;
						 $showOption_arr[$inc]['optionvalue']=$txt;
						 $inc++;
						}
					}
				 return $showOption_arr;
			}
	}
?>
