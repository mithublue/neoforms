<template id="neoforms-form-types">
    <div>
        <?php $form_typs = NeoForms_Functions::get_form_types(); ?>
        <el-row :gutter="12">
            <?php
            foreach ( $form_typs as $name => $val ) {
                ?>
                <el-col :span="8">
                    <el-card :body-style="{ padding: '0px' }">
                        <div style="padding: 14px;">
                            <h4><?php echo $val['label']; ?></h4>
                            <div class="bottom clearfix">
                                <div class="mb30"><?php echo $val['desc']; ?></div>
                                <a class="el-button el-button--primary" href="#/forms/new-form/<?php echo $name; ?>"><?php _e( 'Create', 'neoforms' ); ?></a>
                            </div>
                        </div>
                    </el-card>
                </el-col>
            <?php
            }
            ?>
        </el-row>
    </div>
</template>
<script>
    var neoforms_form_types = {
        template: '#neoforms-form-types'
    }
</script>