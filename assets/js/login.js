'use strict';

function assureEqualPasswordFields() {
    //alert(1);
    jQuery('#register_form_confirm_password').on('input', function(){
        //alert(2);
            if (this.value === document.getElementById('register_form_password').value) {
                this.setCustomValidity("");
            }
            else{
                this.setCustomValidity("The password and confirm password does not match.");
            }
        });
}



    jQuery(document).on('ready', function(){
        //alert();
        assureEqualPasswordFields();
    });


