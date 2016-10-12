<div id="main_part">
	<div class="boxbotron">
		<div class="boxbotron_inner clearfix">
			<div class="boxbotron_head_left">Phục hồi mật khẩu<span class="boxbotron_head_right"></span></div>
			<div class="boxbotron_corner boxbotron_bl"> </div>
			<div class="boxbotron_corner boxbotron_br"> </div>
			<div class="boxbotron_border clearfix">
				<div class="boxbotron_content clearfix">
					<?php
echo $message;
echo form_open($this->mod.'/forgotten_password'); ?>
					<div class="clear"></div>
					<div style="margin-top:10px; margin-left:50px;">
						<label for="login">Email của bạn &nbsp;
						<input name="email" id="login" size="40" tabindex="1" type="text" />
						</label>
						<input value="Tiến hành" name="submitAuth" tabindex="3" type="submit" />
					</div>
					<?php echo form_close(''); ?>
					<div class="sepdiv"></div>
					(!) Trong vài phút tới, hệ thống sẽ gởi một email đến địa chỉ email của bạn.<br />
					Bạn cần đăng nhập vào hộp thư và làm các bước theo hướng dẫn để được cấp mật khẩu mới.</div>
			</div>
		</div>
	</div>
	<div class="boxbotron">
		<div class="boxbotron_inner clearfix">
			<div class="boxbotron_head_left">Phục hồi mật khẩu<span class="boxbotron_head_right"></span></div>
			<div class="boxbotron_corner boxbotron_bl"> </div>
			<div class="boxbotron_corner boxbotron_br"> </div>
			<div class="boxbotron_border clearfix">
				<div class="boxbotron_content clearfix">
					<?php
echo form_open($this->mod.'/forgotten_password_complete'); ?>
					<div class="clear"></div>
					<div style="margin-top:10px; margin-left:50px;">
						<label for="code">Mã xác nhận &nbsp;
						<input name="code" id="code" size="40" tabindex="1" type="text" />
						</label>
						<input value="Tiến hành" name="submitAuth" tabindex="3" type="submit" />
					</div>
					<?php echo form_close(''); ?>
					<div class="sepdiv"></div>
					(!) Trong vài phút tới, hệ thống sẽ gởi một email đến địa chỉ email của bạn.<br />
					Bạn cần đăng nhập vào hộp thư và làm các bước theo hướng dẫn để được cấp mật khẩu mới.</div>
			</div>
		</div>
	</div>
</div>