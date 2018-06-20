<template id="neoforms_settings">
    <div>
        <el-tabs type="border-card" tab-position="left">
            <el-alert v-if="notice.msg"
                :title="notice.header"
                :type="notice.type"
                :description="notice.msg"
                      :closable="false"
                      show-icon>
            </el-alert>
            <template v-for="(section, key) in global_settings_sections">
                <el-tab-pane :label="section.label">
                    <el-form>
                        <vue_form_builder :model="global_settings" :schema="section.schema.fields"></vue_form_builder>
                        <p>{{ section.desc }}</p>
                    </el-form>
                </el-tab-pane>
            </template>
            <a href="javascript:" class="button button-primary" @click="save_global_settings"><?php _e( 'Save'); ?></a>
        </el-tabs>
    </div>
</template>
<script>
    var global_settings_sections = neo_apply_filters( 'global_settings_sections', {});
    var neoforms_settings = {
        template: '#neoforms_settings',
        data: function () {
            return {
                global_settings_sections: global_settings_sections
            }
        },
        methods: {
            save_global_settings: function () {
                this.$store.dispatch( 'save_global_settings' );
            },
        },
        computed: {
            global_settings: function () {
                return this.$store.getters.global_settings;
            },
            notice: function () {
                return this.$store.getters.notice;
            }
        },
        mounted: function () {
            this.$store.dispatch('get_global_settings');
        }
    }
</script>