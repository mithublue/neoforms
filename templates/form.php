<template id="neoforms_new_form">
    <el-row>
        <el-col :sm="24">
            <div class="neoforms-edit-mode">
                <div class="mb20">
                    <el-alert v-if="notice.msg"
                              :title="notice.header"
                              :type="notice.type"
                              :description="notice.msg"
                              :closable="false"
                              show-icon>
                    </el-alert>
                </div>
                <el-row :gutter="10">
                    <el-col :sm="16">
                        <div class="oh mb20 oh">
                            <div>
                                <h5 class="mb10 mt0"><?php _e( 'Form Title', 'neoforms' ); ?></h5>
                                <el-input type="text" v-model="form.post_title"></el-input>
                            </div>
                        </div>
                        <el-tabs type="border-card">
                            <el-tab-pane label="<?php _e( 'Form Builder', 'neoforms' ); ?>">
                                <div class="neoforms_form_builder_panel">
                                    <template v-if="form_settings.form_settings.s.is_multistep">
                                        <template v-if="is_plainform_data_exist">
                                            <el-card>
                                                <h5 class="mt5"><?php _e( 'There are some fields previously creted. Do you want to import them in multi step form '); ?></h5>
                                                <a @click="import_fields('plain','multi')" href="javascript:" class="el-button el-button--mini"><?php _e( 'Yes, Import All Fields'); ?></a>
                                                <a @click="delete_fields()" href="javascript:" class="el-button el-button--mini"><?php _e( 'No, Delete Previous Fields'); ?></a>
                                            </el-card>
                                        </template>
                                    </template>
                                    <template v-if="!form_settings.form_settings.s.is_multistep">
                                        <template v-if="is_multistep_data_exist">
                                            <el-card>
                                                <h5><?php _e( 'There are some fields previously creted. Do you want to import them in plain form '); ?></h5>
                                                <a @click="import_fields('multi','plain')" href="javascript:" class="el-button el-button--mini"><?php _e( 'Yes, Import All Fields'); ?></a>
                                                <a @click="delete_fields()" href="javascript:" class="el-button el-button--mini"><?php _e( 'No, Delete Previous Fields'); ?></a>
                                            </el-card>
                                        </template>
                                    </template>
                                    <neoforms_new_form_root></neoforms_new_form_root>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="<?php _e( 'Settings', 'neoforms' ); ?>">
			                    <?php $pages = get_pages();
			                    $neoform_pages = array();
			                    foreach( $pages as $k => $each ) {
				                    $neoform_pages[$each->ID] = $each->post_title;
			                    }
			                    $neoform_pages = base64_encode(json_encode($neoform_pages));

			                    $roles = get_editable_roles();
			                    $all_roles = array();
			                    foreach ( $roles as $name => $role ) {
				                    $all_roles[$name] = $role['name'];
			                    }
			                    $all_roles = base64_encode(json_encode($all_roles)); ?>
                                <el-tabs tab-position="left">
                                    <template v-for="(settings,settings_key) in form_settings">
                                        <el-tab-pane :label="settings.label"  v-if="!settings.for">
                                            <vue_form_builder :model="settings.s" :schema="settings.schema.fields"></vue_form_builder>
                                        </el-tab-pane>
                                    </template>
                                    <template v-for="(settings,settings_key) in form_settings">
                                        <el-tab-pane :label="settings.label" v-if="form_settings.form_settings.s.form_type == settings.for">
                                            <vue_form_builder :model="settings.s" :schema="settings.schema.fields"></vue_form_builder>
                                        </el-tab-pane>
                                    </template>
                                </el-tabs>
                            </el-tab-pane>
                        </el-tabs>
                    </el-col>
                    <el-col :sm="8">
                        <div class="mb20 action_panel mt30 oh">
                            <div class="alignleft">
                                <a href="javascript:" @click="update_form('draft')" class="button button-default"><?php _e( 'Save as Draft', 'neoforms' ); ?></a>
                                <a v-if="!form_id || form.post_status !== 'publish'" href="javascript:" @click="update_form('publish')" class="button button-primary"><?php _e( 'Publish', 'neoforms' ); ?></a>
                                <a v-if="form_id && form.post_status == 'publish'" href="javascript:" @click="update_form('publish')" class="button button-primary"><?php _e( 'Update', 'neoforms' ); ?></a>
                                <a @click="delete_form(1)" href="javascript:" class="el-button el-button--mini el-button--danger"><i class="el-icon el-icon-delete"></i> <?php _e('Move to Trash','neoforms'); ?></a>
                            </div>
                        </div>
                        <div>
                            <div class="neo_tabs">
                                <div class="tabs oh">
                                    <a href=""><?php _e( 'Elements Panel', 'neoforms' ); ?></a>
                                </div>
                                <div class="tab_cotnent p10">
                                    <div class="tab_pane">
                                        <div id="ui-neoforms_panel_ground-1">
                                            <div class="neo_element_tree">
	                                            <?php do_action('neo_before_element_tree' ); ?>
                                                <template v-if="!is_multistep">
                                                    <ul>
                                                        <template v-for="(row_data,r) in formdata.field_data">
                                                            <li class="ui-neoforms_row-1 neo_tree_placeholder" v-if="row_data.type == 'row'"
                                                                :target_row="r" :data-row_number="r"
                                                            >
                                                                <span class="neo_tree_placeholder_span pr neo_row_mover">
                                                                    <?php _e( 'Placeholder', 'neoforms' ); ?>
                                                                    <a href="javascript:" class="pa" @click="open_tree_row(row_data)"
                                                                       v-if="opened_tree_row !== row_data"
                                                                    ><i class="el-icon-plus"></i></a>
                                                                    <a href="javascript:" class="pa" @click="close_tree_row(row_data)"
                                                                       v-if="opened_tree_row === row_data"
                                                                    ><i class="el-icon-minus"></i></a>
                                                                </span>
                                                                <ul v-if="row_data.row_formdata.length && row_data == opened_tree_row">
                                                                    <template v-for="(field_data,c) in row_data.row_formdata">
                                                                        <li class="ui-neoforms_col-1 neo_tree_field"
                                                                            :target_col="c"
                                                                            :target_row="r"
                                                                        >
                                                                            <span class="neo_tree_field_span pr neo_col_mover">
                                                                                {{ field_data.s.label }}
                                                                                <a class="pa" href="javascript:" @click="open_tree_col(field_data)"
                                                                                   v-if="opened_tree_col !== field_data"
                                                                                ><i class="el-icon-plus"></i></a>
                                                                                <a class="pa" href="javascript:" @click="close_tree_col(field_data)"
                                                                                   v-if="opened_tree_col === field_data"
                                                                                ><i class="el-icon-minus"></i></a>
                                                                            </span>
                                                                            <div class="neo_tree_field_settings" v-if="opened_tree_col === field_data">
                                                                                <el-collapse accordion>
                                                                                    <template v-for="(formtab,k) in field_attr[field_data.preview.name].schema">
                                                                                        <el-collapse-item :title="formtab.label">
                                                                                            <vue_form_builder :model="field_data.s" :schema="formtab.fields"></vue_form_builder>
                                                                                        </el-collapse-item>
                                                                                    </template>
                                                                                </el-collapse>
                                                                            </div>
                                                                        </li>
                                                                    </template>
                                                                </ul>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </el-col>
                </el-row>
            </div>
        </el-col>
    </el-row>
</template>
<script>
    var $neoform_pages = JSON.parse(atob('<?php echo $neoform_pages; ?>'));
    var $all_roles = JSON.parse(atob('<?php echo $all_roles; ?>'));

    var neoforms_new_form = {
        template: '#neoforms_new_form',
        data: function () {
            return {
                opened_tree_step: {},
                opened_tree_row: {},
                opened_tree_col: {}
            }
        },
        methods: {
            /*action panel methods*/
            open_tree_step: function(step_data) {
                this.opened_tree_step = step_data;
            },
            close_tree_step: function (step_data) {
                if( this.opened_tree_step == step_data ) {
                    this.opened_tree_step = {}
                }
            },
            open_tree_row: function (row_data) {
                this.opened_tree_row = row_data;
            },
            close_tree_row: function (row_data) {
                if( this.opened_tree_row == row_data ) {
                    this.opened_tree_row = {}
                }
            },
            open_tree_col: function (field_data) {
                this.opened_tree_col = field_data;
            },
            close_tree_col: function (field_data) {
                if( this.opened_tree_col === field_data ) {
                    this.opened_tree_col = {}
                }
            },
            update_form: function (status) {
                this.$store.dispatch('update_form',{status:status});
            },
            delete_form: function (trashDelete) {
                this.$store.dispatch('delete_form', {form_id: this.form_id, soft:typeof trashDelete !== 'undefined' ? trashDelete : 1});
                router.push('/forms');
            },
            import_fields: function ( from, to ) {
                this.$store.dispatch( 'import_fields', {from: from, to: to} );
                var self = this;
                setTimeout(function () {
                    neo_reset_sortable(self,self.is_multistep);
                },1);
            },
            delete_fields: function () {
                this.$store.dispatch( 'delete_fields' );
            },
            fetchData: function () {
                var self = this;
                //reset all so that, any settings changed is not left
                this.$store.dispatch('reset_all');

                //if new form
                if ( typeof  this.$route.params.form_type !== 'undefined' ) {
                    if( typeof neoforms_form_type_data[this.$route.params.form_type] !== 'undefined') {
                        this.$store.dispatch('populate_form_type_data',
                            {
                                form_data:neoforms_form_type_data[this.$route.params.form_type],
                                form_title : neoforms_form_type_data[this.$route.params.form_type].label
                            });
                    }
                    this.update_form('publish');
                }

                //if edit form
                else if ( typeof this.$route.params.form_id !== 'undefined' ) {
                    this.$store.dispatch('get_form',{id:this.$route.params.form_id, callback: function () {
                        return;
                        /*neo_reset_sortable_row(self, self.is_multistep);
                        setTimeout(function () {
                            neo_reset_sortable_field(self, self.is_multistep);
                        },1);*/
                    }});
                }
            }
        },
        computed: {
            field_attr: function () {
                console.log('ha ha ha');
                console.log(this.$store.getters.field_attr);
                return this.$store.getters.field_attr;
            },
            form: function () {
                return this.$store.getters.form;
            },
            form_settings: function () {
                if( typeof this.$route.params.form_type !== 'undefined' ) {
                    this.$store.dispatch( 'set_form_type', {form_type: this.$route.params.form_type});
                }
                return this.$store.getters.form_settings;
            },
            form_id: function () {
                if( this.$route.params.form_id !== 'undefined' ) {
                    return this.$route.params.form_id
                }
                return '';
            },
            notice: function () {
                return this.$store.getters.notice;
            },
            formdata: function () {
                console.log(this.$store.getters.formdata);
                return this.$store.getters.formdata;
            },
            is_multistep: function () {
                return this.$store.getters.is_multistep;
            },
            field_data: {
                get: function () {
                    return this.$store.getters.field_data;
                },
                set: function (value) {
                    this.$store.commit('set_field_data', {value: value});
                }
            },
            is_plainform_data_exist: function () {
                for( var k in this.formdata.field_data ) {
                    if( this.formdata.field_data[k].type === 'row' ) {
                        return true;
                    }
                }
                return false;
            },
            is_multistep_data_exist: function () {
                for( var k in this.formdata.field_data ) {
                    if( this.formdata.field_data[k].type === 'step' ) {
                        return true;
                    }
                }
                return false;
            }
        },
        watch: {
            // call again the method if the route changes
            $route: function (to, from){
                this.fetchData();
            }
        },
        mounted: function () {
            this.fetchData();
        }
    };
</script>
<!---->
<template id="neoforms_row">
    <div class="ui-neoforms_row" @mouseover="make_focused_row(row_number)" @mouseout="defocus_row(row_number)" :target_row="row_number" :data-row_number="row_number" :class="{focused_row:is_focused_row}">
        <el-row style="text-align: center;">
            <neoforms_row_panel :target_row="row_number" v-if="is_focused_row && is_editing"></neoforms_row_panel>
            <template v-if="form_data.length">
                <template v-for="(field_data,k) in form_data">
                    <neoforms_input_template v-if="field_data.type == 'input' || field_data.inputType == 'text'"
                                             :field_data="field_data" :target_row="row_number" :target_col="k"></neoforms_input_template>
                </template>
            </template>
            <template v-else>
                <a href="javascript:" v-if="is_editing"><i class="el-icon-circle-plus-outline button-large"></i></a>
            </template>
        </el-row>
    </div>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_row',{
            template: '#neoforms_row',
            props: ['row_number','form_data'],
            data: function () {
                return {
                    focused_row: false,
                    show_field_panel: false
                };
            },
            methods: {
                defocus_row: function (row_number) {
                    if( !this.is_editing ) return;
                    this.$store.dispatch('defocus_row',{focused_row:row_number});
                },
                make_focused_row: function (row_number) {
                    if( !this.is_editing ) return;
                    this.$store.dispatch('make_focused_row',{focused_row:row_number});
                }
            },
            computed: {
                is_focused_row: function () {
                    return this.$store.getters.focused_row === this.row_number;
                },
                is_editing: function () {
                    return this.$store.getters.is_editing;
                }
            }
        });
    });
</script>
<template id="neoforms_new_form_root">
    <!--if -->
    <div id="ui-neoforms_builder_ground">

        <div :class="'neoforms_layout_' + form_settings.appearance_settings.s.layout_type">
            <el-form ref="form" label-width="120px" method="post">
                <div class="neoforms_db neoforms_center pr">
                    <template v-if="is_editing">
                        <a href="javascript:" @click="add_row()" class="neoforms_btn-add_row" title="<?php _e( 'Add Placeholder', 'neoforms' ); ?>">
                            <i class="dashicons dashicons-plus-alt"></i> <?php _e( 'Add Placeholder', 'neoforms' ); ?>
                        </a>
                    </template>
                    <a href="javascript:" @click="set_is_editing()" v-if="!is_editing" class="neoforms_btn-add_row" title="<?php _e( 'Edit', 'neoforms' ); ?>"><i class="dashicons dashicons-edit"></i> <?php _e( 'Edit', 'neoforms' ); ?></a>
                    <a href="javascript:" @click="unset_is_editing()" v-if="is_editing" class="neoforms_btn-add_row" title="<?php _e( 'Preview', 'neoforms' ); ?>"><i class="dashicons dashicons-visibility"></i> <?php _e( 'Preview', 'neoforms' ); ?></a>
                    <?php do_action('neo_formbuilder_header'); ?>
                </div>
                <?php do_action('neo_before_formbuilder' ); ?>
                <template v-if="!is_multistep">
                    <template v-for="(row_data,k) in field_data" v-if="render_field_list">
                        <neoforms_row v-if="row_data.type == 'row'" :row_number="k" :form_data="row_data.row_formdata"></neoforms_row>
                    </template>
                </template>
            </el-form>
        </div>
    </div>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_new_form_root',{
            template: '#neoforms_new_form_root',
            data: function () {
                return {
                    render_field_list: true,
                    tab_panel_open: false,
                    multistep_panel_open: false,
                    colorpicker_off: false,
                    x_data: {
                        multistep_settings_schema: [
                            {
                                model: 'back-button-text',
                                type: 'input',
                                inputType: 'Text',
                                label: 'Back Button Text',
                            },
                            {
                                model: 'color',
                                type: 'input',
                                inputType: 'Text',
                                label: 'Color',
                            },
                            {
                                model: 'error-color',
                                type: 'input',
                                inputType: 'Text',
                                label: 'Error Color',
                            },
                            {
                                model: 'next-button-text',
                                type: 'input',
                                inputType: 'Text',
                                label: 'Next Button Text',
                            },
                            {
                                model: 'finish-button-text',
                                type: 'input',
                                inputType: 'Text',
                                label: 'Finish Button Text',
                            },
                            {
                                model: 'shape',
                                type: 'select',
                                label: 'Tab Type',
                                multiple: false,
                                options : {
                                    circle : 'Circle',
                                    tab : 'Tab',
                                    square : 'Square'
                                }
                            },
                        ]
                    }
                }
            },
            computed: {
                is_multistep: function () {
                    return this.$store.getters.is_multistep;
                },
                field_data: {
                    get: function () {
                        var self = this;
                        neo_reset_sortable(self, self.is_multistep);
                        return this.$store.getters.field_data;
                    },
                    set: function (value) {
                        this.$store.commit('set_field_data', {value: value});
                    }
                },
                formdata: function () {
                    var self = this;
                    neo_reset_sortable(self, self.is_multistep);
                    return this.$store.getters.formdata;
                },
                /*pro*/
                multistep_settings: function () {
                    return this.$store.getters.multistep_settings;
                },
                is_editing: function () {
                    return this.$store.getters.is_editing;
                },
                form_settings: function () {
                    return this.$store.getters.form_settings;
                },
                focused_step: function () {
                    return this.$store.getters.focused_step;
                }
            },
            methods: {
                set_is_editing: function () {
                    this.$store.dispatch('set_is_editing');
                },
                unset_is_editing: function () {
                    this.$store.dispatch('unset_is_editing');
                },
                add_row: function () {
                    this.$store.dispatch('add_row',{target_row:''});
                },
                add_tab: function () {
                    this.$store.dispatch('add_tab');
                },
                /*pro*/
                delete_tab: function () {
                    this.$store.dispatch('delete_tab');
                },
                updateBgValue: function (color) {
                    this.s.background = color.hex;
                },
                tab_on_change: function (prevIndex, nextIndex) {
                    this.$store.dispatch('make_focused_step',{focused_step: nextIndex});
                }
            },
            mounted: function () {
                var self = this;
                setTimeout(function () {

                },500);
            }
        });
    });
</script>
<template id="neoforms_input_template">
    <el-col :md="field_data.settings.atts.span"
            class="ui-neoforms_col"
            :target_col="target_col"
            :target_row="target_row"
    >
        <div @mouseover="make_focused_col(target_col)" @mouseout="defocus_col(target_col)"
             :target_col="target_col"
             :target_row="target_row"
             :class="{'input-col': is_focused_col()}">

            <el-form-item :label="field_data.s.label"
                          :rules="[{
            required : field_data.s.required ? true : false, message: field_data.s.label + ' is required field'
            }]"
            >
                <?php do_action('neoforms_form_item_top' )?>
                <?php include_once 'form-items.php';?>
                <?php do_action('neoforms_form_item_bottom' )?>
            </el-form-item>
            <neoforms_input_panel :field_data="field_data" v-if="is_focused_col() && is_editing"></neoforms_input_panel>
        </div>
    </el-col>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_input_template',{
            props: ['field_data','target_row','target_col'],
            template: '#neoforms_input_template',
            methods: {
                make_focused_col: function (target_col) {
                    this.$store.dispatch('make_focused_col',{focused_col:target_col});
                },
                defocus_col: function (target_col) {
                    this.$store.dispatch('defocus_col',{focused_col:target_col});
                },
                is_focused_col: function () {
                    return this.$store.getters.focused_row === this.target_row && this.$store.getters.focused_col === this.target_col;
                },
            },
            computed:{
                focused_row: function () {
                    return this.$store.getters.focused_row;
                },
                focused_col: function () {
                    return this.$store.getters.focused_col;
                },
                is_editing: function () {
                    return this.$store.getters.is_editing;
                }
            }
        });
    });
</script>
<template id="neoforms_input_panel">
    <div class="neoforms_input_panel">
        <a href="javascript:" @click="show_grids = true;set_edit_mode();" title="<?php _e( 'Resize', 'neoforms' ); ?>">
            <i class="dashicons dashicons-leftright"></i>
        </a>
        <a href="javascript:" @click="open_settings = !open_settings;toggle_edit_mode();" title="<?php _e( 'Settings', 'neoforms' ); ?>">
            <i class="dashicons dashicons-admin-generic"></i>
        </a>
        <a href="javascript:" @click="clone_col()" title="<?php _e( 'Clone Field'); ?>">
            <i class="dashicons dashicons-welcome-add-page"></i>
        </a>
        <a href="javascript:" @click="copy_col()" title="<?php _e( 'Copy Field'); ?>">
            <i class="dashicons dashicons-admin-page"></i>
        </a>
        <a href="javascript:" @click="remove_field()" title="<?php _e( 'Remove', 'neoforms' ); ?>">
            <i class="dashicons dashicons-trash"></i>
        </a>
        <a href="javascript:" class="neo_col_mover" title="<?php _e( 'Move Field'); ?>"><i class="dashicons dashicons-move"></i></a>
        <div v-if="open_settings" class="neoforms-field-settings-panel">
            <div class="neoforms_center mb5">
                <a href="javascript:" class="neoforms_btn-flat" @click="open_settings = false;unset_edit_mode();"><?php _e( 'Save', 'neoforms' ); ?></a>
                <a href="javascript:" class="neoforms_btn-flat" @click="cancel_editing();open_settings = false;unset_edit_mode();"><?php _e( 'Cancel', 'neoforms' ); ?></a>
            </div>
            <el-tabs type="border-card">
                <template v-for="(formtab,k) in col_formdata_schema">
                    <el-tab-pane :label="formtab.label">
                        <vue_form_builder :model="col_formdata.s" :schema="formtab.fields"></vue_form_builder>
                    </el-tab-pane>
                </template>
            </el-tabs>
        </div>
        <div class="neoforms_grid_panel" v-if="show_grids">
            <a href="javascript:" v-for="(val,k) in grid_array" @click="resize_col(val)"
            :class="{ active_col_btn:field_data.settings.atts.span == val }"
            >{{ val }}</a>
            <a href="javascript:" @click="show_grids = false;unset_edit_mode();">x</a>
        </div>
    </div>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_input_panel',{
            template: '#neoforms_input_panel',
            props: ['field_data'],
            data: function () {
                return {
                    show_grids: false,
                    open_settings: false,
                    grid_array: [],
                    temp_col_formdata: {},
                };
            },
            methods: {
                copy_col: function () {
                    this.$store.dispatch('copy_col',{field_data:this.field_data});
                },
                resize_col: function (val) {
                    this.$store.dispatch('resize_col',{col:val});
                },
                toggle_edit_mode: function () {
                    if( this.open_settings ) {
                        this.$store.dispatch('set_edit_mode');
                        this.temp_col_formdata = neoforms_reset_fields(this.col_formdata.s);
                    } else {
                        this.$store.dispatch('unset_edit_mode');
                        this.temp_col_formdata = {};
                    }
                },
                set_edit_mode: function () {
                    this.$store.dispatch('set_edit_mode');
                    this.temp_col_formdata = neoforms_reset_fields(this.col_formdata.s);
                },
                unset_edit_mode: function () {
                    this.$store.dispatch('unset_edit_mode');
                    this.temp_col_formdata = {};
                },
                cancel_editing: function () {
                    if( Object.keys(this.temp_col_formdata).length ) {
                        this.col_formdata.s = neoforms_reset_fields( this.temp_col_formdata );
                    }
                },
                remove_field: function () {
                    this.$store.dispatch('remove_field');
                },
                clone_col: function () {
                    this.$store.dispatch('clone_col');
                }
            },
            computed: {
                grids: function () {
                    return this.$store.getters.grids;
                },
                col_formdata: function () {
                    var col_formdata = this.$store.getters.col_formdata;
                    return col_formdata;
                },
                col_formdata_s: function () {
                    return this.$store.getters.col_formdata_s;
                },
                col_formdata_schema: function () {
                    var col_formdata_schema = this.$store.getters.col_formdata_schema;
                    return col_formdata_schema;
                }
            },
            mounted: function () {
                for ( var i = 0; i <= this.grids; i++ ) {
                    this.grid_array.push(i);
                }
            }
        })
    });
</script>
<template id="neoforms_row_panel">
    <div class="row-panel pr">
        <a href="javascript:" @click="show_field_list();set_edit_mode();" v-if="!is_show_field_list"><i class="dashicons dashicons-plus-alt2"></i> <?php _e( 'Add Field', 'neoforms' ); ?></a>
        <a href="javascript:" @click="hide_field_list();unset_edit_mode();" v-if="is_show_field_list"><i class="dashicons dashicons-no-alt"></i> <?php _e( 'Close Panel', 'neoforms' ); ?></a>
        <a href="javascript:" @click="add_row(target_row)" title="<?php _e( 'Add Placeholder', 'neoforms' ); ?>"><i class="dashicons dashicons-plus-alt"></i> <?php _e( 'Add Placeholder', 'neoforms' ); ?></a>
        <a href="javascript:" @click="clone_row(target_row)" title="<?php _e( 'Clone Placeholder', 'neoforms' ); ?>"><i class="dashicons dashicons-welcome-add-page"></i></a>
        <a href="javascript:" @click="copy_row()" title="<?php _e( 'Copy Placeholder', 'neoforms' ); ?>">
            <i class="dashicons dashicons-admin-page"></i>
        </a>
        <a href="javascript:" v-if="copied_row" @click="paste_row()"><i class="dashicons dashicons-category"></i> <?php _e( 'Paste Placeholder', 'neoforms' ); ?></a>
        <a href="javascript:" v-if="copied_col" @click="paste_col()"><i class="dashicons dashicons-feedback"></i><?php _e( 'Paste Field', 'neoforms' ); ?></a>
        <a href="javascript:" @click="remove_row(target_row)" title="<?php _e( 'Remove Placeholder', 'neoforms' ); ?>"><i class="dashicons dashicons-trash"></i></a>
        <a href="javascript:" class="neo_row_mover" title="<?php _e( 'Move Placeholder'); ?>" title="<?php _e( 'Sort', 'neoforms' ); ?>"><i class="dashicons dashicons-move"></i></a>
        <neoforms_field_list :target_row="target_row"></neoforms_field_list>
    </div>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_row_panel',{
            template:'#neoforms_row_panel',
            props:['target_row'],
            data: function () {
                return {
                    open_menu: false,
                    open_settings: false
                }
            },
            methods: {
                paste_row: function () {
                    this.$store.dispatch('paste_row',{row_number:this.target_row});
                },
                paste_col: function () {
                    this.$store.dispatch('paste_col',{row_number:this.target_row});
                },
                copy_row: function () {
                    this.$store.dispatch('copy_row',{row_number:this.target_row});
                },
                toggle_edit_mode: function () {
                    if( this.open_settings ) {
                        this.$store.dispatch('set_edit_mode');
                    } else {
                        this.$store.dispatch('unset_edit_mode');
                    }
                },
                set_edit_mode: function () {
                    this.$store.dispatch('set_edit_mode');
                },
                unset_edit_mode: function () {
                    this.$store.dispatch('unset_edit_mode');
                },
                remove_row: function (target_row) {
                    this.$store.dispatch('remove_row',{target_row:target_row});
                },
                show_field_list: function () {
                    this.$store.dispatch('show_field_list',{target_row:this.target_row});
                },
                hide_field_list: function () {
                    this.$store.dispatch('hide_field_list');
                },
                add_row: function (target_row) {
                    this.$store.dispatch('add_row',{target_row:target_row+1});
                },
                clone_row: function () {
                    this.$store.dispatch('clone_row');
                }
            },
            computed:{
                copied_row: function () {
                    return this.$store.getters.copied_row;
                },
                copied_col: function () {
                    return this.$store.getters.copied_col;
                },
                is_show_field_list: function () {
                    return this.$store.getters.is_show_field_list === this.target_row;
                }
            }
        })
    });
</script>
<template id="neoforms_field_list">
    <div class="field-panel-list" v-if="is_show_field_list == true">
        <el-card class="box-card">
            <ul class="oh">
                <li v-for="(field,k) in formFields">
                    <el-button @click="hide_field_list();add_field(field,target_row);unset_edit_mode();" v-if="typeof field.pro === 'undefined'">
                        {{ field.preview.label }}
                    </el-button>
                    <el-button v-else :disabled="true">
                        {{ field.preview.label }} (Pro)
                    </el-button>
                </li>
                <li>
                    <el-button href="javascript:" @click="hide_field_list();unset_edit_mode();" class="field-panel-list-close">
                        <i class="el-icon-close"></i>
                    </el-button>
                </li>
            </ul>
        </el-card>
    </div>
</template>
<script>
    ;document.addEventListener("DOMContentLoaded", function(event) {
        Vue.component('neoforms_field_list',{
            template: '#neoforms_field_list',
            props: ['target_row'],
            data: function () {
                return {
                    formFields: formFields,
                    open_settings: false
                }
            },
            methods: {
                toggle_edit_mode: function () {
                    if( this.open_settings ) {
                        this.$store.dispatch('set_edit_mode');
                    } else {
                        this.$store.dispatch('unset_edit_mode');
                    }
                },
                set_edit_mode: function () {
                    this.$store.dispatch('set_edit_mode');
                },
                unset_edit_mode: function () {
                    this.$store.dispatch('unset_edit_mode');
                },
                add_field: function ( field, target_row ) {
                    field.s = field_attr[field.preview.name].s;
                    field.schema = field_attr[field.preview.name].schema;
                    this.$store.dispatch('add_field',{'field':field,'target_row' : target_row});
                },
                hide_field_list: function () {
                    this.$store.dispatch('hide_field_list')
                }
            },
            computed: {
                is_show_field_list: function () {
                    return this.$store.getters.is_show_field_list === this.target_row;
                }
            },
            mounted: function () {
            }
        });
    });
</script>
<?php do_action('neoforms_components_form_items' ); ?>