<?php

class NeoForms_Shortcode_Handler {

    protected $formdata = array();
    protected $form_settings = array();

    public function __construct() {
        add_shortcode( 'neoforms', array( $this, 'handle_shortcode') );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts_styles'));
        add_action( 'wp_footer', array( $this, 'wp_footer'));
        add_action( 'wp_head', array( $this, 'wp_head' ) );
    }

    public function handle_shortcode( $atts, $content, $tags ) {
        $atts = shortcode_atts( array(
            'id' => ''
        ), $atts );

        if( !isset( $atts['id'] ) ) return;

        $form = get_post( $atts['id'] );
        if( !$form ) return;

        if( get_post_status($form->ID) !== 'publish' ) return;

	    $this->form_settings[$atts['id']] = json_decode( base64_decode( NeoForms_Functions::get_form_settings($atts['id']) ), true ) ;
        $form_settings = $this->form_settings[$atts['id']];//json_decode( base64_decode( $this->form_settings[$atts['id']] ), true );

	    /**
	     * Form restriction
	     */
	    $is_restricted = 0;

	    if( $form_settings['form_restriction']['s']['is_scheduled'] ) {
		    if( $form_settings['form_restriction']['s']['schedule_from'] && $form_settings['form_restriction']['s']['schedule_to'] ) {
		        if( time() < $form_settings['form_restriction']['s']['schedule_from'] || time() > strtotime( $form_settings['form_restriction']['s']['schedule_to'] ) ) {
		            $is_restricted = 1;
			        echo $form_settings['form_restriction']['s']['msg_before_schedule'];
                }
            }
        }

        if( $form_settings['form_restriction']['s']['limit_submission'] ) {
	        if( $form_settings['form_restriction']['s']['number_of_submission'] >= NeoForms_Functions::get_submission_occurance( $atts['id'] ) ) {
	            $is_restricted = 1;
	            echo $form_settings['form_restriction']['s']['limit_break_msg'];
            }
        };

	    if( $form_settings['form_restriction']['s']['require_login'] ) {
	        if( !is_user_logged_in() ) {
	            $is_restricted = 1;
		        echo $form_settings['form_restriction']['s']['require_login_msg'];
            }
        }

        $is_restricted = apply_filters( 'neoforms_process_form_restriction', $is_restricted, $form_settings );

        if( $is_restricted ) {
	        return;
        }

	    $this->formdata[$atts['id']] = apply_filters( 'neo_public_formdata_'.$form_settings['form_settings']['s']['form_type'], NeoForms_Functions::get_formdata($atts['id']), $form_settings );
        ?>
        <div id="neoforms-<?php echo $atts['id']; ?>">
            <?php do_action( 'neo_before_form'); ?>
            <div class="mb10">
                <template v-for="(error,fieldname) in errors">
                    <div class="mb5">
                        <el-alert
                                :title="error"
                                type="error"
                                :closable="false"
                        >
                        </el-alert>
                    </div>
                </template>
                <template v-for="(success,fieldname) in successes">
                    <el-alert
                            :title="success"
                            type="success"
                            :closable="false"
                    >
                    </el-alert>
                </template>
            </div>
	        <?php do_action( 'neo_public_before_form', $this->formdata[$atts['id']], $this->form_settings[$atts['id']] ); ?>
            <div :class="'neoforms_layout_' + form_settings.appearance_settings.s.layout_type">
                <el-form ref="form" label-width="120px" method="post" enctype="multipart/form-data" onsubmit="return false;"> <!---->
                    <?php do_action( 'neo_form_start', $this->formdata[$atts['id']], $this->form_settings[$atts['id']] ); ?>
                    <input type="hidden" name="neoform_submission_id" value="<?php echo $atts['id']; ?>">
                    <div>
                        <template v-if="!form_settings.form_settings.s.is_multistep || typeof form_settings.form_settings.s.is_multistep === 'undefined'">
                            <template v-for="(row_data,k) in formdata.field_data">
                                <neoforms_row :relations="relations" v-if="row_data.type == 'row'" :row_number="k" :form_data="row_data.row_formdata"></neoforms_row>
                            </template>
                            <el-form-item>
                                <input @click="submitForm" name="neoforms_submit" type="submit" class="el-button" value="<?php _e( 'Submit', 'neoforms' ); ?>">
                            </el-form-item>
                        </template>
                    </div>
                    <?php do_action( 'neo_form_end', $this->formdata[$atts['id']], $this->form_settings[$atts['id']] ); ?>
                </el-form>
            </div>
            <?php do_action( 'neo_after_form', $this->formdata[$atts['id']], $this->form_settings[$atts['id']] ); ?>
        </div>
        <?php
    }

    /**
     * Enqueue scripts
     */
    public function wp_enqueue_scripts_styles() {
        global $post;
        if( !isset( $post->post_content) ) return;
        if( !has_shortcode( $post->post_content, 'neoforms' ) ) return;

        wp_enqueue_style('neoforms-framework-css', NEOFORMS_ASSET_PATH.'/css/framework.css' );
        wp_enqueue_style('neoforms-style-css', NEOFORMS_ASSET_PATH.'/css/style.css' );
        wp_enqueue_style('neoforms-element-css', NEOFORMS_ASSET_PATH.'/css/element.css' );

        wp_enqueue_script('neoforms-vue', NEOFORMS_ASSET_PATH.'/js/vue.js', array(), false, true );
        
        wp_enqueue_script('neoforms-element-js', NEOFORMS_ASSET_PATH.'/js/element.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-element-en-js', NEOFORMS_ASSET_PATH.'/js/element-en.js', array( 'neoforms-vue' ), false, true );

        /*form data*/
        wp_enqueue_script('neoforms-functions-js', NEOFORMS_ASSET_PATH.'/js/functions.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-comp-public-form-js', NEOFORMS_ASSET_PATH.'/js/templates/form-public.js', array( 'neoforms-vue' ), false, true );
        wp_localize_script( 'neoforms-functions-js', 'neoforms_object', array(
                'ajaxurl' => admin_url('admin-ajax.php')
        ));

        do_action('neoforms_public_load_scripts_styles' );
    }


    public function wp_head() {
        global $post;
        if( has_shortcode( $post->post_content, 'neoforms' ) ) {
            ?>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <?php
        }
    }

    public function wp_footer() {
        global $post;
        include_once 'templates/form-public.php';

        if( has_shortcode( $post->post_content, 'neoforms' ) ) {
            foreach ( $this->formdata as $id => $formdata ) {
                ?>
                <script>
                    var app_element = '#' + 'neoforms-' + '<?php echo $id; ?>';
                    var ajaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
                    ;document.addEventListener("DOMContentLoaded", function(event) {
                        new Vue({
                            el: app_element,
                            data: {
                                formdata: {},
                                form_settings: {},
                                errors: [],
                                successes: []
                            },
                            methods: {
                                submitForm: function () {
                                    this.process_form();
                                    return false;
                                },
                                process_form: function () {
                                    var _this = this;
                                    ;(function ($) {
                                        $.post(
                                            ajaxURL,
                                            {
                                                action: 'neoforms_submit_form',
                                                formData: $(app_element + ' form').serialize()
                                            },
                                            function (data) {
                                                if( !data.success ) {
                                                    _this.successes = [];
                                                    _this.errors = data.data.errors;
                                                } else {
                                                    _this.successes = [data.data.msg];
                                                    _this.errors = [];
                                                }
                                            }
                                        );
                                    }(jQuery));
                                }
                            },
                            computed: {
                                row_name_data: function () {
                                    var name_data = {};
                                    for( var k in this.formdata.field_data ) {
                                        if ( this.formdata.field_data[k].type === 'row' ) {
                                            for( var r in this.formdata.field_data[k].row_formdata ) {
                                                if( typeof this.formdata.field_data[k].row_formdata[r].s.value !== 'undefined' ) {
                                                    name_data[this.formdata.field_data[k].row_formdata[r].s.name] = this.formdata.field_data[k].row_formdata[r].s.value;
                                                } else if ( typeof this.formdata.field_data[k].row_formdata[r].s.sel_values !== 'undefined' ) {
                                                    name_data[this.formdata.field_data[k].row_formdata[r].s.name] = this.formdata.field_data[k].row_formdata[r].s.sel_values;
                                                } else if ( typeof this.formdata.field_data[k].row_formdata[r].s.selected_val !== 'undefined' ) {
                                                    name_data[this.formdata.field_data[k].row_formdata[r].s.name] = this.formdata.field_data[k].row_formdata[r].s.selected_val;
                                                }
                                            }
                                        }
                                    }
                                    return name_data;
                                },
                                step_name_data: function () {
                                    var name_data = {};
                                    for( var k in this.formdata.field_data ) {
                                        if ( this.formdata.field_data[k].type === 'step' ) {
                                            for( var s in this.formdata.field_data[k].step_formdata ) {
                                                if ( this.formdata.field_data[k].step_formdata[s].type === 'row' ) {
                                                    for( var r in this.formdata.field_data[k].step_formdata[s].row_formdata ) {
                                                        if( typeof this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.value !== 'undefined' ) {
                                                            name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.name] = this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.value;
                                                        } else if ( typeof this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.sel_values !== 'undefined' ) {
                                                            name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.name] = this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.sel_values;
                                                        } else if ( typeof this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.selected_val !== 'undefined' ) {
                                                            name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.name] = this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.selected_val;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    return name_data;
                                },
                                name_data: function () {
                                    if( this.form_settings.form_settings.s.is_multistep ) {
                                        return this.step_name_data;
                                    } else {
                                        return this.row_name_data;
                                    }
                                },
                                row_relations: function () {
                                    var relations = {};
                                    for( var k in this.formdata.field_data ) {
                                        if( this.formdata.field_data[k].type == 'row' ) {
                                            for( var r in this.formdata.field_data[k].row_formdata ) {
                                                if( this.formdata.field_data[k].row_formdata[r].s.has_relation ) {

                                                    var condition = 1;

                                                    for( var rel in this.formdata.field_data[k].row_formdata[r].s.relation ) {
                                                        var relation_type = '';
                                                        if( this.formdata.field_data[k].row_formdata[r].s.relation[rel].relation_type === 'or' ) {
                                                            relation_type = '||';
                                                        } else {
                                                            relation_type = '&&';
                                                        }

                                                        if ( typeof this.name_data[this.formdata.field_data[k].row_formdata[r].s.relation[rel].field] === 'object' ) {
                                                            condition = this.name_data[this.formdata.field_data[k].row_formdata[r].s.relation[rel].field].indexOf( this.formdata.field_data[k].row_formdata[r].s.relation[rel].value ) !== -1 ? true : false;
                                                        } else {
                                                            condition = this.name_data[this.formdata.field_data[k].row_formdata[r].s.relation[rel].field] === this.formdata.field_data[k].row_formdata[r].s.relation[rel].value;
                                                        }
                                                    }
                                                    relations[this.formdata.field_data[k].row_formdata[r].s.name] = condition;
                                                } else {
                                                    relations[this.formdata.field_data[k].row_formdata[r].s.name] = 1;
                                                }
                                            }
                                        }
                                    }
                                    return relations;
                                },
                                step_relations: function () {
                                    var relations = {};
                                    for( var k in this.formdata.field_data ) {
                                        if( this.formdata.field_data[k].type == 'step' ) {
                                            for( var s in this.formdata.field_data[k].step_formdata ) {
                                                if( this.formdata.field_data[k].step_formdata[s].type == 'row' ) {
                                                    for( var r in this.formdata.field_data[k].step_formdata[s].row_formdata ) {
                                                        if( this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.has_relation ) {

                                                            var condition = 1;
                                                            for( var rel in this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation ) {
                                                                var relation_type = '';
                                                                if( this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].relation_type === 'or' ) {
                                                                    relation_type = '||';
                                                                } else {
                                                                    relation_type = '&&';
                                                                }

                                                                if ( typeof this.name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].field] === 'object' ) {
                                                                    condition = this.name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].field].indexOf( this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].value ) !== -1 ? true : false;
                                                                } else {
                                                                    condition = this.name_data[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].field] === this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.relation[rel].value;
                                                                }
                                                            }
                                                            relations[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.name] = condition;
                                                        } else {
                                                            relations[this.formdata.field_data[k].step_formdata[s].row_formdata[r].s.name] = 1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    return relations;
                                },
                                relations: function () {
                                    if( this.form_settings.form_settings.s.is_multistep ) {
                                        return this.step_relations;
                                    } else {
                                        return this.row_relations;
                                    }
                                }

                            } ,
                            created: function () {
                                this.formdata = neoforms_parse('<?php echo $formdata; ?>');
                                this.form_settings = neoforms_parse('<?php echo base64_encode( json_encode( $this->form_settings[$id] ) ); ?>');
                            }
                        });
                    });
                </script>
                <?php
            }
        }
    }
}

new NeoForms_Shortcode_Handler();

//test
add_action( 'init', function () { return;
    if( isset( $_POST['neoforms_submit'] ) ) {
        neoforms_pri($_POST);
        $submission = new Neoforms_Submission_Process($_POST);
        if( $submission->get_errors() )
            neoforms_pri($submission->get_errors());

        die();
    }
});
