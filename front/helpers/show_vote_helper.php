<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if (! function_exists('show_vote'))
{
	function show_vote()
	{
		$obj =& get_instance();
		$sql = "SELECT q.id_vo, q.title_vo, q.image_vo, q.comment_vo, q.times_vo, q.types_vo, q.show_vo FROM vote q WHERE q.show_vo='1'";
		$db = $obj->db->query($sql);
		if($db->num_rows()>0)
		{
			echo '<div style="width:260px; height:245px; padding:10px; overflow:auto"><form method="post" name="vote" target="vote">';
			
			$n = $db->num_rows();
			$rand = rand(0,$n);//random
			
				
			$ard=array("'",'"',"\n");
			$art=array("\'",'\"',"");
			//
			$row = $db->row($rand);
			$id = $row->id_vo;		
			$title = str_replace($ard, $art, $row->title_vo);
			$types = $row->types_vo;
			$comment = $row->comment_vo;
			$image = $row->image_vo;
			$show_vo = $row->show_vo;
			$images = ($image && file_exists("../".$image))?'<img src="'.base_url()."../".$image.'" width=100 />':'';
			//
			echo "<div style='font-size:14px;color:#0D80C1;font-weight:bold'>$title</div>";
			echo $images.$comment;
			//
	
			$sql = "SELECT * FROM vote_content WHERE id_vo=$id ORDER BY position_vc, id_vc";
			$query = $obj->db->query($sql);
			if($query->num_rows()>0)
				$db_ans = $query;
		
			if(!empty($db_ans))
			{
				foreach($db_ans->result() as $rw)
				{
					$aid = $rw->id_vc;
					$qid = $rw->id_vo;
					$position = $rw->position_vc;
					$content = $rw->content_vc;
					$image_ans = $rw->image_vc;
					$str_img = (!empty($image_ans) && file_exists('../'.$image_ans))?'<img src="'.base_url().'../'.$image_ans.'" width="100" style="padding-left:10px; vertical-align:text-top;" /><br />':'';	
					switch($types){
						case 'O': 
							$data = array(
														'name'        => 'check',
														'id'          => 'check'.$qid.'_'.$position,
														'value'       => $position,
														'style'       => 'margin-top:10px; margin-right:10px;',
														);
							echo '<p><label>'.form_radio($data).$str_img.$content.'</label></p>';
						break;
						case 'M': 
							$data = array(
														'name'        => 'check[]',
														'id'          => 'check'.$qid.'_'.$position,
														'value'       => $position,
														'style'       => 'margin-top:10px; margin-right:10px;',
														);
							echo '<p><label>'.form_checkbox($data).$str_img.$content.'</label></p>';
						break;
						default: 
							$data = array(
														'name'        => 'check',
														'id'          => 'check'.$qid.'_'.$position,
														'value'       => $position,
														'style'       => 'margin:10px',
														);
							echo '<p><label>'.form_radio($data).$str_img.$content.'</label></p>';
					}
					
				}
				echo '<p style="margin-top:10px"><center><input type="hidden" name="voteid" value="'.$id.'" /><input type="hidden" name="view" value="0" /><input type="submit" name="btnsubmit" value="Biểu quyết" onclick="return SubmitVote(this.form,0)" /> <input type="submit" name="btnview" value="Xem kết quả" onclick="return SubmitVote(this.form,1)" /></center></p>';
			}
			
			echo form_close();
			
		}
		?>
		<script type="text/javascript">
		function SubmitVote(frm, act)
		{
			/*if (act==0)
			{
				n = $("input:checked").length;
				if (n==0)
				{
					alert('Hay chon mot trong cac muc truoc khi bieu quyet.');
					return false;
				}
			}*/
		
			var form = frm;
			var n = 0;
			var j = 0
			for (i=0; i < form.elements.length - 2; i++)
				{
					if(form.elements[i].checked){
						n = n + 1
					}
					if(form.elements[i].type=='checkbox'){
						j = j + 1
					}
				}
				
			if (act==0)
			{
				//n = $("input:checked").length;
				if (n==0)
				{
					alert('Hay chon mot trong cac muc truoc khi bieu quyet.');
					return false;
				}
			}
			
			var sheight = (j * 40) + 50;
			if (sheight < 250){
				sheight = 250;
			}
			open('', frm.name, 'scrollbars=yes,resizeable=no,locationbar=no,width=500,height='+sheight+',left='.concat((screen.width - 500)/2).concat(',top=').concat((screen.height - 250)/2));
			frm.view.value = act;
			frm.action = '<?=site_url('vote/show')?>' ;
			frm.submit();
		}
		</script>
		</div>
<?php	
	}
}
?>
