<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// chua kt login
class vote extends Controller {
	var $mod = "vote";
	function vote()
	{		
		parent::Controller();
		// directory of the view, just to reduce number of typed text
		$this->view_dir = __CLASS__.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'container';
		// init feedback for user's actions
		$this->pre_message = "";
		$this->load->model( __CLASS__.'_model', 'mmod');
	}
	// default page
	function index()
	{	
		
	}
	
	function show()
	{
		if(!empty($_POST))
		{// 
			$view = $this->input->post('view');
			$check = $this->input->post('check');
			$voteid = $this->input->post('voteid');
			
			$view = $this->input->xss_clean($view);
			$check = $this->input->xss_clean($check);
			$voteid = $this->input->xss_clean($voteid);
			
			$ard=array("-","'",'"',"\n");
			$art=array('','','','');
			
			$view = str_replace($ard , $art, $view);
			$voteid = str_replace($ard , $art, $voteid);
			
			if($view==1)
			{// show
				$this->_show(array('voteid'=>$voteid));
			}
			else
			{// update and show
				$this->load->library('vote_online_lib');
				// kt cookie
				$id_vote = $this->vote_online_lib->get_id_vote();
				if($id_vote !== FALSE)
				{//
					$ar_vote = $id_vote==""? array() : explode('~', $id_vote);
					if(in_array($voteid, $ar_vote))
					{// da vote
						$this->_show(array('voteid'=>$voteid));
					}
					else
					{// update
						if(is_array($check))
						{
							foreach($check as $row)
							{
								$vl['id_vo'] = (int)$voteid;
								$vl['position_vc'] = (int)$row;
								$this->mmod->update_vote_content($vl);							
							}
						}
						else
						{
							$vl['id_vo'] = (int)$voteid;
							$vl['position_vc'] = (int)$check;
							$this->mmod->update_vote_content($vl);
						}
						// update cookie
						array_push($ar_vote,$voteid);
						$val['id_vote'] = implode('~', $ar_vote);
						$this->vote_online_lib->update($val);
						// show
						$this->_show(array('voteid'=>$voteid));
					}
				}
				else
				{// loi thao tac du lieu
					echo "Lỗi thao tác dữ liệu!";
				}
				
			}
			
		}
		else
			echo 'Không thấy dữ liệu!';
	}
	
	function _show($array= array())
	{
		$db = $this->mmod->select_vote((int)$array['voteid']);
		$data['db'] = $db;
		$this->load->vars($data);
		$this->load->view($this->view_dir."show");
	}
}