<?php
declare(strict_types=1);

/**
 * AJAX handler for the VG Contact Split widget's enquiry form.
 * Processes form submissions and sends email via wp_mail().
 */

add_action('wp_ajax_vg_contact_form',        'vg_handle_contact_form');
add_action('wp_ajax_nopriv_vg_contact_form', 'vg_handle_contact_form');

function vg_handle_contact_form(): void {
    check_ajax_referer('vg_contact_form', 'nonce');

    $name     = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email    = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $company  = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));
    $country  = sanitize_text_field(wp_unslash($_POST['country'] ?? ''));
    $interest = sanitize_text_field(wp_unslash($_POST['interest'] ?? ''));
    $message  = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($message) || !is_email($email)) {
        wp_send_json_error(['message' => __('Please fill in all required fields.', 'venicegarden')]);
    }

    $to_email   = get_theme_mod('vg_email_general', get_option('admin_email'));
    $site_name  = get_bloginfo('name');

    $subject = sprintf('[%s] New Enquiry from %s', $site_name, $name);

    $body  = "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    if ($company) $body .= "Company: {$company}\n";
    if ($country) $body .= "Country: {$country}\n";
    if ($interest) $body .= "Enquiry Type: {$interest}\n";
    $body .= "\nMessage:\n{$message}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail($to_email, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => __('Your enquiry has been received. We will be in touch shortly.', 'venicegarden')]);
    } else {
        wp_send_json_error(['message' => __('There was a problem sending your message. Please try again.', 'venicegarden')]);
    }
}
