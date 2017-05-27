$(function() {

    /**
     * Mark field as valid
     * @param {type} element
     * @returns {undefined}
     */
    var setFieldValid = function(element) {
        
        $(element).closest('.form-group').removeClass('has-error');
        $(element).closest('.form-group').addClass('has-success');
    };

    /**
     * Mark field as invalid and display error message
     * @param {type} element
     * @param {type} errorMessage
     * @returns {undefined}
     */
    var setFieldInvalid = function(element, errorMessage) {
        
        $(element).closest('.form-group').removeClass('has-success');
        $(element).closest('.form-group').addClass('has-error');
        $(element).closest('.form-group').find('.help-block .message-container').html(errorMessage);
    };

    /**
     * Async call to validate a field content
     * @param {type} event
     * @returns {undefined}
     */
    var fieldValueChanged = function(event){
        
        // Validate on change or else on keyup if the field was containing an error. Otherwise return
        if (event.type != 'change' && !$(event.target).closest('.form-group').hasClass('has-error')) {
            return; 
        }
        
        var postData = {};
        var fieldname = this.name;
        postData[fieldname] = this.value;
        
        $.ajax({
            url: "api/check",
            method: "POST",
            dataType: "json",
            data: postData,
            target: this,
            fieldname: fieldname,
            success: function(data) {
                if (data[this.fieldname].return_code === 0) {
                    setFieldValid(this.target);
                } else {
                    setFieldInvalid(this.target, data[this.fieldname].error_message);
                }
                // Toggle submit button
                if ($('.has-error').length) {
                    $('#betterform-submit').prop('disabled', true)
                } else {
                    $('#betterform-submit').prop('disabled', false)                    
                }
            },
            error: function() {
                alert('An error occurred while validating the form.')
            },
        });
    };
    
    /**
     * Submit form asynchronously
     * @param {type} event
     * @returns {undefined}
     */
    var formSubmit = function(event){
        var form = event.target;

        var selectedGenderInput = $(form).find('[id^=Form_gender]:checked');
        var gender = '';
        if (selectedGenderInput.length) {
            gender = selectedGenderInput.val();
        } 
  
        $.ajax({
            url: "api/submit",
            method: "POST",
            dataType: "json",
            data: { 
                name:    $(form).find('#betterform-name').val(),
                email:   $(form).find('#betterform-email').val(),
                website: $(form).find('#betterform-website').val(),
                comment: $(form).find('#betterform-comment').val(),
                gender:  gender,
                token:   $(form).find('#Form_SecurityID').val(),
            },
            form: form,
            success: function(data) {
                var yourInput = $('#your-input');
                // If submission was successful, show the submission result
                if (data.return_code === 0) {
                    $.each(data, function(i, item) {
                        yourInput.find('.' + i + ' .value').html(data[i].submitted_value);
                    });

                    yourInput.slideDown(400, 
                        function() {
                            $(window).scrollTop($('#your-input').position().top);
                        }
                    );
                } else { 
                    // If submission was not successful, show error 
                    //messages next to invalid fields
                    var form = this.form;
                    $.each(data, function(i, item) {
                        if (data[i].return_code !== 0) {
                            setFieldInvalid($(form).find('[name=' + i + ']').get(0), data[i].error_message);
                        }
                    });
                    yourInput.slideUp();
                }
            },
            error: function() {
                alert('An error occurred while submitting the form.')
            },
        });
    };
    
    // Initialise change and submit events
    $('#betterform-name').on('change keyup', fieldValueChanged);
    $('#betterform-email').on('change keyup', fieldValueChanged);
    $('#betterform-website').on('change keyup', fieldValueChanged);
    $('[name=gender]').change(fieldValueChanged);

    $('#betterform-mainform').submit(function(event){       
        event.preventDefault();
        formSubmit(event);
        return false;
    });
});