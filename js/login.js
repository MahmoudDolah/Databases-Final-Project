(function($) {
    "use strict";
  
  // Options for Message
  //----------------------------------------------
  var options = {
    'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
    'btn-success': '<i class="fa fa-check"></i>',
    'btn-error': '<i class="fa fa-remove"></i>',
    'msg-success': 'All Good! Redirecting...',
    'msg-error': 'Wrong login credentials!',
    'useAJAX': true,
  };

  // Login Form
  //----------------------------------------------
  // Validation
  $("#login-form").validate({
    rules: {
      lg_username: "required",
      lg_password: "required",
    },
    errorClass: "form-invalid"
  });
  
  // Form Submission
  $("#login-form").submit(function() {
    remove_loading($(this));
  });
  
  // Register Form
  //----------------------------------------------
  // Validation
  $("#register-form").validate({
    rules: {
      reg_username: "required",
      reg_password: {
        required: true,
        minlength: 5
      },
      reg_password_confirm: {
        required: true,
        minlength: 5,
        equalTo: "#register-form [name=reg_password]"
      },
      reg_username: {
        required: true,
      },
    },
    errorClass: "form-invalid",
  });

  // Loading
  //----------------------------------------------
  function remove_loading($form)
  {
    $form.find('[type=submit]').removeClass('error success');
    $form.find('.login-form-main-message').removeClass('show error success').html('');
  }

  function form_loading($form)
  {
    $form.find('[type=submit]').addClass('clicked').html(options['btn-loading']);
  }
  
  function form_success($form)
  {
    $form.find('[type=submit]').addClass('success').html(options['btn-success']);
    $form.find('.login-form-main-message').addClass('show success').html(options['msg-success']);
  }

  function form_failed($form)
  {
    $form.find('[type=submit]').addClass('error').html(options['btn-error']);
    $form.find('.login-form-main-message').addClass('show error').html(options['msg-error']);
  }
  
})(jQuery);