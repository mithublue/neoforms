<template id="neoforms_edit_form">
    <div>

    </div>
</template>
<script>
    var neoforms_edit_form = {
        template: '#neoforms_edit_form',
        computed: {
            form: function () {
                return this.$store.getters.form;
            }
        },
        mounted: function () {

        }
    }
</script>