<template id="neoforms-form-types">
    <div>
        <div class="mb20">
            <?php
            if( !NeoForms_Functions::is_pro() ) {
                ?>
                <el-alert
                        title="<?php _e( 'Special Note', 'neoforms' ); ?>"
                        type="warning"
                        description="<?php _e( 'All pro extensions work with neoForms Pro.', 'neoforms' ); ?>"
                        show-icon>
                </el-alert>
            <?php
            }
            ?>
        </div>
        <?php $form_typs = NeoForms_Functions::get_form_types(); ?>
	    <?php
	    $i = 0;
	    foreach ( $form_typs as $name => $val ) {
		    if( $i%3 == 0 ) {
			    ?>
                <el-row :gutter="12">
			    <?php
		    }
		    ?>
            <el-col :span="8" class="mb20">
                <el-card :body-style="{ padding: '0px' }" class="neo_form_type">
                    <div style="padding: 14px;">
                        <h4><?php echo $val['label']; ?></h4>
                        <h5><?php echo isset($val['subtitle']) ? $val['subtitle'] : ''; ?></h5>
                        <div class="bottom clearfix">
                            <div class="mb30"><?php echo $val['desc']; ?></div>
						    <?php  if( !isset( $val['pro'] ) || !$val['pro'] ) { ?>
                                <a class="el-button el-button--success" href="#/forms/new-form/<?php echo $name; ?>"><?php _e( 'Create', 'neoforms' ); ?></a>
						    <?php } ?>
						    <?php
						    if( isset( $val['url'] ) ) { ?>
                                <a class="el-button el-button--primary" target="_blank" href="<?php echo $val['url']; ?>"><?php _e( 'Get '.$val['label'].' now', 'neoforms' ); ?></a>
						    <?php } ?>
                        </div>
                    </div>
                </el-card>
            </el-col>
		    <?php
		    $i++;
		    if( $i%3 == 0 ) {
			    ?>
                </el-row>
			    <?php
		    }
	    }
	    ?>
    </div>
</template>
<script>
    var neoforms_form_types = {
        template: '#neoforms-form-types'
    }
</script>