'use strict';

global.jQuery = require('jquery');

beforeEach(() => {
    document.body.innerHTML = '<form name="register_form" method="post" action="/user" _lpchecked="1">\n' +
        '    <div id="register_form">\n' +
        '        <div class="field">\n' +
        '            <label for="register_form_email" class="required">Email</label>\n' +
        '            <input type="email" id="register_form_email" name="register_form[email]" required="required">\n' +
        '        </div>\n' +
        '        <div class="field">\n' +
        '            <label for="register_form_password" class="required">Password</label>\n' +
        '            <input type="password" id="register_form_password" name="register_form[password]" required="required" minlength="6" maxlength="4096">\n' +
        '        </div>\n' +
        '        <div class="field">\n' +
        '            <label for="register_form_confirm_password" class="required">Confirm Password</label>\n' +
        '            <input type="password" id="register_form_confirm_password" name="register_form[confirm_password]" required="required" minlength="6" maxlength="4096">\n' +
        '        </div>\n' +
        '        <div>\n' +
        '            <ul class="actions">\n' +
        '                <li>\n' +
        '                    <button type="submit" id="register_form_Register" name="register_form[Register]" class="alt">Register</button>\n' +
        '                </li>\n' +
        '            </ul>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</form>';
});

test('Password and confirm password fields must be equal before submission', () => {

    require('./login');

    const confirmPasswordField = document.getElementById('register_form_confirm_password');
    const passwordField = document.getElementById('register_form_password');
    const submitBtn = document.getElementById('register_form_Register');

    confirmPasswordField.value = '123456';
    passwordField.value = '123456';

    jQuery(confirmPasswordField).trigger('change');


    //expect(assureEqualPasswordFields).toBeCalled();
    expect(passwordField.validity.valid).toEqual(true);
    expect(confirmPasswordField.validity.valid).toEqual(true);
});


test('Confirm password field is invalid when it does not match password field', () => {

    require('./login');

    jQuery(document).trigger("ready");

    const confirmPasswordField = document.getElementById('register_form_confirm_password');
    const passwordField = document.getElementById('register_form_password');
    const submitBtn = document.getElementById('register_form_Register');

    confirmPasswordField.value = '1234';
    passwordField.value = '123456';


    jQuery(confirmPasswordField).trigger("input");


    expect(passwordField.validity.valid).toEqual(true);
    expect(confirmPasswordField.validity.valid).toEqual(false);
});
