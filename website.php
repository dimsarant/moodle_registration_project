<?php
use local_project\output\main;
require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');

if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['logged-in'] == 'true') {
    if($_SESSION['status'] == 'false'){
        redirect(new moodle_url('/local/project/passwordchange.php'));
    }
}else{
    redirect(new moodle_url('/local/project/index.php'));
}

$url = new moodle_url('/local/project/website.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title('Moodle');
$PAGE->set_heading('Welcome!');

$PAGE->requires->js(new moodle_url('/local/project/functions/delete_user.js?t='.time()));

$indexview = new main();
echo $OUTPUT->header();
echo $OUTPUT->render($indexview);
echo $OUTPUT->footer();
