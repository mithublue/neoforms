<?php
add_filter( 'neoforms_form_types', function ( $form_types ) {
    $form_types['registration'] = array(
        'label' => __( 'Registration Form', 'neoforms' ),
        'subtitle' => __( 'Registration Form extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create registration form' ),
        'url' => 'https://cybercraftit.com/neofroms-registration-form/',
        'pro' => 1,
    );
	$form_types['comment'] = array(
		'label' => __( 'Comment  Form', 'neoforms' ),
		'subtitle' => __( 'Comment Form extension required', 'neoforms' ),
		'desc' => __( 'Choose this if you want to create form for reporting a bug' ),
		'url' => 'https://cybercraftit.com/neoforms-comment-form/',
		'pro' => 1,
	);
    $form_types['event_registration'] = array(
        'label' => __( 'Event Registration Form', 'neoforms' ),
        'subtitle' => __( 'Event Registration extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create registration form for an event', 'neoforms' ),
        'url' => 'https://cybercraftit.com/neoforms-event-registration/',
        'pro' => 1,
    );
    $form_types['online_booking'] = array(
        'label' => __( 'Online Booking Form', 'neoforms' ),
        'subtitle' => __( 'Online Booking Form extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create online booking form', 'neoforms' ),
        'url' => 'https://cybercraftit.com/neoforms-online-booking-form/',
        'pro' => 1,
    );
    $form_types['support'] = array(
        'label' => __( 'Support Form', 'neoforms' ),
        'subtitle' => __( 'Support Form extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create support form' ),
        'url' => 'https://cybercraftit.com/neoforms-support-form/',
        'pro' => 1,
    );
    $form_types['rating'] = array(
        'label' => __( 'Rating Form', 'neoforms' ),
        'subtitle' => __( 'Rating Form extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create rating form' ),
        'url' => 'https://cybercraftit.com/neoforms-rating-form/',
        'pro' => 1,
    );
    $form_types['recommendation'] = array(
        'label' => __( 'Recommendation Form', 'neoforms' ),
        'subtitle' => __( 'Recommendation Form extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create recommendation form' ),
        'url' => 'https://cybercraftit.com/neoforms-rating-form/',
        'pro' => 1,
    );
    $form_types['leave'] = array(
        'label' => __( 'Leave Application', 'neoforms' ),
        'subtitle' => __( 'Leave Application extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create leave application form' ),
        'url' => 'https://cybercraftit.com/neoforms-leave-application/',
        'pro' => 1,
    );
    $form_types['bug_report'] = array(
        'label' => __( 'Report a Bug Form', 'neoforms' ),
        'subtitle' => __( 'Report a Bug extension required', 'neoforms' ),
        'desc' => __( 'Choose this if you want to create form for reporting a bug' ),
        'url' => 'https://cybercraftit.com/neoforms-report-bug/',
        'pro' => 1,
    );
    return $form_types;
} );