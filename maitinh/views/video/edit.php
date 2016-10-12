<?=form_open_multipart($this->mod.'/edit');?>
<input type="hidden" name="id" value="<?=$id;?>" />
<table  width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
			<tr>
				<td colspan="2" align="center" class="maintitle"><strong>HIỆU CHỈNH VIDEO</strong></td>
			</tr>
			<tr>
				<td align="right" class="tdrow1" valign="top"><strong>Tiêu đề  </strong> <font color="#FF0000">*</font></td>
				<td class="tdrow1"><textarea cols="69" rows="2" name="title"><?=$title;?></textarea>
					</td>
			</tr>
			<tr>
				<td align="right" class="tdrow1" valign="top"><strong>Hình ảnh </strong> <font color="#FF0000">*</font></td>
				<td class="tdrow1"><input type="file" size="40" name="userfile" /><br />
					<?php
						if($image && file_exists("../".$image)){
							echo showIMG("../".$image, 300, 200);
						}?>
				</td>
			</tr>
			<tr>
				<td align="right" class="tdrow1" valign="top"><strong>Mô tả thêm</strong></td>
				<td class="tdrow1"><textarea cols="69" rows="2" name="comment"><?=$comment;?></textarea>
					</td>
			</tr>
			<tr>
				<td align="right" class="tdrow1"><strong>Trạng thái</strong> <font color="#FF0000">*</font></td>
				<td class="tdrow1"><?=form_dropdown('shown', $this->config->item('shown'),$shown);?>
					</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="tdrow1">
				<input type="submit" name="btn_submit" value="Hiệu chỉnh" id="button" /></td>
			</tr>
</table>
<?=form_close();?>