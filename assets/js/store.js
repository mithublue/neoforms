var all_fields = function (state) {
    //var state = store_obj.state;
    var fields = {};
    for( var k in state.formdata.field_data ) {
        if( state.formdata.field_data[k].type == 'step' ) {
            for ( var row in state.formdata.field_data[k].step_formdata ) {
                if( state.formdata.field_data[k].step_formdata[row].type == 'row' ) {
                    for ( var col in state.formdata.field_data[k].step_formdata[row]['row_formdata'] ) {
                        fields[state.formdata.field_data[k].step_formdata[row]['row_formdata'][col].s.name] = state.formdata.field_data[k].step_formdata[row]['row_formdata'][col].s.name;
                    }
                }
            }
        } else if ( state.formdata.field_data[k].type == 'row' ) {
            for ( var col in state.formdata.field_data[k]['row_formdata'] ) {
                fields[state.formdata.field_data[k]['row_formdata'][col].s.name] = state.formdata.field_data[k]['row_formdata'][col].s.name;
            }
        }
    }
    return fields;
}

var neoforms_stringify  = function (field) {
    var json = btoa(JSON.stringify(field, function(key, value) {
        if (typeof value === "function") {
            return "/Function(" + value.toString() + ")/";
        }
        return value;
    }));
    return json;
};


var neoforms_parse = function (json) {
    var field = JSON.parse(atob(json), function(key, value) {
        if (typeof value === "string" &&
            value.startsWith("/Function(") &&
            value.endsWith(")/")) {
            value = value.substring(10, value.length - 2);
            return eval("(" + value + ")");
        }
        return value;
    });
    return field;
}

var neoforms_reset_fields = function (field) {

    // Convert to JSON using a replacer function to output
    // the string version of a function with /Function(
    // in front and )/ at the end.
    var json = JSON.stringify(field, function(key, value) {
        if (typeof value === "function") {
            return "/Function(" + value.toString() + ")/";
        }
        return value;
    });

    // Convert to an object using a reviver function that
    // recognizes the /Function(...)/ value and converts it
    // into a function via -shudder- `eval`.
    var field = JSON.parse(json, function(key, value) {
        if (typeof value === "string" &&
            value.startsWith("/Function(") &&
            value.endsWith(")/")) {
            value = value.substring(10, value.length - 2);
            return eval("(" + value + ")");
        }
        return value;
    });
    return field;
}

var global_settings = neo_apply_filters( 'global_settings', {} );

/*** Store ***/
var store_obj = {
    state: {
        notice: {
            type: '',
            header: '',
            msg: ''
        },
        field_attr: field_attr,
        form_count: 0,
        entry_count: 0,
        current_page: 0,
        forms: [],
        entries: [],
        form: {},
        entry: {},
        edit_form_id: 0,
        is_editing: true,
        editing_mode: false,
        grids: 24,
        focused_col: '',
        copied_col: '',
        focused_row: '',
        copied_row: '',
        is_show_field_list: '',

        global_settings: global_settings,
        row_template:{
            type: 'row',
            preview: {
                label: 'Row'
            },
            row_formdata: []
        },
        form_settings: neoforms_reset_fields(neoforms_form_settings),
        formdata:{
            form_type: 'contact',
            field_data: []
        }
    },
    getters: {
        field_attr: function (state) {
            return state.field_attr;
        },
        notice: function (state) {
            return state.notice;
        },
        global_settings: function (state) {
            return state.global_settings;
        },
        is_multistep: function (state) {
            return false;
        },
        form_settings: function (state) {
            return state.form_settings;
        },
        form: function (state) {
            return state.form;
        },
        is_editing: function (state) {
            return state.is_editing;
        },
        grids: function (state) {
            return state.grids;
        },
        focused_row: function (state) {
            return state.focused_row;
        },
        focused_col: function (state) {
            return state.focused_col;
        },
        formdata: function (state) {
            return state.formdata;
        },
        field_data: function (state) {
            return state.formdata.field_data;
        },
        is_show_field_list: function (state) {
            return state.is_show_field_list;
        },
        editing_mode: function (state) {
            return state.editing_mode;
        },
        col_formdata: function (state) {
            return state.formdata.field_data[state.focused_row].row_formdata[state.focused_col];
        },
        col_formdata_s: function (state) {
            var col_formdata = state.formdata.field_data[state.focused_row].row_formdata[state.focused_col];
            return Object.assign({}, state.field_attr[col_formdata.preview.name].s, col_formdata.s );
        },
        col_formdata_schema: function (state) {
            var col_formdata = state.formdata.field_data[state.focused_row].row_formdata[state.focused_col];
            return state.field_attr[col_formdata.preview.name].schema;
        },
        //get forms
        forms: function (state) {
            return state.forms;
        },
        entries: function (state) {
            return state.entries;
        },
        entry: function (state) {
            return state.entry;
        },
        form: function (state) {
            return state.form;
        },
        entry: function (state) {
            return state.entry;
        },
        current_page: function (state) {
            return state.current_page;
        },
        form_count: function (state) {
            return state.form_count;
        },
        entry_count: function (state) {
            return state.entry_count;
        },
        copied_row: function (state) {
            return state.copied_row;
        },
        copied_col: function (state) {
            return state.copied_col;
        }
    },
    mutations: {
        //
        set_is_editing: function (state, {}) {
            state.is_editing = true;
        },
        unset_is_editing: function (state, {}) {
            state.focused_col = '';
            state.focused_row = '';
            state.editing_mode = false;
            state.is_editing = false;
        },
        defocus_row: function (state, {focused_row}) {
            if( state.focused_row !== focused_row ) return;
            if( state.editing_mode ) return;
            state.focused_row = '';
        },
        defocus_col: function (state, {focused_col}) {
            if( state.focused_col !== focused_col ) return;
            if( state.editing_mode ) return;
            state.focused_col = '';
        },
        make_focused_row: function (state, {focused_row}) {
            if( state.editing_mode ) return;
            state.focused_row = focused_row;
        },
        make_focused_col: function (state, {focused_col}) {
            if( state.editing_mode ) return;
            state.focused_col = focused_col;
        },
        add_row: function (state, {target_row}) {
            if( !target_row ) target_row = 0;
            state.formdata.field_data.splice(target_row,0, neoforms_reset_fields( state.row_template ) );
        },
        remove_row: function (state, {target_row}) {
            state.formdata.field_data.splice(target_row,1);
        },
        add_field: function (state,{field,target_row}) {
            state.formdata.field_data[target_row].row_formdata.push( neoforms_reset_fields( field ) );
        },
        remove_field: function (state, {}) {
            state.formdata.field_data[state.focused_row].row_formdata.splice(state.focused_col,1);
        },
        show_field_list: function (state, {target_row}) {
            state.is_show_field_list = target_row;
        },
        hide_field_list: function (state,{}) {
            state.is_show_field_list = '';
        },
        resize_col: function (state, {col}) {
            state.formdata.field_data[state.focused_row].row_formdata[state.focused_col].settings.atts.span = col;
        },
        set_edit_mode: function (state,{}) {
            state.editing_mode = true;
        },
        unset_edit_mode: function (state,{}) {
            state.editing_mode = false;
        },
        populate_form_type_data: function (state, {form_data,form_title}) {
            var _this = this;
            state.form_title = form_title;
            state.formdata = neoforms_reset_fields(form_data);
        },
        update_form: function (state, {status, form_id, callback}) {
            var edit_form_id = ( typeof form_id !== 'undefined' ) ? form_id : ( state.edit_form_id ? state.edit_form_id : 0);

            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_update_form',
                    status: status,
                    title: state.form.post_title,
                    form_id: edit_form_id,
                    formdata: neoforms_stringify(state.formdata),
                    form_settings: neoforms_stringify(state.form_settings)
                },
                function (data) {
                    if(data.success) {
                        if( typeof callback == 'function' ) {
                            callback();
                        } else {
                            router.push('/forms/form/' + data.data.id + '/edit');
                        }
                        state.notice = {
                            type: 'success',
                            header: 'Success',
                            msg: 'Form Saved !'
                        };
                    } else {
                        state.notice = {
                            type: 'error',
                            header: 'Error',
                            msg: 'Something went wrong !'
                        };
                    }
                    setTimeout(function () {
                        state.notice = {
                            type: '',
                            header: '',
                            msg: ''
                        }
                    },3000);
                }
            )
        },
        update_entry: function (state, {status, entry_id, callback}) {
            if( typeof entry_id === 'undefined' ) return;
            var edit_entry_id = ( typeof entry_id !== 'undefined' ) ? entry_id : 0;

            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_update_entry',
                    status: status,
                    entry_id: edit_entry_id,
                },
                function (data) {
                    if(data.success) {
                        if( typeof callback == 'function' ) {
                            callback();
                        }
                        state.notice = {
                            type: 'success',
                            header: 'Success',
                            msg: ''
                        };
                    } else {
                        state.notice = {
                            type: 'error',
                            header: 'Error',
                            msg: 'Something went wrong !'
                        };
                    }
                    setTimeout(function () {
                        state.notice = {
                            type: '',
                            header: '',
                            msg: ''
                        }
                    },3000);
                }
            )
        },
        get_forms: function (state, {page, status}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_get_forms',
                    page: page,
                    status: status
                },
                function (data) {
                    if(data.success) {
                        //state.
                        state.current_page = page;
                        state.forms = data.data.forms;
                        state.form_count = data.data.counts
                    }
                }
            )
        },
        get_entries: function (state, {page, status, form_type}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_get_entries',
                    page: page,
                    status: status,
                    form_type: form_type,
                },
                function (data) {
                    if(data.success) {
                        //state.
                        state.current_page = page;
                        state.entries = data.data.entries;
                        state.entry_count = data.data.counts
                    }
                }
            )
        },
        get_form: function (state, {id, callback}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_get_form',
                    id: id
                },
                function (data) {
                    if(data.success) {
                        state.form = data.data.form;
                        state.edit_form_id = state.form.ID;
                        state.formdata = data.data.formdata ? neoforms_parse( data.data.formdata ) : [];

                        if( data.data.form_settings ) {
                            data.data.form_settings = neoforms_parse( data.data.form_settings );
                        }

                        for( tabname in data.data.form_settings ) {
                            state.form_settings[tabname].s = data.data.form_settings[tabname].s;
                        }

                        if( typeof callback === 'function' ) {
                            callback();
                        }
                        //state.form_settings.s = data.data.form_settings.s ? data.data.form_settings.s : {};
                    }
                }
            )
        },
        get_entry: function (state, {id}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_get_entry',
                    id: id
                },
                function (data) {
                    if(data.success) {
                        state.entry = data.data.entry;
                    }
                }
            )
        },
        delete_form: function (state, {form_id,soft}) {
            var trashDelete;

            if( typeof soft === 'undefined' ) {
                soft = 1;
            }
            trashDelete = soft;

            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_delete_form',
                    form_id: form_id,
                    trashDelete: trashDelete
                },
                function (data) {
                    if(data.success) {
                        var item = state.forms.filter(function (item,index) {
                            return item.ID == form_id
                        });

                        if( item.length ) {
                            state.forms.splice(state.forms.indexOf(item[0]),1);
                        }
                    }
                }
            )
        },
        delete_entry: function (state, {id, soft}) {
            var trashDelete;
            if( typeof soft === 'undefined' ) {
                soft = 1;
            }
            trashDelete = soft;

            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_delete_entry',
                    id: id,
                    trashDelete: trashDelete
                },
                function (data) {
                    if(data.success) {
                        var item = state.entries.filter(function (item,index) {
                            return item.ID == id
                        });

                        if( item.length ) {
                            state.entries.splice(state.entries.indexOf(item[0]),1);
                        }
                    }
                }
            )
        },
        reset_all: function (state, {}) {
            state.focused_row = '';
            state.focused_col = '';
            state.focused_step = '';
            state.form = {};
            state.forms = [];
            state.edit_form_id = 0;
            state.is_show_field_list = '';
            state.editing_mode = false;
            //state.form_settings = neoforms_reset_fields(neoforms_form_settings);
        },
        save_global_settings: function (state, {}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_save_global_settings',
                    global_settings: neoforms_stringify(state.global_settings)
                },
                function (data) {
                    if(data.success) {
                        state.notice = {
                            type: 'success',
                            header: typeof data.data.header !== 'undefined' ? data.data.header : 'Success',
                            msg: data.data.msg
                        };
                    } else {
                        state.notice = {
                            type: 'error',
                            header: typeof data.data.header !== 'undefined' ? data.data.header : 'Error',
                            msg: data.data.msg
                        };
                    }
                    setTimeout(function () {
                        state.notice = {
                            type: '',
                            header: '',
                            msg: ''
                        }
                    },3000);
                }
            )
        },
        get_global_settings: function (state, {}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_get_global_settings'
                },
                function (data) {
                    if(data.success) {
                        state.global_settings = neoforms_parse(data.data.global_settings)
                    }
                }
            )
        },
        unset_notice: function (state, {}) {
            state.notice = {
                header: '',
                type: '',
                msg: ''
            };
        },
        set_field_data:function (state, {value}) {
            state.field_data = value;
        },
        clone_row: function (state, {}) {
            state.formdata.field_data.splice(state.focused_row,0,neoforms_reset_fields(state.formdata.field_data[state.focused_row]));
        },
        clone_col: function (state, {}) {
            state.formdata.field_data[state.focused_row].row_formdata.splice( state.focused_col, 0, neoforms_reset_fields( state.formdata.field_data[state.focused_row].row_formdata[state.focused_col] ) );
        },
        delete_fields: function (state, {}) {
            state.formdata.field_data = [];
        },
        copy_row: function (state, {row_number}) {
            state.copied_row = neoforms_reset_fields( state.formdata.field_data[row_number] );
        },
        paste_row: function (state, {row_number}) {
            state.formdata.field_data.splice( row_number,0, state.copied_row );
            state.copied_row = '';
        },
        copy_col: function (state, {field_data}) {
            state.copied_col = neoforms_reset_fields( field_data );
        },
        paste_col: function (state, {row_number}) {
            state.formdata.field_data[state.focused_row].row_formdata.push(state.copied_col);
            state.copied_col = '';
        },
        set_form_type: function (state, {form_type}) {
            state.form_settings.form_settings.s.form_type = form_type;
        },
        bulk_delete: function (state, {soft,ids,callback}) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'neoforms_buck_delete',
                    soft: soft,
                    ids: ids
                },
                function (data) {
                    if( data.success ) {
                        if( typeof callback !== 'undefined' ) {
                            callback();
                        }
                    }
                }
            )
        }
    },
    actions: {
        import_fields: function (context, {from,to}) {
            //pro
        },
        delete_fields: function (context) {
            context.commit('delete_fields',{});
        },
        set_is_editing: function (context) {
            context.commit('set_is_editing',{});
        },
        unset_is_editing: function (context) {
            context.commit('unset_is_editing', {});
        },
        defocus_col: function (context, {focused_col}) {
            context.commit('defocus_col', {focused_col:focused_col});
        },
        defocus_row: function (context, {focused_row}) {
            context.commit('defocus_row', {focused_row:focused_row});
        },
        make_focused_row: function (context,{focused_row}) {
            context.commit('make_focused_row', {focused_row: focused_row});
        },
        make_focused_col: function (context, {focused_col}) {
            context.commit('make_focused_col', {focused_col: focused_col});
        },
        show_field_list: function (context, {target_row}) {
            context.commit('show_field_list', {target_row: target_row});
        },
        hide_field_list: function (context) {
            context.commit('show_field_list',{});
        },
        //
        add_row: function (context, {target_row}) {
            context.commit('add_row', {target_row: target_row});
        },
        remove_row: function (context, {target_row}) {
            context.commit('remove_row', {target_row: target_row});
        },
        add_field: function (context, {field,target_row}) {
            context.commit('add_field', {field:field,target_row:target_row});
        },
        remove_field: function (context) {
            context.commit('remove_field', {});
            context.commit('unset_edit_mode', {});
        },
        resize_col: function (context, {col}) {
            context.commit('resize_col', {col:col});
        },
        set_edit_mode: function (context) {
            context.commit('set_edit_mode', {});
        },
        unset_edit_mode: function (context) {
            context.commit('unset_edit_mode', {});
        },
        populate_form_type_data:  function (context, {form_data,form_title}) {
            context.commit('populate_form_type_data',{form_data:form_data,form_title:form_title});
        },
        change_form_title: function (context, {form_title}) {
            context.commit('change_form_title',{form_title:form_title});
        },
        update_form: function (context, {status, form_id, callback}) {
            context.commit('update_form',{status:status, form_id: form_id, callback: callback});
        },
        update_entry: function (context, {status, entry_id, callback}) {
            context.commit('update_entry',{status:status, entry_id: entry_id, callback: callback});
        },
        //get all forms
        get_forms: function (context, {page, status}) {
            context.commit('get_forms',{page:page, status: status});
        },
        get_entries: function (context, {page, status, form_type}) {
            context.commit('get_entries',{page:page, status: status, form_type: form_type});
        },
        //get form
        get_form: function (context, {id, callback}) {
            context.commit('get_form',{id:id, callback: callback});
        },
        get_entry: function (context, {id}) {
            context.commit('get_entry',{id:id});
        },
        delete_form: function (context, {form_id, soft}) {
            context.commit('delete_form',{form_id:form_id, soft: soft});
        },
        reset_all: function (context) {
            context.commit('reset_all', {});
        },
        //save global settings
        save_global_settings: function (context) {
            context.commit('save_global_settings', {});
        },
        get_global_settings: function (context) {
            context.commit('get_global_settings',{});
        },
        //unset notice
        unset_notice: function (context) {
            context.commit('unset_notice',{})
        },
        clone_row: function (context) {
            context.commit('clone_row',{})
        },
        clone_col: function (context) {
            context.commit('clone_col',{});
        },
        copy_row: function (context,{row_number}) {
            context.commit('copy_row',{row_number:row_number});
        },
        paste_row: function (context, {row_number}) {
            context.commit('paste_row',{row_number:row_number});
        },
        paste_col: function (context, {row_number}) {
            context.commit('paste_col',{row_number:row_number});
        },
        copy_col: function (context, {field_data}) {
            context.commit('copy_col',{field_data:field_data});
        },
        delete_entry: function (context, {id, soft}) {
            context.commit('delete_entry',{id:id, soft: soft});
        },
        set_form_type: function (context, {form_type}) {
            context.commit('set_form_type',{form_type:form_type});
        },
        bulk_delete: function (context, {soft,ids,callback}) {
            context.commit('bulk_delete',{soft:soft,ids:ids,callback:callback});
        }
    }
}

if( typeof store_obj_pro !== 'undefined' ) {
    store_obj.state = Object.assign({},store_obj.state,store_obj_pro.state);
    store_obj.getters = Object.assign({},store_obj.getters,store_obj_pro.getters);
    store_obj.mutations = Object.assign({},store_obj.mutations,store_obj_pro.mutations);
    store_obj.actions = Object.assign({},store_obj.actions,store_obj_pro.actions);
}

var store = new Vuex.Store(store_obj);
/*** Store ends **/

