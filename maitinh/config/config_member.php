<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Tables.
	 **/
	$config['tables']['groups'] = 'usertype';
	$config['tables']['users'] = 'user';
	$config['tables']['meta'] = '';
	$config['tables']['options'] = 'user_option';

	/**
	 * Groups table - It's need? boolean.
	 **/
	$config['groups'] = true;
	/**
	 * Default group, use name
	 */
	$config['default_group'] = '';
	
	/**
	 * Groups table column you want to join WITH.
	 * Joins from users.group_id
	 **/
	$config['join_group'] = 'type_id';	 
	
	/**
	 * Columns in your groups table,
	 * id not required.
	 **/
	$config['columns_groups'] = array('name', 'description', 'access_level');

	/**
	 * Meta table - It's need? boolean.
	 **/
	$config['meta'] = false;

	/**
	 * Meta table column you want to join WITH.
	 * Joins from users.id
	 **/
	$config['join'] = 'user_id';
	
	/**
	 * Columns in your meta table,
	 * id not required.
	 **/
	$config['columns'] = array();

	/**
	 * Option table - It's need? boolean.
	 **/
	$config['option'] = true;

	/**
	 * Meta table column you want to join WITH.
	 * Joins from users.id
	 **/
	$config['join_option'] = 'user_id';
	
	/**
	 * Columns in your Option table,
	 * id not required.
	 **/
	$config['columns_option'] = array('content');// check again when insert db;

	/**
	 * The base columns of user table
	 **/
	$config['user_id'] = 'id';
	$config['password'] = 'password';
	$config['username'] = 'username';
	$config['email'] = 'email';
	$config['activation_code'] = 'activated';
	$config['forgotten_password_code'] = 'forgotten_password_code';
	$config['register_time'] = 'times';
	$config['ip_address'] = '';// sometime
	
	/**
	 * Columns in your groups table,
	 * id not required.
	 **/
	$config['columns_users'] = array('type_id', 'code', 'fullname', 'description', 'time_start', 'time_finish', 'dir_admin', 'teamleader');
	
	/**
	 * A database column which is used to
	 * login with.
	 **/
	$config['identity'] = $config['username'];

	/**
	 * Email Activation for registration
	 **/
	$config['email_activation'] = false;
	
	/**
	 * Folder where email templates are stored.
     * Default : redux_auth/
	 **/
	$config['email_templates'] = 'templates_email/';

	/**
	 * Salt Length
	 **/
	$config['salt_length'] = 10;
	
	/**
	 * save address IP boolean
	 **/
	$config['save_address_IP'] = false;
	
	/**
	 * Use for manage login time
	 * boolean
	 **/
	$config['login_time'] = TRUE;
	
	/**
	 * template directory
	 **/
	$config['view_dir'] = 'member/'; // system/application/views/member/
	
	/*-------------------------------+
	|  PAGINATION                    |
	+--------------------------------*/
	$config['item_perpage'] = 20;
	$config['num_links'] = 5;
	
	/**
	 * contact Email
	 **/
	$config['contact_email'] = 'info@23vn.com';
	
	// left menu
	$mod = 'member';
	$config['menu_title'] = "Quản trị /";
	
	$config['menu'][] = array('name'=>'Danh sách', 'link'=>$mod.'/lists', 'icon'=>'list.gif');
	$config['menu'][] = array('name'=>'Thêm mới', 'link'=>$mod.'/create', 'icon'=>'customer_add.gif');
	$config['menu'][] = array('name'=>'Loại thành viên', 'link'=>'usertype', 'icon'=>'customer_edit.gif');
	$config['menu'][] = array('name'=>'Quản lý Module', 'link'=>'class_permit', 'icon'=>'set.gif');
	$config['menu'][] = array('name'=>'Cấu hình', 'link'=>'cfsite', 'icon'=>'set.gif');
	$config['menu'][] = array('name'=>'Đổi mật khẩu', 'link'=>$mod.'/change_password', 'icon'=>'pass_change.gif');