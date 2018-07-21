var neo_form_types = {};

for( k in neoforms_form_type_data ) {
    neo_form_types[k] = neoforms_form_type_data[k]['label'];
}

var neoforms_form_settings = {
    form_settings: {
        for: '',
        label: 'Form Settings',
        s: {
            form_type: '',
            redirect_to: '',
            submit_text: 'Submit',
            page_id: '',
            url: '',
            success_msg: 'Form submission successful',
            failure_msg: 'Form submission failed'
        },
        schema: {
            fields: [
                {
                    model: 'form_type',
                    type: 'select',
                    label: 'Form Type',
                    desc: 'Type of form',
                    options: neo_form_types
                },
                {
                    model: 'redirect_to',
                    type: 'select',
                    label: 'Redirect to',
                    desc: 'Where the page should be redirect to, after successful form sumission',
                    options: {
                        'same' : 'Same Page',
                        'to_page' : 'To a Page',
                        'to_url' : 'To a URL'
                    }
                },
                {
                    model: 'page_id',
                    type: 'select',
                    label: 'Select Page',
                    desc: 'Select the page, where the page should be redirected after successful form submission',
                    options: $neoform_pages,
                    visible: function (model) {
                        return model.redirect_to === 'to_page';
                    }
                },
                {
                    model: 'url',
                    type: 'input',
                    inputType: 'text',
                    label: 'Redirect URL',
                    desc: 'Place the url where the user should be redirected after successful form submission',
                    visible: function (model) {
                        return model.redirect_to === 'to_url';
                    }
                },
                {
                    model: 'success_msg',
                    type: 'textarea',
                    label: 'Success Message',
                    desc: 'Message that will be shown after successful form submission',
                    visible: function (model) {
                        return model.redirect_to === 'same';
                    }
                },
                {
                    model: 'submit_text',
                    type: 'input',
                    inputType: 'text',
                    label: 'Submit Button Text',
                    desc: 'Submi button text'
                },
                {
                    model: 'success_msg',
                    type: 'textarea',
                    label: 'Message on Success',
                    desc: 'This message will be displayed after successful form submissio',
                },
                {
                    model: 'failure_msg',
                    type: 'textarea',
                    label: 'Message on Failure',
                    desc: 'This message will be displayed form submission fails',
                }
            ]
        }
    },
    form_restriction: {
        for: '',
        label: 'Form Restriction Settings',
        s: {
            is_scheduled: false,
            schedule_from: '',
            schedule_to: '',
            msg_before_schedule: '',
            limit_submission: false,
            number_of_submission: 0,
            limit_break_msg: '',
            require_login: false,
            require_login_msg: ''
        },
        schema: {
            fields: [
                {
                    model: 'is_scheduled',
                    type: 'input',
                    inputType: 'checkbox',
                    desc: 'Check this if you want the users enabled to submit form or a time period.',
                    options: {
                        true: 'Schedule form for a time period'
                    }
                },
                {
                    model: 'schedule_from',
                    type: 'datetimepicker',
                    label: 'Schedule Start Date',
                    desc: 'The date when the form will be accessible from',
                    visible: function (model) {
                        return model.is_scheduled;
                    }
                },
                {
                    model: 'schedule_to',
                    type: 'datetimepicker',
                    label: 'Schedule End Date',
                    desc: 'The date after when the form will not be accessible and submission will not be valid',
                    visible: function (model) {
                        return model.is_scheduled;
                    }
                },
                {
                    model: 'msg_before_schedule',
                    type: 'textarea',
                    label: 'Message out of Schedule',
                    desc: 'Text that will be displayed if user visits the form page before schedule starts or after schedule ends.',
                    visible: function (model) {
                        return model.is_scheduled;
                    }
                },
                {
                    model: 'limit_submission',
                    type: 'input',
                    inputType: 'checkbox',
                    desc: 'Limit form submission',
                    options:{
                        true: 'Limit Form Submission'
                    }
                },
                {
                    model: 'number_of_submission',
                    type: 'input',
                    inputType: 'number',
                    label: 'Number of Submission Allowed',
                    desc: 'Number of form submission allowed',
                    visible: function (model) {
                        return model.limit_submission;
                    }
                },
                {
                    model: 'limit_break_msg',
                    type: 'textarea',
                    label: 'Message after Submission Limit Reached',
                    desc:'Message that will be displayed to user if the limit for submission reached',
                    visible: function (model) {
                        return model.limit_submission;
                    }
                },
                {
                    model: 'require_login',
                    type: 'input',
                    inputType: 'checkbox',
                    desc: 'Check this if you want user to be logged in to submit the form',
                    options: {
                        true: 'Form Submission Requires Login'
                    }
                },
                {
                    model: 'require_login_msg',
                    type: 'textarea',
                    label: 'Login Message',
                    desc: 'Message to show non loggedin users',
                    visible: function (model) {
                        return model.require_login;
                    }
                }
            ]
        }
    },
    appearance_settings: {
        for: '',
        label: 'Appearance Settings',
        s: {
            layout_type: 'rounded'
        },
        schema: {
            fields:[
                {
                    model: 'layout_type',
                    type: 'select',
                    label: 'Layout Type',
                    desc: 'Select layout type',
                    options: {
                        rounded: 'Rounded',
                        cornered: 'Cornered'
                    }
                }
            ]
        }
    },
    contact_settings: {
        for: 'contact',
        label: 'Contact Form Settings',
        s: {
            mail_to: '',
            email_field: 'email',
            subject_field: 'subject',
            message_field: 'message',
            message_format: ''
        },
        schema: {
            fields: [
                {
                    model: 'mail_to',
                    type: 'input',
                    inputType: 'text',
                    label: 'Mail Send to',
                    desc: 'Mail will be sent to this email address, leave it blank if you want mail to be sent to admin email.'
                },
                {
                    model: 'email_field',
                    type: 'input',
                    inputType: 'text',
                    label: 'Field Name of email field',
                    desc: 'Mention the field name from the form that would be treated as sender\'s email field'
                },
                {
                    model: 'subject_field',
                    type: 'input',
                    inputType: 'text',
                    label: 'Field Name of subject',
                    desc: 'Mention the field name from the form that would be treated as email subject'
                },
                {
                    model: 'message_field',
                    type: 'input',
                    inputType: 'text',
                    label: 'Field Name of message',
                    desc: 'Mention the field name from the form that would be treated as email\'s body'
                },
                {
                    model: 'message_format',
                    type: 'input',
                    inputType: 'textarea',
                    label: 'Mail Format',
                    desc: 'You can specify the mail format as how you want the mail to be, P.N: You can add field name from the form like %{field_name}% in the message format.'
                }
            ]
        }
    }
};

neoforms_form_settings = neo_apply_filters( 'neoforms_form_settings', neoforms_form_settings );