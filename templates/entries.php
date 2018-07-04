<template id="neoforms_entries">
	<div>
		<?php $post_statuses = get_post_statuses(); ?>
		<div class="mb10 oh">
			<div class="alignright">
				<a :href="'#/forms/entries/' + form_type + '/' + status + '/page/' + ( pagenum > 1 ? pagenum - 1 : pagenum )" class="el-button el-button--mini"><i class="el-icon-arrow-left"></i></a>
				<a :href="'#/forms/entries/' + form_type + '/' + status + '/page/' + nextpage" class="el-button el-button--mini"><i class="el-icon-arrow-right"></i></a>
			</div>
		</div>
		<div class="mb10 oh">
            <div>
                <template v-if="selected_ids.length">
                    <template v-if="status != 'trash'">
                        <a @click="bulk_delete(1)" href="javascript:" class="el-button el-button--mini el-button--danger"><?php _e('Move to Trash','neoforms'); ?></a>
                    </template>
                    <template v-else>
                        <a @click="bulk_delete(0)" href="javascript:" class="el-button el-button--mini el-button--danger"><?php _e('Bulk Delete','neoforms'); ?></a>
                    </template>
                </template>
                <a @click="select_all()" href="javascript:" class="el-button el-button--mini el-button--default"><?php _e( 'Select All', 'neoforms' ); ?></a>
                <a v-if="selected_ids.length" @click="deselect_all()" href="javascript:" class="el-button el-button--mini el-button--default"><?php _e( 'Deselect All', 'neoforms' ); ?></a>
            </div>
			<ul class="subsubsub">
				<li class="all" v-for="(sts, key) in post_statuses">
					<a :href="'#/forms/entries/' + form_type + '/' + key + '/page/1'" aria-current="page" :class="{current: status == key}">{{ sts }} </a> |
				</li>
				<li>
					<a :href="'#/forms/entries/' + form_type + '/trash/page/1'" aria-current="page" :class="{current: status == 'trash'}"> <?php _e( 'Trash', 'neoforms' ); ?> </a>
				</li>
			</ul>
		</div>
		<el-table
			:data="entries"
			style="width: 100%">
            <el-table-column
                    label="">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">
                        <input type="checkbox" v-model="selected_ids" :value="scope.row.ID">
                    </span>
                </template>
            </el-table-column>
            <el-table-column
				label="Title">
				<template slot-scope="scope">
					<span style="margin-left: 10px">{{ scope.row.post_title }}</span>
				</template>
			</el-table-column>
			<el-table-column
				label="Operations">
				<template slot-scope="scope">
					<template v-if="status !== 'trash'">
						<a @click=";" :href="'#/forms/entries/' + form_type + '/view/' + scope.row.ID" class="el-button el-button--mini"><i class="el-icon el-icon-view"></i> <?php _e('View','neoforms'); ?></a>
						<a @click="confirmationVisible = true;toDelete = scope.row.ID;" href="javascript:" class="el-button el-button--mini el-button--danger"><?php _e('Delete','neoforms'); ?></a>
					</template>
					<template v-if="status === 'trash'">
						<a href="javascript:" @click="update_entry('publish',scope.row.ID)" class="el-button el-button--mini"><?php _e( 'Publish', 'neoforms' ); ?></a>
						<a href="javascript:" @click="update_entry('draft',scope.row.ID)" class="el-button el-button--mini"><?php _e( 'draft', 'neoforms' ); ?></a>
						<a @click="confirmationVisible = true;toDelete = scope.row.ID;" href="javascript:" class="el-button el-button--mini el-button--danger"><?php _e('Delete Permanently','neoforms'); ?></a>
					</template>
				</template>
			</el-table-column>
		</el-table>
		<div class="textright mt10">
			<a :href="'#/forms/entries/' + form_type + '/' + status + '/page/' + ( pagenum > 1 ? pagenum - 1 : pagenum )" class="el-button el-button--mini"><i class="el-icon-arrow-left"></i></a>
			<a :href="'#/forms/entries/' + form_type + '/' + status + '/page/' + nextpage" class="el-button el-button--mini"><i class="el-icon-arrow-right"></i></a>
		</div>
		<el-dialog
			title="<?php _e( 'Confirm', 'neoforms' ); ?>"
			:visible.sync="confirmationVisible"
			width="30%">
			<span><?php _e( 'Are you sure to delete this item ?', 'neoforms' ); ?></span>
			<span slot="footer" class="dialog-footer">
                <a v-if="status !== 'trash'" class="el-button el-button--danger" href="javascript:" type="primary" @click="confirmationVisible = false; delete_entry(1)"><?php _e( 'Confirm', 'neoforms' ); ?></a>
                <a v-if="status === 'trash'" class="el-button el-button--danger" href="javascript:" type="primary" @click="confirmationVisible = false; delete_entry(0)"><?php _e( 'Confirm', 'neoforms' ); ?></a>
                <el-button @click="confirmationVisible = false"><?php _e( 'Cancel', 'neoforms' ); ?></el-button>
            </span>
		</el-dialog>
	</div>
</template>
<script>
    var neoforms_entries = {
        template: '#neoforms_entries',
        data:  function () {
            return {
                selected_ids: [],
                toDelete: 0,
                confirmationVisible: false,
                post_statuses: JSON.parse('<?php echo json_encode($post_statuses); ?>'),
            }
        },
        watch: {
            // call again the method if the route changes
            $route: function (to, from){
                this.fetchData();
            }
        },
        methods: {
            deselect_all:function () {
                this.selected_ids = [];
            },
            select_all: function () {
                for( var k in this.entries ) {
                    this.selected_ids.push(this.entries[k].ID);
                }
            },
            bulk_delete: function (soft) {
                var _this = this;
                var selected_ids = JSON.stringify(this.selected_ids);
                this.$store.dispatch('bulk_delete',{soft:soft, ids: selected_ids, callback: function () {
                    _this.fetchData();
                } } );
                this.selected_ids = [];
            },
            update_entry: function (status,id) {
                var _this = this;
                this.$store.dispatch('update_entry',{status:status,entry_id: id,callback:function () {
                    router.push('/forms/entries/' + _this.$route.params.form_type + '/browse');
                }});
            },
            delete_entry: function (trashDelete) {
                if( !this.toDelete ) return;
                this.$store.dispatch('delete_entry', {id: this.toDelete,soft:typeof trashDelete !== 'undefined' ? trashDelete : 1});
            },
            fetchData: function () {
                this.$store.dispatch('get_entries',{page:this.pagenum,status: this.status,form_type: this.$route.params.form_type});
            }
        },
        computed: {
            entries: function () {
                return this.$store.getters.entries;
            },
            status: function () {
                return typeof this.$route.params.status !== 'undefined' ? this.$route.params.status : 'publish'
            },
            pagenum : function () {
                return typeof this.$route.params.page !== 'undefined' ? this.$route.params.page : 1
            },
            nextpage: function () {
                return parseInt(this.pagenum) + 1;
            },
            current_page: function () {
                return this.$store.getters.current_page;
            },
            entry_count: function () {
                return this.$store.getters.entry_count;
            },
            entries: function () {
                return this.$store.getters.entries;
            },
            form_type: function () {
                return this.$route.params.form_type;
            }
        },
        mounted: function () {
            this.$store.dispatch('get_entries',{page:this.pagenum,status: this.status, form_type: this.$route.params.form_type});
        }
    }
</script>
<!---->