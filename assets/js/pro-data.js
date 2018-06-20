neo_add_filter( 'neoforms_form_settings', function (neoforms_form_settings) {
    var form_settings_schema = [
        {
            model: '',
            type: 'input',
            inputType: 'checkbox',
            desc: 'Check this if you want the form to be multistep (Pro)',
            options: {
                true: 'Is Multistep (Pro)'
            },
            wrapperclass: 'pro_fields'
        }
    ];
    neoforms_form_settings.form_settings.schema.fields = form_settings_schema.concat(neoforms_form_settings.form_settings.schema.fields);


    neoforms_form_settings.form_restriction.schema.fields.push({
        model: 'pro_1',
        type: 'input',
        inputType: 'checkbox',
        label: 'Applicable for All Roles (Pro)',
        desc: 'Applicable for All Roles (Pro)',
        options: {
            true: 'Applicable for All Roles'
        },
        wrapperclass: 'pro_fields'
    });
    neoforms_form_settings.form_restriction.schema.fields.push({
        model: 'pro_2',
        type: 'input',
        inputType: 'checkbox',
        label: 'Chose Roles (Pro)',
        options: $all_roles,
        wrapperclass: 'pro_fields'
    });

    return neoforms_form_settings;
});

/**
 * Form fields
 */
neo_add_filter( 'neo_formFields', function ( formFields ) {
    var pro_formFields = [
//multiselect pro
        {
            pro: 1,
            type: 'input',
            inputType: 'select',
            preview: {
                'label': 'Multi Select',
                name: 'multiselect'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //repeat_field pro
        {
            pro: 1,
            type: 'input',
            inputType: 'repeat_field',
            preview: {
                'label': 'Repeat Field',
                name: 'repeat_field'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //country_list pro
        {
            pro: 1,
            type: 'input',
            inputType: 'country_list',
            preview: {
                'label': 'Country List',
                name: 'country_list'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //address pro
        {
            pro: 1,
            type: 'input',
            inputType: 'address',
            preview: {
                'label': 'Address',
                name: 'address'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //switch pro
        {
            pro: 1,
            type: 'input',
            inputType: 'switch',
            preview: {
                'label': 'Switch',
                name: 'switch'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //slider pro
        {
            pro: 1,
            type: 'input',
            inputType: 'slider',
            preview: {
                'label': 'slider',
                name: 'slider'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //datetimepicker pro
        {
            pro: 1,
            type: 'input',
            inputType: 'datetimepicker',
            preview: {
                'label': 'Datetimepicker',
                name: 'datetimepicker'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //rate pro
        {
            pro: 1,
            type: 'input',
            inputType: 'rate',
            preview: {
                'label': 'Rate',
                name: 'rate'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //Recaptcha pro
        {
            pro: 1,
            type: 'input',
            inputType: 'recaptcha',
            preview: {
                'label': 'Recaptcha',
                name: 'recaptcha'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //Google map pro
        {
            pro: 1,
            type: 'input',
            inputType: 'google_map',
            preview: {
                'label': 'Google Map',
                name: 'google_map'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //Custom HTML pro
        {
            pro: 1,
            type: 'input',
            inputType: 'custom_html',
            preview: {
                'label': 'Custom HTML',
                name: 'custom_html'
            },
            settings:{
                atts: {
                    span: 24
                }
            }
        },
        //upload
        {
            pro: 1,
            type: 'input',
            inputType: 'upload',
            preview: {
                'label': 'Upload',
                name: 'upload'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //colorpicker pro
        {
            pro: 1,
            type: 'input',
            inputType: 'colorpicker',
            preview: {
                'label': 'Color Picker',
                name: 'colorpicker'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
        //username pro
        {
            pro: 1,
            type: 'input',
            inputType: 'username',
            preview: {
                label: 'Username',
                name: 'username'
            },
            settings:{
                atts: {
                    span: 12
                }
            }
        },
    ];
    formFields = formFields.concat(pro_formFields);
    return formFields;
} );


/**
 * global settings schema
 */
neo_add_filter( 'global_settings_sections', function (global_settings_sections) {
    var settings_sections = {
        recaptcha: {
            label: 'Recaptcha (Pro)',
            desc: 'You can get your recaptcha credentials from https://www.google.com/recaptcha',
            schema: {
                fields: [
                    {
                        model: '',
                        type: 'input',
                        inputType: 'text',
                        label: 'Site Key (Pro)',
                        desc: 'Site key for recaptcha',
                        class: 'disabled',
                        wrapperclass: 'pro_fields'
                    },
                    {
                        model: '',
                        type: 'input',
                        inputType: 'text',
                        label: 'Secret Key (Pro)',
                        desc: 'Secret key for recaptcha',
                        wrapperclass: 'pro_fields'
                    }
                ]
            }
        },
        google_map: {
            label: 'Google Map (Pro)',
            desc: '',
            schema: {
                fields: [
                    {
                        model: '',
                        type: 'input',
                        inputType: 'text',
                        label: 'Google Map API Key (Pro)',
                        wrapperclass: 'pro_fields'
                    }
                ]
            }
        }
    };
    global_settings_sections = Object.assign({},global_settings_sections, settings_sections);
    return global_settings_sections;
});
