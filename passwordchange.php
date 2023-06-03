<?php
use local_project\output\main;
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/passwordchange_form.php');
require_once($CFG->libdir . '/moodlelib.php');

if (!isset($_SESSION)) {
    session_start();
}
if( $_SESSION['logged-in'] != 'true'){
    redirect( new moodle_url('/local/project/index.php') );
}

$url = new moodle_url('/local/project/passwordchange.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title('Password Change');
$PAGE->set_heading('Password Change');


$mform = new passwordchange_form(null);
if ($fromform = $mform->get_data()) {
    global $DB;
    $email = $fromform->email;
    $password = $fromform->new_password;

    $sql = "SELECT id FROM {registration_data} WHERE email = :email";
    $params = array('email' => $email);
    $id = $DB->get_field_sql($sql, $params);

    $dataobject = new stdClass();
    $dataobject->id = $id;
    $dataobject->password = $password;
    $dataobject->status = 1;

    $DB->update_record('registration_data', $dataobject);

    $_SESSION['status'] = 'true';
    redirect( new moodle_url('/local/project/website.php') );

    
} else {
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}