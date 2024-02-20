import validate from 'jquery-validation'

const dom = {
    form: $('.military-register-form form')
}

const init = () => {
    $.validator.addMethod("passwordCheck", function (value) {
        return /^(?=.*[A-Z])(?=.*\d).{6,}$/.test(value)
    });

    dom.form.validate({

        rules: {
            register_username: {
                required: true
            },
            register_email: {
                required: true,
                email: true
            },
            register_password: {
                required: true,
                passwordCheck: true
            },
            register_states: {
                required: true
            },
            register_street: {
                required: true
            },
            register_town: {
                required: true
            },
            register_postcode: {
                required: true
            },
            register_phone: {
                required: true
            },
            register_cst_team: {
                required: true
            },
            register_rights: {
                required: true
            },
            register_countries: {
                required: true
            }
        },
        messages: {
            register_password: {
                passwordCheck: "Password must contain a minimum of 6 characters, must have at least one capital letter and a number."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    })

}

export default init

