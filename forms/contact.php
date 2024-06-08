<?php

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'prathapsg@hotmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = $_POST['subject'];

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

// Add CC and BCC
$contact->cc = array('ccreceiver1@example.com', 'ccreceiver2@example.com');
$contact->bcc = array('bccreceiver1@example.com', 'bccreceiver2@example.com');

// Spam protection using honeypot method
$contact->honeypot = $_POST['first_name'];

// Spam protection using Google reCaptcha
$contact->recaptcha_secret_key = 'Your_reCAPTCHA_secret_key'; // Replace with your reCAPTCHA secret key

// Adding file attachment
$contact->add_attachment('resume', 20, array('pdf', 'doc', 'docx', 'rtf'));

// Check for privacy policy acceptance
if ($_POST['privacy'] != 'accept') {
    die('Please, accept our terms of service and privacy policy');
}

// Adding messages to the email
$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

echo $contact->send();
?>
