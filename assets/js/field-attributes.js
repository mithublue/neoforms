var field_attr = {
    //common
    common: {
        s: {
            required: false,
            name: '',
            label: 'Label',
            id: '',
            class: ''
        },
        schema:{
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'required',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Required',
                        options : {
                            true : 'Required',
                        }
                    },
                    {
                        model: "name",
                        type: "input",
                        inputType: "text",
                        label: "Field Name",
                    },
                    {
                        model: "label",
                        type: "input",
                        inputType: "text",
                        label: "Label",
                    },
                    {
                        model: "id",
                        type: "input",
                        inputType: "text",
                        label: "Id",
                    },
                    {
                        model: "class",
                        type: "input",
                        inputType: "text",
                        label: "Class",
                    }
                ]
            }
        }
    },
    //text
    text: {
        s: {
            placeholder: '',
            maxlength: '',
            value: '',
        },
        schema: {
            general: {
                label: 'General',
                fields:[]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: "placeholder",
                        type: "input",
                        inputType: "text",
                        label: "Placeholder",
                    },
                    {
                        model: "maxlength",
                        type: "input",
                        inputType: "number",
                        label: "Maxlength",
                        change: function (model) {

                        }
                    },
                    {
                        model: "value",
                        type: "input",
                        inputType: "text",
                        label: "Default Value"
                    }
                ]
            }
        }
    },
    //textarea
    textarea: {
        s: {
            placeholder: '',
            maxlength: '',
            value: ''
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: "value",
                        type: "textarea",
                        label: "Default Text",
                    },
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: "placeholder",
                        type: "input",
                        inputType: "text",
                        label: "Placeholder",
                    },
                    {
                        model: "maxlength",
                        type: "input",
                        inputType: "number",
                        label: "Maxlength",
                    }
                ]
            }
        }
    },
    //number
    number: {
        s: {
            label: 'Number',
            value: '3',
            min: 0,
            max: 10,
            step: 1,
            size: 'small', //large
            controls: true
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        label: 'Default Value',
                        type: 'input',
                        inputType: 'number',
                        desc: 'Initial number to display',
                        change: function (model) {
                            model.value = Number(model.value);
                        }
                    },
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'min',
                        label: 'Minimum Input',
                        type: 'input',
                        inputType: 'number',
                        desc: 'Minmum input that a user can provide',
                        change: function (model) {
                            model.min = Number(model.min);
                        }
                    },
                    {
                        model: 'max',
                        label: 'Maximum Input',
                        type: 'input',
                        inputType: 'number',
                        desc: 'Maximum input that a user can provide',
                        change: function (model) {
                            model.max = Number(model.max);
                        }
                    },
                    {
                        model: 'step',
                        label: 'Step of Increment/Decrement',
                        type: 'input',
                        inputType: 'text',
                        desc: 'Step of Increment/Decrement'
                    },
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        options : {
                            mini : 'Mini',
                            medium : 'Medium',
                            small : 'Small',
                            large : 'Large'
                        }
                    },
                    {
                        model: 'controls',
                        type: 'input',
                        inputType: 'checkbox',
                        label: 'Has Controls',
                        options: {
                            true: 'Check this if you want this field to have controls.'
                        }
                    }
                ]
            }
        }
    },
    //radio
    radio: {
        s: {
            label: 'Radio',//
            border: false,
            size: 'medium', //medium,small,mini
            is_selected: false,
            selected_val: '',
            value: 'value',
            option_label: 'Option Label'
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        type : 'input',
                        inputType : 'text',
                        label : 'Value',
                        desc: 'Value for this field',
                        change: function (model) {
                            model.selected_val = '';
                            model.is_selected = false;
                        }
                    },
                    {
                        model: 'option_label',
                        type : 'input',
                        inputType : 'text',
                        label : 'Option Label',
                        desc: 'Label for this field'
                    },
                    {
                        model: 'is_selected',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Is selected',
                        options : {
                            true : 'Check this if you want this field selected.',
                        },
                        change: function (model) {
                            if( model.is_selected ) {
                                model.selected_val = model.value;
                            } else {
                                model.selected_val = '';
                            }
                        }
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'border',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Bordered',
                        desc: 'Check this if you want this field to have border',
                        options : {
                            true : 'Apply Border',
                        },
                        change: function (model) {

                        }
                    },
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        options : {
                            medium : 'Medium',
                            small : 'Small',
                            mini : 'Mini'
                        }
                    }
                ]
            }
        }
    },
    //radio_group
    radio_group: {
        s:{
            label: 'Radio Group',//
            selected_val: '',
            options: [{
                value: '',
                option_label: 'Radio Button',
                is_selected: false
            }],
            //advanced
            border: true,
            size: 'medium', //medium,small,mini
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'selected_val',
                        type: 'input',
                        inputType: 'text',
                        desc: 'Write the value here from the options list, if you want any value to be selected.'
                    },
                    {
                        model: 'options',
                        type: 'repeatable',
                        label: 'Options',
                        desc: 'Add radio options',
                        group: [
                            {
                                model: 'option_label',
                                label: 'Option Label',
                                type: 'input',
                                inputType: 'text'
                            },
                            {
                                model: 'value',
                                label: 'Option Value',
                                type: 'input',
                                inputType: 'text'
                            }
                        ]
                    },
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'border',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Bordered',
                        desc: 'Check this if you want this field to have border',
                        options : {
                            true : 'Apply Border',
                        }
                    },
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        options : {
                            medium : 'Medium',
                            small : 'Small',
                            mini : 'Mini'
                        }
                    }
                ]
            }
        }
    },
    //option_group pro
    option_group: {
        s: {},
        schema: {
            general: {
                label: 'General',
                fields: []
            },
            advanced: {
                label: 'Advanced',
                fields: []
            }
        }
    },
    //checkbox
    checkbox: {
        s: {
            label: 'Checkbox',//
            value: 'true',
            option_label: 'Checkbox Label',
            checked: false,
            selected_val: '',
            //advanced
            border: true,
            size: 'medium', //medium,small,mini
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        type: 'input',
                        inputType: 'text',
                        label: 'Value',
                        desc: 'Value for this field',
                        change: function (model) {
                            model.selected_val = '';
                        }
                    },
                    {
                        model: 'option_label',
                        type : 'input',
                        inputType : 'text',
                        label : 'Option Label',
                        desc: 'Label for this field'
                    },
                    {
                        model: 'checked',
                        type: 'input',
                        inputType: 'checkbox',
                        label: 'Checked',
                        options: {
                            true: 'Make it checked by default'
                        },
                        change: function (model) {
                            if( model.checked ) {
                                model.selected_val = model.value;
                            } else {
                                model.selected_val = '';
                            }
                        }
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'border',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Bordered',
                        desc: 'Check this if you want this field to have border',
                        options : {
                            true : 'Apply Border',
                        }
                    },
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        multiple: false,
                        options : {
                            medium : 'Medium',
                            small : 'Small',
                            mini : 'Mini'
                        }
                    }
                ]
            }

        }
    },
    //checkbox group
    checkbox_group: {
        s: {
            label: 'Checkbox Group',//
            options: [{
                label: 'Option A',
                value: 'value_a',
                is_selected: false
            }],
            sel_values: [],
            //advanced
            size: 'medium', //medium,small,mini
            maxnum: '',
            boder: true
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'options',
                        type : 'repeatable',
                        label : 'Add Option',
                        group: [
                            {
                                model: 'label',
                                label: 'Option Label',
                                type: 'input',
                                inputType: 'text'
                            },
                            {
                                model: 'value',
                                label: 'Option Value',
                                type: 'input',
                                inputType: 'text'
                            },
                            {
                                model: 'is_selected',
                                label: 'Is selected ? ',
                                type: 'input',
                                inputType: 'checkbox',
                                options: {
                                    true: 'Keep this option selected by default',
                                },
                                change: function (model,parent_model) {
                                    if( model.is_selected ) {
                                        parent_model.sel_values.push(model.value);
                                    } else {
                                        if( parent_model.sel_values.indexOf(model.value) !== -1 ) {
                                            parent_model.sel_values.splice(parent_model.sel_values.indexOf(model.value),1);
                                        }
                                    }
                                }
                            }
                        ]
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        multiple: false,
                        options : {
                            large : 'Large',
                            medium : 'Medium',
                            small : 'Small',
                            mini : 'Mini'
                        }
                    },
                    {
                        model: 'maxnum',
                        type: 'input',
                        inputType: 'number',
                        label: 'Maximum Options to Select',
                        desc: 'Maximum number of option to let user select, leave it if you don\'t want to limit in selecting option',
                        change: function (model) {
                            model.maxnum = Number(model.maxnum);
                        }
                    },
                    {
                        model: 'border',
                        type : 'input',
                        inputType : 'checkbox',
                        label : 'Bordered',
                        desc: 'Check this if you want this field to have border',
                        options : {
                            true : 'Apply Border',
                        }
                    }
                ]
            }
        }
    },
    //select
    select: {
        s: {
            options: [{
                label: '',
                value: '',
            }],
            selected_val: '',
            size: 'small', //large,small,mini
            clearable: true,
            placeholder: ''
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'selected_val',
                        type: 'input',
                        inputType: 'text',
                        label: 'Default value',
                        desc: 'The value which will be kept selected by default'
                    },
                    //options
                    {
                        model: 'options',
                        type: 'repeatable',
                        label: 'Add Options',
                        desc: 'Add option to this field',
                        group: [
                            {
                                model: 'label',
                                label: 'Option Label',
                                type: 'input',
                                inputType: 'text'
                            },
                            {
                                model: 'value',
                                label: 'Option Value',
                                type: 'input',
                                inputType: 'text'
                            }
                        ]
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'placeholder',
                        label: 'Placeholder',
                        desc: 'The placeholder text for the field',
                        type: 'input',
                        inputType: 'text'
                    },
                    {
                        model: 'size',
                        type: 'select',
                        label: 'Size',
                        desc: 'Size of this field',
                        options: {
                            large: 'Large',
                            medium: 'Medium',
                            small: 'Small',
                            mini: 'Mini',
                        }
                    }
                ]
            }
        }
    },
    //multiselect pro
    multiselect: {
        s: {},
        schema: {
            general: {
                label: 'General',
                fields: []
            },
            advanced: {
                label: 'Advanced',
                fields: []
            }
        }
    },
    //website_url
    website_url: {
        s: {
            placeholder: 'Website URL',
            value: '',
            maxlength: ''
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        label: 'Default Value',
                        type: 'input',
                        inputType: 'text'
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'placeholder',
                        label: 'Placeholder',
                        type: 'input',
                        inputType: 'text'
                    },
                    {
                        model: 'maxlength',
                        label: 'Maximum Length',
                        type: 'input',
                        inputType: 'number',
                        change: function (model) {
                            model.maxlength = Number( model.maxlength );
                        }
                    }
                ]
            }

        }
    },
    password: {
        s: {
            value: '12345',
            maxlength : 100,
            minlength : 3,
            retype_password: false
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        label: 'Default Value',
                        type: 'input',
                        inputType: 'text'
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'maxlength',
                        label: 'Password Length Limit',
                        type: 'input',
                        inputType: 'number'
                    },
                    {
                        model: 'minlength',
                        label: 'Password Minimum Length',
                        type: 'input',
                        inputType: 'number'
                    },
                    {
                        model: 'retype_password',
                        type: 'input',
                        inputType: 'checkbox',
                        options: {
                            true: 'Retype Password'
                        }
                    }
                ]
            }
        }
    },
    //email_address
    email_address: {
        s: {
            value: '',
            placeholder: 'Email address',
            maxlength : 100,
            unique_entry: false,
        },
        schema:{
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        label: 'Default Value',
                        type: 'input',
                        inputType: 'text'
                    }
                ]
            },
            advanced: {
                label: 'Advanced',
                fields: [
                    {
                        model: 'placeholder',
                        label: 'Placeholder',
                        type: 'input',
                        inputType: 'text'
                    },
                    {
                        model: 'maxlength',
                        label: 'Email Length Limit',
                        type: 'input',
                        inputType: 'number'
                    },
                    {
                        model: 'unique_entry',
                        type: 'input',
                        inputType: 'checkbox',
                        label: 'Unique Entry',
                        options: {
                            true: 'Check this if you want the user to enter unique email address that is not exisiting in your database'
                        }
                    }
                ]
            }
        }
    },
    //hidden_field
    hidden_field: {
        s: {
            value: ''
        },
        schema: {
            general: {
                label: 'General',
                fields: [
                    {
                        model: 'value',
                        label: 'Value',
                        type: 'input',
                        inputType: 'text'
                    }
                ]
            }

        }
    }
};

field_attr = neo_apply_filters( 'neo_field_attr', field_attr );

for ( var fieldname in field_attr ) {

    if( fieldname !== 'common' ) {
        field_attr[fieldname].s = Object.assign({},field_attr['common'].s,field_attr[fieldname].s);

        for( tabname in field_attr[fieldname].schema ) {

            if( typeof field_attr['common'].schema[tabname] !== 'undefined' ) {

                var common_fields = neoforms_reset_fields(field_attr['common'].schema[tabname].fields);
                if ( typeof field_attr[fieldname].schema[tabname].prevent !== 'undefined' ) {
                    for ( k in field_attr[fieldname].schema[tabname].prevent ) {
                        for ( var p in common_fields ) {
                            if( common_fields[p].model == field_attr[fieldname].schema[tabname].prevent[k] ) {
                                common_fields.splice( p, 1 );
                                break;
                            }
                        }
                    }
                }

                field_attr[fieldname].schema[tabname].fields = common_fields.concat(field_attr[fieldname].schema[tabname].fields);
            }
        }
    }
}