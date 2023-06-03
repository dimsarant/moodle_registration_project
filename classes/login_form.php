<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class login_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text','email','Email');
        $mform->setType('email',PARAM_EMAIL);

        $mform->addElement('password','password','Password');
        $mform->setType('password',PARAM_TEXT);

        $this->add_action_buttons(false,'Login');

        $mform->addElement('html', '<div class="register-button">
                <div style="display:flex;flex-direction: row;gap:20px;align-items: center;">
                    <b>Want to register?</b>
                    <a href="index.php">
                        <button type="button" class="btn btn-primary">Register</button>
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
        if ( empty($data['password']) ) {
            $errors['password']= "Please enter your password.";
        }

        if (empty($errors)) {
            $sql = "SELECT email, password FROM {registration_data} WHERE email = :email";
            $params = array('email' => $data['email']);
            $existing_data = $DB->get_record_sql($sql, $params);

            if (!$existing_data || $data['password'] != $existing_data->password) {
                $errors['email'] = "User not found or password is wrong.";
                $errors['password'] = "User not found or password is wrong.";
            }
        }
    
        return $errors;
    }
    

}