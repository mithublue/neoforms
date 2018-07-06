<template id="neoforms_help">
	<div>
		<el-row :gutter="20">
			<el-col :sm="8" class="mb20">
				<el-card :body-style="{ padding: '0px' }">
					<div style="" class="text_center pt30 pb30 pr30 pl20">
						<div class="text_center font_36">
							<i class="el-icon el-icon-document"></i>
						</div>
						<h5 class="mb20 mt20"><?php _e( 'Need Good Understanding ?', 'neoforms' ); ?></h5>
						<div class="bottom clearfix">
							<div class="mb20">
								<?php _e( 'Our official detailed documentation will help you get a good ground on the thing you are looking for', 'neoforms'); ?>
							</div>
							<a href="http://docs.cybercraftit.com/docs/neoforms-user-documentation/" target="_blank" class="el-button"><?php _e( 'Go to Documentation', 'neoforms' ); ?></a>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :sm="8" class="mb20">
				<el-card :body-style="{ padding: '0px' }">
					<div style="" class="text_center pt30 pb30 pr30 pl20">
						<div class="text_center font_36">
							<i class="el-icon el-icon-info"></i>
						</div>
						<h5 class="mb20 mt20"><?php _e( 'Need Assistance ?', 'neoforms' ); ?></h5>
						<div class="bottom clearfix">
							<div class="mb20">
								<?php _e( 'Our official support is raedy to help you with any query or something.', 'neoforms'); ?>
							</div>
							<a href="http://supports.cybercraftit.com/" target="_blank" class="el-button"><?php _e( 'Go to Support', 'neoforms' ); ?></a>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :sm="8" class="mb20">
				<el-card :body-style="{ padding: '0px' }">
					<div style="" class="text_center pt30 pb30 pr30 pl20">
						<div class="text_center font_36">
							<i class="el-icon el-icon-warning"></i>
						</div>
						<h5 class="mb20 mt20"><?php _e( 'Found any Issue ?', 'neoforms' ); ?></h5>
						<div class="bottom clearfix">
							<div class="mb20">
								<?php _e( 'Report us if any bug or issue is found to help us make this product better.', 'neoforms'); ?>
							</div>
							<a href="https://github.com/mithublue/neoforms/issues" target="_blank" class="el-button"><?php _e( 'Report to Github', 'neoforms' ); ?></a>
						</div>
					</div>
				</el-card>
			</el-col>
		</el-row>
		<el-row :gutter="20">
			<el-col :sm="8" class="mb20">
				<el-card :body-style="{ padding: '0px' }">
					<div style="" class="text_center pt30 pb30 pr30 pl20">
						<div class="text_center font_36">
							<i class="el-icon el-icon-setting"></i>
						</div>
						<h5 class="mb20 mt20"><?php _e( 'Need customization ?', 'neoforms' ); ?></h5>
						<div class="bottom clearfix">
							<div class="mb20">
								<?php _e( 'We welcome new ideas and customizations and integration are welcome. You are welcome to contact with us for these', 'neoforms'); ?>
							</div>
							<a href="https://cybercraftit.com/contact/" target="_blank" class="el-button"><?php _e( 'Contact Us', 'neoforms' ); ?></a>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :sm="8" class="mb20">
				<el-card :body-style="{ padding: '0px' }">
					<div style="" class="text_center pt30 pb30 pr30 pl20">
						<div class="text_center font_36">
							<i class="el-icon el-icon-success"></i>
						</div>
						<h5 class="mb20 mt20"><?php _e( 'Like Our Plugin ?', 'neoforms' ); ?></h5>
						<div class="bottom clearfix">
							<div class="mb20">
								<?php _e( 'Your valuable feedback and review encourage us to make more awesomeness. :) ', 'neoforms'); ?>
							</div>
							<a href="https://wordpress.org/support/plugin/neoforms/reviews/?rate=5#new-post" target="_blank" class="el-button"><?php _e( 'Rate neoForms', 'neoforms' ); ?></a>
						</div>
					</div>
				</el-card>
			</el-col>
		</el-row>
	</div>
</template>
<script>
	var neoforms_help = {
	    template: '#neoforms_help'
	}
</script>