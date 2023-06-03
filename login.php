<?php
use local_project\output\main;
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/login_form.php');
require_once($CFG->libdir . '/moodlelib.php');

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

$url = new moodle_url('/local/project/login.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title('Login');
$PAGE->set_heading('Login');


$mform = new login_form(null);
if ($fromform = $mform->get_data()) {
    global $DB;
    $email = $fromform->email;

    $sql = "SELECT status FROM {registration_data} WHERE email = :email";
    $params = array('email' => $email);
    $status = $DB->get_field_sql($sql, $params);

    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['logged-in'] = 'true';

    if($status==-1){
        $_SESSION['status'] == 'false';
        redirect( new moodle_url('/local/project/passwordchange.php') );
    }else{
        $_SESSION['status'] == 'true';
        redirect( new moodle_url('/local/project/website.php') );
    }

    
} else {
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}