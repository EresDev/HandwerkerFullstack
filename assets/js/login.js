(function($) {

    $('#register_form_confirm_password').on('input', function(){

        if($('#register_form_password').val() !=  $(this).val())
        {
            this.setCustomValidity("The password and confirm password does not match.");
        }
        else{
            this.setCustomValidity("");
        }

    });
})(jQuery);