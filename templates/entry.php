<template id="neoforms_entry">
	<div>
		<el-card :body-style="{ padding: '0px' }">
			<div class="pt30 pb70 pr30 pl30">
				<div class="bottom clearfix neo_entry_single_view">
                    <table>
                        <tr>
                            <th><h4><?php _e( 'Title', 'neoforms' ); ?> : {{ entry.main.post_title }}</h4></th>
                        </tr>
                        <template v-for="(data, k) in entry.data_fields">
                            <tr>
                                <td><strong>{{ data.label }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ data.value }}</td>
                            </tr>
                        </template>
                        <tr>
                            <td><?php _e( 'Message', 'neoforms' ); ?></td>
                        </tr>
                        <tr>
                            <td>{{ entry.main.post_content }}</td>
                        </tr>
                    </table>
				</div>
			</div>
		</el-card>
	</div>
</template>
<script>
    var neoforms_entry = {
        template: '#neoforms_entry',
        methods: {
            fetchData: function () {
                this.$store.dispatch('get_entry',{id:this.$route.params.id})
            }
        },
        computed: {
            entry: function () {
                return this.$store.getters.entry;
            }
        },
        mounted: function () {
            this.fetchData();
        }
    }
</script>