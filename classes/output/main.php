<?php

namespace local_project\output;
defined('MOODLE_INTERNAL') || die();

use renderer_base;
use moodle_url;

class main implements \renderable, \templatable {

    public function export_for_template(renderer_base $output) {
        global $DB, $OUTPUT;

        $records = $DB->get_records('registration_data');
        $data = array();

        foreach ($records as $record) {

            $data[] = array(
                'id' => $record->id,
                'firstname' => $record->firstname,
                'lastname' => $record->lastname,
                'email' => $record->email,
                'country' => $record->country,
                'mobile' => $record->mobile,
                'password' => $record->password,
                'status' => $record->status
            );
        }

        return array('data' => $data);
    }

}
