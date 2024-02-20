<?php

namespace App\Register;

class Register
{
    private $registerPage;

    public function __construct()
    {
        new RegisterSettings();
        $this->registerPage = get_option('military_form_register');
        add_filter('template_include', [$this, 'registerTemplateLoad']);
        add_filter('template_redirect', [$this, 'redirectUserAccountPage']);
        add_action('wp_ajax_cst_team_populate', [$this, 'cstTeamSelectPopulate']);
        add_action('wp_ajax_nopriv_cst_team_populate', [$this, 'cstTeamSelectPopulate']);
        add_action('wp_ajax_state_select_populate', [$this, 'statesSelectPopulate']);
        add_action('wp_ajax_nopriv_state_select_populate', [$this, 'statesSelectPopulate']);
        add_action('wp', [$this, 'registerUser']);
        add_action('load-users.php', [$this, 'approveUser']);
        add_filter('handle_bulk_actions-users', [$this, 'approveUserBulk'], 10, 3);
        add_filter('wp_authenticate_user', [$this, 'userLoginAuthentication'], 10, 2);
        add_filter('acf/load_field/name=state', [$this, 'acfPopulateStates']);
        add_filter('acf/load_field/name=choose_cst_teams', [$this, 'acfPopulateCstTeam']);
        add_filter('acf/load_field/name=user_cst_team', [$this, 'acfPopulateCstTeam']);
        add_filter('acf/load_field/name=choose_additional_countries', [$this, 'acfPopulateAdditionalCountries']);
    }

    private function getStates($code = null)
    {
        $wc_countries = new \WC_Countries();
        $states = $wc_countries->get_states($code);

        return $states;
    }

    private function getCountries()
    {
        $wc_countries = new \WC_Countries();
        $countries = $wc_countries->get_countries();

        return $countries;
    }

    public function acfPopulateCstTeam($field)
    {
        $field['choices'] = array();

        $teams = get_field('cst_teams', 'options');

        if ($teams) {
            foreach ($teams as $team) {
                $field['choices'][$team['name']] = $team['name'];
            }
        }

        return $field;
    }

    public function acfpopulateStates($field)
    {
        $field['choices'] = array();

        // Populate US States Default

        $states = $this->getStates();

        if ($states && isset($states['US'])) {
            foreach ($states['US'] as $state_code => $state) {
                if ($state_code == 'AA' || $state_code == 'AE' || $state_code == 'AP') continue;
                $field['choices'][$state_code] = $state;
            }
        }

        // Populate additional states

        $additional_countries = get_field('choose_additional_countries', 'options');

        if ($additional_countries) {
            foreach ($additional_countries as $country) {
                $field['choices'][$country['value']] = $country['label'];
            }
        }

        asort($field['choices']);

        return $field;
    }

    public function acfPopulateAdditionalCountries($field)
    {

        $field['choices'] = array();

        $countries = $this->getCountries();

        if ($countries && is_array($countries)) {
            $countries = array_filter($countries, function ($country_code) {
                return $country_code != 'US';
            }, ARRAY_FILTER_USE_KEY);
        }

        if ($countries) {
            foreach ($countries as $country_code => $country) {
                $field['choices'][$country_code] = $country;
            }
        }

        return $field;
    }

    public function statesSelectPopulate()
    {
        $nonce = $_REQUEST['nonce'];

        if (!wp_verify_nonce($nonce, 'requestNonce')) {
            die(__('Security check', 'register'));
        } else {
            $country_code = isset($_POST['countryCode']) && $_POST['countryCode'] ? wp_strip_all_tags($_POST['countryCode']) : "";
            if ($country_code) {
                $states = $this->getStates($country_code);

                wp_send_json_success([
                    'states' => $states
                ]);
            }
        }

        die();
    }

    public function cstTeamSelectPopulate()
    {
        $nonce = $_REQUEST['nonce'];
        $teams = [];
        if (!wp_verify_nonce($nonce, 'requestNonce')) {
            die(__('Security check', 'register'));
        } else {
            $state_code = isset($_POST['stateCode']) && $_POST['stateCode'] ? wp_strip_all_tags($_POST['stateCode']) : "";
            if ($state_code) {
                $state_team_conection = get_field('cst_team_state_connection', 'options');

                if ($state_team_conection) {
                    foreach ($state_team_conection as $connection) {
                        if ($connection['state'] == $state_code) {
                            $teams = $connection['choose_cst_teams'];
                        }
                    }
                }

                if ($teams) {
                    wp_send_json_success([
                        'teams' => $teams
                    ]);
                } else {
                    wp_send_json_error();
                }
            }
        }

        die();
    }

    private function validateUserRegistration($username, $email, $password, $state, $street, $postcode, $cst_team, $rights, $town, $phone)
    {
        $valid = false;

        // Check required fields

        if ($username && $email && $password && $state && $street && $postcode && $cst_team && $rights && $town && $phone) {
            $valid = true;
        } else {
            return false;
        }

        // Check password  Password must contain a minimum of 6 characters, must have at least one capital letter and a number.

        if (preg_match('/^(?=.*[A-Z])(?=.*\d).{6,}$/', $password)) {
            $valid = true;
        } else {
            return false;
        }

        // Check email

        if (preg_match('/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $valid = true;
        } else {
            return false;
        }

        // Check zip code onlu numbers

        if (preg_match('/^\d+$/', $postcode)) {
            $valid = true;
        } else {
            return false;
        }

        return $valid;
    }

    private function sendEmail($template, $subject, $email, $username, $admin = false)
    {
        $wc = new \WC_Emails();
        ob_start();
        get_template_part('includes/register/emails/' . $template, null, ['username' => $username, 'email' => $email]);
        $email_template = ob_get_clean();
        $email_wrapper = $wc->wrap_message($subject, $email_template);
        ob_start();
        get_template_part('includes/register/emails/administrator-new-account', null, ['username' => $username, 'email' => $email]);
        $email_template_admin = ob_get_clean();
        $email_wrapper_admin = $wc->wrap_message(__('New site registration!'), $email_template_admin);
        if ($admin) {
            $wc->send(get_bloginfo('admin_email'), __('New site registration!'), $email_wrapper_admin);

            // Additional email addresses

            $additional_emails = get_field('additional_email_address', 'options');

            if($additional_emails) {
                foreach($additional_emails as $additional_email) {
                    $wc->send($additional_email['email'], __('New site registration!'), $email_wrapper_admin);
                }
            }
        }

        $wc->send($email, $subject, $email_wrapper);
    }

    public function registerUser()
    {
        if (isset($_POST['register'])) {
            if (isset($_POST['form_register_key']) && wp_verify_nonce($_POST['form_register_key'], 'form-register-key')) {
                $username = isset($_POST['register_username']) ? wp_strip_all_tags($_POST['register_username']) : "";
                $email = isset($_POST['register_email']) ? wp_strip_all_tags($_POST['register_email']) : "";
                $password = isset($_POST['register_password']) ? wp_strip_all_tags($_POST['register_password']) : "";
                $town = isset($_POST['register_town']) ? wp_strip_all_tags($_POST['register_town']) : "";
                $state = isset($_POST['register_states']) ? wp_strip_all_tags($_POST['register_states']) : "";
                $street = isset($_POST['register_street']) ? wp_strip_all_tags($_POST['register_street']) : "";
                $postcode = isset($_POST['register_postcode']) ? wp_strip_all_tags($_POST['register_postcode']) : "";
                $phone = isset($_POST['register_phone']) ? wp_strip_all_tags($_POST['register_phone']) : "";
                $cst_team = isset($_POST['register_cst_team']) ? wp_strip_all_tags($_POST['register_cst_team']) : "";
                $rights = isset($_POST['register_rights']) ? wp_strip_all_tags($_POST['register_rights']) : "";

                if ($this->validateUserRegistration($username, $email, $password, $state, $street, $postcode, $cst_team, $rights, $town, $phone) === true) {

                    $user = wp_insert_user([
                        'user_pass'      => $password,
                        'user_login'     => $username,
                        'user_email'     => $email,
                        'role'           => 'military_customer',
                        'meta_input'     => [
                            'billing_state'             => $state,
                            'billing_address_1'         => $street,
                            'billing_city'              => $town,
                            'billing_email'             => $email,
                            'billing_phone'             => $phone,
                            'billing_postcode'          => $postcode,
                            'user_cst_team'             => $cst_team,
                            'status'                    => 'hold',
                        ]
                    ]);

                    if ($user instanceof \WP_Error) {
                        if (property_exists($user, 'errors')) {
                            $errors = $user->errors;
                            add_action('form_register_errors', function () use ($errors) {
                                if ($errors) :
?>
                                    <div class="form-register-errors">

                                        <?php
                                        foreach ($errors as $errors_type) :
                                            foreach ($errors_type as $error) :
                                        ?>
                                                <p><?php echo $error; ?></p>
                                        <?php
                                            endforeach;
                                        endforeach; ?>

                                    </div>
                            <?php
                                endif;
                            });
                        }
                    } else if (is_int($user)) {
                        $this->sendEmail('customer-new-account', __('Thank you for the registration!', 'register'), $email, $username, true);
                        wp_redirect(get_the_permalink($this->registerPage) . '?register=true');
                        exit;
                    }
                } else {
                    return false;
                }
            } else {
                die(__('Security check', 'register'));
            }
        }
    }

    // Prevent user to login if is not approved

    public function userLoginAuthentication($user, $password)
    {
        if ($user !== null) {
            $user_id = $user->ID;
            $get_user_status = get_user_meta($user_id, 'status', true);
            if ($get_user_status == 'hold') {
                $error  = new \WP_Error('authentication_failed', __('ERROR: Your account must be approved by an admin. Please contact admin.'));
                return $error;
            }
        }

        return $user;
    }

    public function approveUser()
    {
        // Only admin can approve user

        if (!current_user_can('manage_options')) {
            return;
        }

        if (isset($_GET['action']) && $_GET['action'] == 'user-approve-row') {
            if (isset($_GET['user']) && $_GET['user']) {
                $user_id = wp_strip_all_tags($_GET['user']);
                $get_user_status = get_user_meta($user_id, 'status', true);

                // If is user on hold, approve user with admin action

                if ($get_user_status == 'hold') {
                    $update_user_status = update_user_meta($user_id, 'status', 'approved');

                    if ($update_user_status) {
                        add_action('admin_notices', function () {
                            ?>
                            <div class="updated">
                                <p><?php esc_html_e('User has been approved!', 'register'); ?></p>
                            </div>
<?php
                        });

                        // Send email to user

                        $user_data = get_userdata($user_id);

                        if ($user_data) {
                            $this->sendEmail('customer-account-approved', __('Your account is approved!', 'register'), $user_data->user_email, $user_data->user_login);
                        }
                    }
                }
            }
        }
    }

    public function approveUserBulk($redirect, $action, $ids)
    {
        if (!current_user_can('manage_options')) {
            return $redirect;
        }

        if ($action == 'user-approve-bulk') {
            if ($ids) {
                foreach ($ids as $id) {
                    $get_user_status = get_user_meta($id, 'status', true);
                    if ($get_user_status == 'hold') {
                        update_user_meta($id, 'status', 'approved');
                    }
                }
            }
        }

        return $redirect;
    }

    // Redirect user if is already logged in to my account

    public function redirectUserAccountPage()
    {
        if ($this->registerPage == get_the_ID() && is_user_logged_in()) {
            wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
            exit;
        }
    }

    // Load template on register page

    public function registerTemplateLoad($template)
    {
        if ($this->registerPage == get_the_ID()) {
            $template = locate_template(array('template-parts/registerForm.php'), true, true, [
                'states' => $this->getStates()
            ]);
        } else {
            return $template;
        }
    }
}
