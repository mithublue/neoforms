var neoforms_routes = [
    {path: '/', redirect: '/forms'},
    {path: '/forms', component: neoforms_forms},
    {path: '/forms/:status/page/:page', component: neoforms_forms},
    {path: '/forms/form-types', component: neoforms_form_types},
    {path: '/forms/new-form/:form_type', component: neoforms_new_form},
    {path: '/forms/form/:form_id/edit', component: neoforms_new_form},
    {path: '/forms/new-form/update', component: neoforms_new_form},
    {path: '/settings', component: neoforms_settings},
    {path: '/forms/entries/:form_type', component: neoforms_entries},
    {path: '/forms/entries/:form_type/:status/page/:page', component: neoforms_entries},
    {path: '/forms/entries/:form_type/view/:id', component: neoforms_entry},
    {path: '/help', component: neoforms_help}
];

neoforms_routes = neo_apply_filters( 'neoforms_routes', neoforms_routes );

const router = new VueRouter({
    routes : neoforms_routes,
    'linkActiveClass': 'active'
});

var row_data =  {
    type: 'row',
    preview: {
        label: 'Row'
    },
    row_formdata: []
};

var app = new Vue({
    store: store,
    router: router,
    el: '#neoforms-app',
    data: {}
});