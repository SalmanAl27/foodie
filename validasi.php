<?php 
    function validateName($field_list, $field_name) {
		$pattern = "/^[a-zA-Z '-]+$/"; //format nama alfabet
		if (!preg_match($pattern, $field_list[$field_name])) {
			return false;
		}
        else {
            return true;
        }
	}
    

    function validateNameDanAngka($field_list, $field_name) {
		$pattern = "/^([a-zA-Z0-9 _-]+)$/"; //format nama alfabetnumerik
		if (!preg_match($pattern, $field_list[$field_name])) {
			return false;
		}
        else {
            return true;
        }
	}

	function is_email_valid($email) {
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)*([.com])+$/", trim($email))){
			return TRUE;
		}
		return FALSE;
	}



?>