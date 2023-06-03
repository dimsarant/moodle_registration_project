<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class registration_form extends moodleform {
    public function definition() {
        $mform = $this->_form;


        $mform->addElement('text','firstname','First name');
        $mform->setType('firstname',PARAM_TEXT);

        $mform->addElement('text','lastname','Last name');
        $mform->setType('lastname',PARAM_TEXT);

        $mform->addElement('text','email','Email');
        $mform->setType('email',PARAM_EMAIL);

        $mform->addElement('select', 'country', 'Country', get_list_of_countries());
        $mform->setType('country', PARAM_TEXT);

        $mform->addElement('text','mobile','Mobile');
        $mform->setType('mobile',PARAM_TEXT);

        $this->add_action_buttons(false,'Register');

        $mform->addElement('html', '<div class="login-button">
                <div style="display:flex;flex-direction: row;gap:20px;align-items: center;">
                    <b>Already a user?</b>
                    <a href="login.php">
                        <button type="button" class="btn btn-primary">Login</button>
                    </a>
                </div>
            </div>');
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        
        global $DB;
        $sql = "SELECT email FROM {registration_data} WHERE email = :email";
        $params = array('email' => $data['email']);
        $existing_email = $DB->get_field_sql($sql, $params);
        
        if ( empty($data['firstname']) ) {
            $errors['firstname']= "Please enter your name.";
        }
        if ( empty($data['lastname']) ) {
            $errors['lastname']= "Please enter your last name.";
        }
        if ( empty($data['email']) ) {
            $errors['email']= "Please enter a valid email.";
        }elseif($existing_email){
            $errors['email']= "Email already taken.";
        }
        if ( ($data['country'])=="default" ) {
            $errors['country']= "Please select your country.";
        }
        if ( empty($data['mobile']) || strlen($data['mobile']) !== 10 ) {
            $errors['mobile']= "Please enter a valid phone number.";
        }elseif ( !is_numeric ($data['mobile'])) {
            $errors['mobile']= "Mobile number must be numeric.";
        }
    
        return $errors;
    }
    

}

function get_list_of_countries() {
    $file_path = new moodle_url('/local/project/data/countries.json');
    
    $countries = array();
    
    // Read the JSON file contents
    $json_data = file_get_contents($file_path);
    
    // Convert JSON to an associative array
    if ($json_data !== false) {
        $countries = json_decode($json_data, true);
    }
    
    return $countries;
}
