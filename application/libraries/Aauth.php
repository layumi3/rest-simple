<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aauth {

    var $CI;

    /**
     * Constructor
     */
    function __construct() {
        // Obtain a reference to the ci super object
        $this->CI = & get_instance();
        $this->CI->load->library('session');
    }

    function _set_session($attribute){
    	$this->CI->session->set_userdata(SESSION_KEY_NAME, $attribute);
    }

    function _get_session(){
    	return $this->CI->session->userdata(SESSION_KEY_NAME);
    }

    function _get_session_value($key){
    	$user = $this->_get_session();
    	return $user[$key] ? : FALSE;
    }

    function check_password($password_hash, $password) {
    	return $password_hash === $password;
    }

    /**
     * Hash password
     *
     * @access public
     * @param object $account
     * @param string $password
     * @return bool
     */
    function hash_password($password) {
    	$this->CI->load->library('encrypt');
    	return $this->CI->encrypt->sha1($password);
    }

    function generate_password($username){
    	$str = rand(1, 9999);
    	return $username.str_pad($str, 4,"0",STR_PAD_LEFT);
    }

    function generate_password_with_hash($username){
    	return $this->hash_password($this->generate_password($username));
    }

    function generate_token(){
    	$this->CI->load->helper('string');
    	return random_string('unique');
    }

    function sign_in($user) {

    	$attribute['user_id'] = (int)$user->user_id;
    	$attribute['username'] = $user->username;

    	$token = $user->token;
    	if(!$token){
    		$token = $this->generate_token();
    	}

    	$attribute['token'] = $token;

    	if(isset($user->full_name)){
    		$attribute['name'] = $user->full_name;
    	}

    	$this->_set_session($attribute);

    	$this->CI->load->model('m_sys_user');
    	$this->CI->m_sys_user->update_last_login($user->user_id);
    }

    function is_token_valid($token){
       $user = $this->get_user_by_token($token);
        if($user){
            return TRUE;
        }
        return FALSE;
    }

    function get_user_by_token($token){
        if(!empty($token)){
            
            $this->CI->load->model('m_sys_user');
            return $this->CI->m_sys_user->get_by_token($token);
        }
        return NULL;
    }

    function sign_out() {
    	$this->CI->session->unset_userdata(SESSION_KEY_NAME);
    }

    function get_user_id() {
    	return $this->_get_session_value('user_id');
    }

    function get_name() {
    	return $this->_get_session_value('name');
    }

    function get_username() {
    	return $this->_get_session_value('username');
    }

    function get_active_token() {
    	return $this->_get_session_value('token');
    }


    //TODO perlu direfactoring.
    //permissions perlu disimpan di database
    //referensi dari sini https://github.com/emreakay/CodeIgniter-Aauth
    /**
     *
     * @param object $user
     * @param string $perm
     */
    function is_user_allowed($user, $permission){

    	if($permission == PERMISSION_LOGIN){
    		if($user->is_surveyor == TRUE
    				&& $user->is_supervisor == FALSE
    				&& $user->is_manager == FALSE
    				&& $user->is_general_manager == FALSE
    				&& $user->is_admin == FALSE){
    			return FALSE;
    		}
    	}else if($permission == PERMISSION_ADD_SURVEYOR
    			|| $permission == PERMISSION_EDIT_SURVEYOR
    			|| $permission == PERMISSION_DELETE_SURVEYOR
    			|| $permission == PERMISSION_DETAIL_SURVEYOR){
    		return $user->is_admin;
    	}

    	return TRUE;
    }

    function token_validation(&$ctrl){
        $ctrl->token = NULL;
        if ($ctrl->get()) {
            $ctrl->token = $ctrl->get(REQUEST_PARAM_TOKEN);
        } else if ($ctrl->post()) {
            $ctrl->token = $ctrl->post(REQUEST_PARAM_TOKEN);
        } else if ($ctrl->put()) {
            $ctrl->token = $ctrl->put(REQUEST_PARAM_TOKEN);
        } else if ($ctrl->delete()) {
            $ctrl->token = $ctrl->delete(REQUEST_PARAM_TOKEN);
        }

        if(empty($ctrl->token) || !$this->is_token_valid($ctrl->token)){
            $ctrl->result->status = RESPONSE_STATUS_ERROR;
            $ctrl->result->add_error(ERROR_CODE_INVALID_TOKEN, msg('msg_invalid_token'));
            $ctrl->response($ctrl->result, 200);
        }
    }
}
