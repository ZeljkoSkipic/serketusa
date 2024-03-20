<?php
get_header();

$states = isset($args['states']) ? $args['states'] : "";
$user_registred = isset($_GET['register']) ? $_GET['register'] : "";
$additional_countries = (array) get_field('choose_additional_countries', 'options');

if ($user_registred && $user_registred == true) :
?>
    <div class="register-form-thank-you">
        <div class="container">
            <p><?php esc_html_e('Thank you for your registration, your account will be reviewed shortly.', 'register') ?></p>
        </div>
    </div>
<?php
else :
?>

    <section class="military-register-form c-narrow space_2">
        <div class="container">

            <?php do_action('form_register_errors'); ?>

            <h1 class="register-form__title"><?php esc_html_e('Register', 'register'); ?></h1>
            <div class="register-form__wrapper">
                <form action="" method="POST">
                    <div class="register-form__input">
                        <label for="username"><?php esc_html_e('Username', 'register'); ?><span class="register-form__required">*</span></label>
                        <input type="text" id="username" name="register_username">
                    </div>
                    <div class="register-form__input">
                        <label for="email"><?php esc_html_e('Email', 'register'); ?><span class="register-form__required">*</span></label>
                        <input type="email" id="email" name="register_email">
                    </div>
                    <div class="register-form__input">
                        <label for="password"><?php esc_html_e('Password', 'register'); ?><span class="register-form__required">*</span></label>
                        <input type="password" id="password" name="register_password">
                    </div>
                    <div class="register-form__billing_fileds">
                        <h2 class="register-form__billing_fileds-title"><?php esc_html_e('Details', 'register'); ?></h2>

                        <?php if ($states) : ?>

                            <div class="register-form__input">
                                <label for="states"><?php esc_html_e('States and Territories', 'register'); ?><span class="register-form__required">*</span></label>
                                <select type="text" id="states" name="register_states">
                                    <option selected disabled value="-1"> <?php esc_html_e('Choose State', 'register'); ?></option>

                                    <?php foreach ($states['US'] as $state_code => $state_usa) : if($state_code == 'AA' || $state_code == 'AE' || $state_code == 'AP'  ) continue; ?>
                                        <option class="state-option" value="<?php echo $state_code; ?>"><?php echo $state_usa; ?></option>
                                    <?php endforeach; ?>

                                    <?php

                                    if ($additional_countries) :
                                        foreach ($additional_countries as $country) :
                                            ?>
                                            <option class="state-option" value="<?php echo $country['value']; ?>"><?php echo $country['label']; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>

                                </select>
                            </div>

                        <?php endif; ?>
                        <div class="register-form__input">
                            <label for="street"><?php esc_html_e('Street address', 'register'); ?><span class="register-form__required">*</span></label>
                            <input type="text" id="street" name="register_street">
                        </div>
                        <div class="register-form__input">
                            <label for="town"><?php esc_html_e('Town', 'register'); ?><span class="register-form__required">*</span></label>
                            <input type="text" id="town" name="register_town">
                        </div>
                        <div class="register-form__input">
                            <label for="postcode"><?php esc_html_e('Postcode/ ZIP', 'register'); ?><span class="register-form__required">*</span></label>
                            <input type="text" id="postcode" name="register_postcode">
                        </div>
                        <div class="register-form__input">
                            <label for="phone"><?php esc_html_e('Phone', 'register'); ?><span class="register-form__required">*</span></label>
                            <input type="text" id="phone" name="register_phone">
                        </div>
                        <div class="register-form__input">
                            <label for="cst_team"><?php esc_html_e('CST Team', 'register'); ?><span class="register-form__required">*</span></label>
                            <select type="text" id="cst_team" name="register_cst_team">
                                <option selected disabled value="-1"> <?php esc_html_e('Choose CST Team', 'register'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="register-form__input register-form__input--rights">
						<input type="checkbox" id="rights" name="register_rights">
						<label for="rights"><?php esc_html_e('I have read and understand the NGC CST Group Order Submission instructions', 'register'); ?></label>
                    </div>
                    <div class="register-form__input">
                        <input class="btn-1" type="submit" id="register" name="register" value="<?php esc_html_e('Register', 'register'); ?>">
                    </div>
                    <?php wp_nonce_field('form-register-key', 'form_register_key'); ?>
                </form>
            </div>
        </div>
    </section>

<?php endif; ?>

<?php get_footer(); ?>
