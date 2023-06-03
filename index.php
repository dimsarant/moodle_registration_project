<?php
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/registration_form.php');
require_once($CFG->libdir . '/moodlelib.php');
use local_project\output\main;
$PAGE->requires->js(new moodle_url('/local/project/functions/delete_user.js?t='.time()));


$url = new moodle_url('/local/project/index.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('plugintitle','local_project'));
$PAGE->set_heading(get_string('plugintitle', 'local_project'));

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['logged-in'] == 'true') {
    if($_SESSION['status'] == 'false'){
        redirect(new moodle_url('/local/project/passwordchange.php'));
    }else{
        redirect(new moodle_url('/local/project/website.php'));
    }
}


$mform = new registration_form(null);
if ($fromform = $mform->get_data()) {
    $insertrecord = new stdClass();
    $insertrecord->firstname = $fromform->firstname;
    $insertrecord->lastname = $fromform->lastname;
    $insertrecord->email = $fromform->email;
    $insertrecord->country = $fromform->country;
    $insertrecord->mobile = $fromform->mobile;

    $dummy_password = generate_random_password(10);
    $insertrecord->password = $dummy_password;
    $DB->insert_record('registration_data', $insertrecord);

    $target = $fromform->email;
    sendmail($target,$dummy_password);

    redirect($url);
} else {
    $indexview = new main();

    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
    echo $OUTPUT->render($indexview);
}

function generate_random_password($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    $max_index = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $max_index)];
    }

    return $password;
}

function sendmail($recipient, $password) {
    // Define the sender of the email
    $sender = "autodriverentalskalamata@gmail.com";

    // Set up the email parameters
    $subject = 'Welcome to Moodle Project';
    $message = 'Thank you for registering in my Project.' . "\n\n";
    $message .= 'Your credentials:' . "\n";
    $message .= 'Email: ' . $recipient . "\n";
    $message .= 'Password: ' . $password . "\n\n";
    $message .= 'Please keep your credentials safe.' . "\n";
    $message .= 'To login , visit http://localhost/local/project/login.php' . "\n";

    // Send the email
    $emailresult = email_to_user($recipient, $sender, $subject, $message);

    if ($emailresult) {
        // Email sent successfully
        echo 'Email sent successfully.';
    } else {
        // Failed to send email
        echo 'Failed to send email.';
    }
}