var neoforms_form_type_data = {
    blank_form: {
        label: 'Blank Form',
        form_type: '',
        field_data: []
    },
    contact: {
        label: 'Contact Form',
        form_type: 'contact',
        field_data: [
            {
                type: 'row',
                preview: {
                    label: 'Row'
                },
                row_formdata: [
                    {
                        type: 'input',
                        inputType: 'text',
                        preview: {
                            'label': 'Text',
                            name: 'text'
                        },
                        s:{
                            required: false,
                            name: 'name',
                            label: 'Name',
                            id: '',
                            class: '',
                            placeholder: '',
                            maxlength: '',
                            value: '',
                            has_relation: false,
                            relation: [{
                                field: '',
                                value : '',
                                relation_type: 'and'
                            }],
                        },
                        settings:{
                            atts: {
                                span: 12
                            }
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
                                        label: "Maxlength"
                                    },

                                    {
                                        model: 'has_relation',
                                        type: 'input',
                                        inputType: 'checkbox',
                                        options : {
                                            true : 'Has Relation',
                                        },
                                        change: function (model) {
                                            console.log(model);
                                        }
                                    },
                                    {
                                        model: 'relation',
                                        type : 'repeatable',
                                        label : 'This field will be visible if ...',
                                        group: [
                                            {
                                                model: 'field',
                                                label: 'The value of the field',
                                                type: 'select',
                                                options: {},
                                                change: function (model) {
                                                }
                                            },
                                            {
                                                model: 'value',
                                                label: 'Is ',
                                                type: 'input',
                                                inputType: 'text'
                                            },
                                            {
                                                model: 'relation_type',
                                                label: 'And/Or',
                                                type: 'select',
                                                options: {
                                                    or: 'OR',
                                                    and: 'AND'
                                                }
                                            }
                                        ],
                                        visible: function (model) {
                                            return model.has_relation === true;
                                        }
                                    }
                                ]
                            }
                        }
                    },
                    {
                        type: 'input',
                        inputType: 'text',
                        preview: {
                            'label': 'Text',
                            name: 'text'
                        },
                        s:{
                            required: true,
                            name: 'email',
                            label: 'Email',
                            id: '',
                            class: '',
                            placeholder: '',
                            maxlength: '',
                            value: '',
                        },
                        settings:{
                            atts: {
                                span: 12
                            }
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
                                        label: "Maxlength"
                                    }
                                ]
                            }
                        }
                    },
                    {
                        type: 'input',
                        inputType: 'textarea',
                        preview: {
                            'label': 'Textarea',
                            name: 'textarea'
                        },
                        settings:{
                            atts: {
                                span: 24
                            }
                        },
                        s:{
                            required: true,
                            name: '',
                            label: 'Label',
                            id: '',
                            class: '',
                            placeholder: '',
                            maxlength: '',
                            value: ''
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
                                    },
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
                    }
                ]
            },
        ]
    }
};

neoforms_form_type_data = neo_apply_filters( 'neoforms_form_type_data', neoforms_form_type_data );