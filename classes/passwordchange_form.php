<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class passwordchange_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text','email','Email');
        $mform->setType('email',PARAM_EMAIL);

        $mform->addElement('password','old_password','Old Password');
        $mform->setType('old_password',PARAM_TEXT);

        $mform->addElement('password','new_password','New Password');
        $mform->setType('new_password',PARAM_TEXT);

        $this->add_action_buttons(false,'Confirm');

        $mform->addElement('html', '<div class="login-button">
                <div style="display:flex;flex-direction: row;gap:20px;align-items: center;">
                    <b>Want to Logout?</b>
                    <a href="logout.php">
                        <button type="button" class="btn btn-primary">Logout</button>
                    </a>
                </div>
            </div>');
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        global $DB;

        if ( empty($data['email']) ) {
            $errors['email']= "Please enter your email.";
        }
        if ( empty($data['old_password']) ) {
            $errors['old_password']= "Please enter your old password.";
        }
        if ( empty($data['new_password']) ) {
            $errors['new_password']= "Please enter your new password.";
        }elseif(strlen($data['new_password']) < 10){
            $errors['new_password'] = "Password must be at least 10 characters.";
        }
        if (!empty($data['old_password']) && !empty($data['new_password']) && $data['old_password'] == $data['new_password']) {
            $errors['old_password'] = "Old password cannt be the same as the new.";
            $errors['new_password'] = "Old password cannt be the same as the new.";
        }
        if (empty($errors)) {
            $sql = "SELECT email,password password FROM {registration_data} WHERE email = :email";
            $params = array('email' => $data['email']);
            $existing_data = $DB->get_record_sql($sql, $params);

            if (!$existing_data || $data['old_password'] != $existing_data->password) {
                $errors['email'] = "User not found or password is wrong.";
                $errors['old_password'] = "User not found or password is wrong.";
            }
        }
    
        return $errors;
    }
    

}