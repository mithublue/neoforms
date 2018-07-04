var formFields = [
    //text
    {
        type: 'input',
        inputType: 'text',
        preview: {
            'label': 'Text',
            name: 'text'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //textarea
    {
        type: 'input',
        inputType: 'textarea',
        preview: {
            'label': 'Textarea',
            name: 'textarea'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //number
    {
        type: 'input',
        inputType: 'number',
        preview: {
            'label': 'Number',
            name: 'number'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //radio
    {
        type: 'input',
        inputType: 'radio',
        preview: {
            label: 'Radio',
            name: 'radio'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //radio_group
    {
        type: 'input',
        inputType: 'radio_group',
        preview: {
            label: 'Radio Group',
            name: 'radio_group'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //option_group
    /*{
        type: 'input',
        inputType: 'option_group',
        preview: {
            label: 'Option Group',
            name: 'option_group'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },*/
    //checkbox
    {
        type: 'input',
        inputType: 'checkbox',
        preview: {
            'label': 'Checkbox',
            name: 'checkbox'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //checkbox group
    {
        type: 'input',
        inputType: 'checkbox_group',
        preview: {
            'label': 'Checkbox Group',
            name: 'checkbox_group'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //select
    {
        type: 'input',
        inputType: 'select',
        preview: {
            'label': 'Select',
            name: 'select'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //website url
    {
        type: 'input',
        inputType: 'website_url',
        preview: {
            label: 'Website Url',
            name: 'website_url'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //email address
    {
        type: 'input',
        inputType: 'email_address',
        preview: {
            'label': 'Email Address',
            name: 'email_address'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //password
    {
        type: 'input',
        inputType: 'password',
        preview: {
            'label': 'Password',
            name: 'password'
        },
        settings:{
            atts: {
                span: 12
            }
        }
    },
    //hidden_field
    {
        type: 'input',
        inputType: 'hidden_field',
        preview: {
            'label': 'Hidden Field',
            name: 'hidden_field'
        },
        settings:{
            atts: {
                span: 24
            }
        }
    }
];

formFields = neo_apply_filters( 'neo_formFields', formFields );