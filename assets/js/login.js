'use strict';

function assureEqualPasswordFields() {
    jQuery('#register_form_confirm_password').on('change', function(){
            console.error("Event triggered");
            if (this.value === document.getElementById('register_form_password').value) {
                this.setCustomValidity("");
            }
            else{
                this.setCustomValidity("The password and confirm password does not match.");
            }
        });
}

jQuery(assureEqualPasswordFields);

