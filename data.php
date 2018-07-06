<?php
add_filter( 'neoforms_form_types', function ( $form_types ) {
    $form_types['registration'] = array(
        'label' => __( 'Registration Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create registration form' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
	$form_types['event_registration'] = array(
        'label' => __( 'Event Registration Form', 'neoforms' ),
        'subtitle' => __( 'Pro version  required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create registration form for an event', 'neoforms' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['online_booking'] = array(
        'label' => __( 'Online Booking Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create online booking form', 'neoforms' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['support'] = array(
        'label' => __( 'Support Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create support form' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['rating'] = array(
        'label' => __( 'Rating Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create rating form' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['recommendation'] = array(
        'label' => __( 'Recommendation Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create recommendation form' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['leave'] = array(
        'label' => __( 'Leave Application', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create leave application form' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    $form_types['bug_report'] = array(
        'label' => __( 'Report a Bug Form', 'neoforms' ),
        'subtitle' => __( 'Pro version required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create form for reporting a bug' ),
        'url' => 'https://cybercraftit.com/neoforms-pro/',
        'pro' => 1,
    );
    return $form_types;
} );