'use strict';

function assureEqualPasswordFields() {
    console.log("Here we go...");
    jQuery('#register_form_confirm_password').on('input paste', function(){
            if (this.value === document.getElementById('register_form_password').value) {
                this.setCustomValidity("");
            }
            else{
                this.setCustomValidity("The password and confirm password does not match.");
            }
        });
}

jQuery(assureEqualPasswordFields);



