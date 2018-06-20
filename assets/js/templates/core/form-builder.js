Vue.component('vue_form_builder',{
    template: '#VueFormBuilder',
    props: {
        model: {
            type: Object
        },
        schema: {
            type: Array
        },
        parent_model: {
            type: Object,
            default: function () {
                return {};
            }
        }
    },
    data: function () {
        return {
            items : {},
            default_field : {
                model: '',
                type: 'input',
                inputType: 'text',
                label : '',
                maxlength: '',
                placeholder: "",
                class: '',
                wrapperclass: '',
                id: '',
                multiple: false,
                desc: '',
                add_button_label: 'Add',
                click: function (model) {

                },
                dblclick: function (model) {

                },
                change: function (model,parent_model) {
                },
                'visible' : function (model) {
                    return true;
                }
            }
        }
    },
    methods: {
        removeItem: function (model,k) {
            model.splice(k,1);
        },
        addItem: function (model,schema) {
            var template  = {};
            for( var k in schema ) {
                switch (schema[k].type) {
                    case 'repeatable' :
                        template[schema[k].model] = [];
                        break;
                    default :
                        template[schema[k].model] = '';
                        break;
                }

            }
            model.push(template);
        },
        moveItemUp: function (model, k) {
            if( k <= 0 ) return;
            var temp_item = model[k];
            model.splice(k,1);
            model.splice((k-1),0,temp_item);
        },
        moveItemDown: function (model, k) {
            if( k >= (model.length - 1) ) return;
            var temp_item = model[k];
            model.splice(k,1);
            model.splice(k+1,0,temp_item);
        }
    },
    computed: {
        native_schema : function () {
            for( var k in this.schema ) {
                this.items[k] = Object.assign({},this.default_field,this.schema[k]);
            }

            return this.items;
        }
    }

});