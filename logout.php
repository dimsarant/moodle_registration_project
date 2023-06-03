<?php
require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');


if (!isset($_SESSION)) {
    session_start();
}
unset($_SESSION['logged-in']);
unset($_SESSION['status']);

redirect( new moodle_url('/local/project/index.php') );