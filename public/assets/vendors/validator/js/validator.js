let validator = function (options) {


    // boot up
    // adding required stylesheets to the head
    (function () {
        let jsMin = 'validator.min.js';
        let js = 'validator.js';
        let css = 'validator.min.css';
        let jsFileLocation = '';
        let elJsMin = $('script[src*="' + jsMin + '"]');


        if (elJsMin.attr('src') === undefined) {
            jsFileLocation = $('script[src*="' + js + '"]').attr('src');  // the js file path
            jsFileLocation = jsFileLocation.replace('js/' + js + '', '');
        } else {
            jsFileLocation = elJsMin.attr('src');  // the js file path
            jsFileLocation = jsFileLocation.replace('js/' + jsMin + '', '');
        }
        $("head").append('<link rel="stylesheet" type="text/css" href="' + jsFileLocation + 'css/' + css + '">');

    })();


    let check = {
        results: {},
        formStatus: false,

        required: function (element, spanID) {
            let elementType = element.attr('type');




            // if (element[0].tagName && element[0].tagName.toLowerCase() === "textarea") {
            if (element.is("textarea")) {

                if (/^\s*$/g.test(element.val())) {
                    style.invalid(element, 'This field is required', '', spanID);
                    helper.setFormStatus(element, false)
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }

            } else if (elementType === 'radio') {


                let name = element.attr('name');

                if ($('input[name="' + name + '"]:checked').length === 0) {

                    style.invalid(element, 'Please Select an option', 'radio', spanID);
                    helper.setFormStatus(element, false);


                } else {


                    style.valid(element, 'radio', spanID);
                    helper.setFormStatus(element, true);

                }


            } else if (elementType === 'file') {

                if (element[0].files.length === 0) {
                    style.invalid(element, 'Please select an attachment', '', spanID);
                    helper.setFormStatus(element, false);
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }

            } else if (element.is("select")) {


                if (element.val() < 0 || element.val() === null) {
                    style.invalid(element, 'Please Select an option', '', spanID);
                    helper.setFormStatus(element, false);

                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }

            } else {


                if (element.val() === '' || element.val() == null || element.val().trim() === '') {
                    style.invalid(element, 'This field is required', '', spanID);
                    helper.setFormStatus(element, false)
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }
            }
        },

        length: function (element, value, spanID) {

            if ((/length/).test(value)) {
                let length = value.split('=')[1];
                if (!(element.val().length >= length)) {

                    style.invalid(element, 'This value should be ' + length + ' characters', '', spanID);
                    helper.setFormStatus(element, false);
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }
            }

        },

        email: function (element, value, spanID) {

            if (element.val().length > 0) {
                let emil = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!(element.val().match(emil))) {
                    style.invalid(element, 'Enter valid email address', '', spanID);
                    helper.setFormStatus(element, false);
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }
            }
        },

        telephone: function (element, value, spanID) {
            let regx = /^[0-9]+$/;
            if (element.val().length > 0) {
                if (element.val().length < 10 || element.val().length > 10 || !(element.val().match(regx))) {
                    style.invalid(element, 'Enter a valid phone No (10 characters excluding +94)', '', spanID)
                    helper.setFormStatus(element, false);
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }
            }
        },

        password: function (element, passconfirmEl, value, spanID, passConSpanID) {
            if (element.val() !== '') {
                if (!(element.val() === passconfirmEl.val())) {

                    style.invalid(element, 'Passwords doesn\'t match', '', spanID);
                    style.invalid(passconfirmEl, 'Passwords doesn\'t match', '', passConSpanID);
                    helper.setFormStatus(element, false);
                    helper.setFormStatus(passconfirmEl, false);

                } else {
                    style.valid(element, '', spanID);
                    style.valid(passconfirmEl, '', passConSpanID);
                    helper.setFormStatus(element, true);
                    helper.setFormStatus(passconfirmEl, true);
                }
            }
        },

        number: function (element, value, spanID) {
            if (element.val() !== '') {
                let num = /^\d*$/;

                if (!(element.val().match(num))) {
                    style.invalid(element, 'Please enter only numbers', '', spanID);
                    helper.setFormStatus(element, false);
                } else {
                    style.valid(element, '', spanID);
                    helper.setFormStatus(element, true);
                }
            }
        },


        date: function (element, value, spanID) {
            function isValidDate(dateString) {
                // First check for the pattern
                var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

                if (!regex_date.test(dateString)) {
                    return false;
                }

                // Parse the date parts to integers
                var parts = dateString.split("-");
                var day = parseInt(parts[2], 10);
                var month = parseInt(parts[1], 10);
                var year = parseInt(parts[0], 10);

                // Check the ranges of month and year
                if (year < 1000 || year > 3000 || month == 0 || month > 12) {
                    return false;
                }

                var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                // Adjust for leap years
                if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)) {
                    monthLength[1] = 29;
                }

                // Check the range of the day
                return day > 0 && day <= monthLength[month - 1];
            }


            if (!isValidDate(element.val())) {
                style.invalid(element, 'Please enter correct date', '', spanID);
                helper.setFormStatus(element, false);

            } else {
                style.valid(element, '', spanID);
                helper.setFormStatus(element, true);
            }

        },


    };


    let style = {
        isValid: 'is-valid',
        isInvalid: 'is-invalid',
        validFeedback: 'valid-feedback',
        invalidFeedback: 'invalid-feedback-polyfill',

        invalid: function (selector, response, type, spanID) {

            if (type === 'radio') {
                $.each(helper.getRadioButtons(selector), function (key, value) {
                    $(value).removeClass(style.isValid).addClass(style.isInvalid);
                });

                $(spanID).removeClass(this.validFeedback).addClass(this.invalidFeedback).html(response);
            } else {
                selector.removeClass(this.isValid).addClass(this.isInvalid);
                $(spanID).removeClass(this.validFeedback).addClass(this.invalidFeedback).html(response);
            }


        },

        valid: function (selector, type, spanID) {
            if (type === 'radio') {
                $.each(helper.getRadioButtons(selector), function (key, value) {
                    $(value).removeClass(style.isInvalid).addClass(style.isValid);
                });
                $(spanID).removeClass(this.invalidFeedback).addClass(this.validFeedback).html('');
            } else {
                selector.removeClass(this.isInvalid).addClass(this.isValid);
                $(spanID).removeClass(this.invalidFeedback).addClass(this.validFeedback).html('');
            }

        },

        clear: function (selector, spanID) {
            selector.removeClass(this.isValid + ' ' + this.isInvalid);
            $(spanID).removeClass(this.invalidFeedback).addClass(this.validFeedback).html('');
        },

        addSpan: function (element, errorID, type) {
            //add validator text fields
            if (!document.body.contains(document.getElementById(errorID))) {

                let node = "<span class='' id=" + errorID + "></span>";

                if (type === 'radio') {
                    element.closest('.form-group').append(node)
                } else {
                    // element.after(node);
                    element.closest('.form-group').append(node)
                }
            }
        }
    };


    let helper = {


        runValidations: function (option, element, spanID, passwordConfirmID) {

            if (option === 'required') {
                check.required(element, spanID);
            } else if ((/length/).test(option)) {
                check.length(element, option, spanID);
            } else if (option === 'email') {
                check.email(element, option, spanID)
            } else if (option === 'password') {

                let attr = helper.getAttributes(passwordConfirmID);
                check.password(element, attr.element, option, spanID, attr.spanID);


                //register passwordcheck event for password confirm
                helper.registerEvent(attr.inputID, function () {
                    check.password(attr.element, element, attr.element.val(), attr.spanID, spanID);
                })


            } else if (option === 'telephone') {
                check.telephone(element, option, spanID)
            } else if (option === 'number') {
                check.number(element, option, spanID);
            }
        },

        getAttributes: function (id) {

            let inputID = '#' + id;
            let errorID = 'v-' + id;
            let spanID = '#' + errorID;
            let element = $(inputID);

            return attributes = {
                inputID: inputID,
                errorID: errorID,
                spanID: spanID,
                element: element
            }

        },

        registerEvent: function (inputID, callback, type) {

            let namespace = '.validator';

            let methods = 'change' + namespace + ' keyup' + namespace + ' click' + namespace + '';


            if (type === 'radio') {
                methods = 'change' + namespace + ''
            } else {
                $(document).off('.validator', inputID);
            }


            // attach validation scripts
            $(document).on(methods, inputID, callback)


        },

        shakeForm: function () {
            let cssClass = 'animated shake';
            if (options.animate !== false) {
                $('#' + options.formID).addClass(cssClass).delay(1000).queue(function (next) {
                    $(this).removeClass(cssClass);
                    next();
                });
            }
        },


        setFormStatus: function (element, status) {
            check.results[element[0].id] = status;
        },

        getOptionsLength: function () {

            return Object.keys(options.validate).length;
        },

        getResultsLength: function () {
            return Object.keys(check.results).length;
        },

        getLength: function (object) {
            return Object.keys(object).length;
        },

        getRadioButtons: function (element) {

            return element.closest('.form-group').find('input:radio');
        }


    };


    let init = function (registerEvents = true, callback) {

        let isModel = options['isModel'];

        if (options.validate) {


            if (Object.keys(options.validate).length > 0) {


                $.each(options.validate, function (id, validateOptions) {


                    let attributes = helper.getAttributes(id);


                    let inputID = attributes.inputID;
                    let errorID = attributes.errorID;
                    let spanID = attributes.spanID;
                    let element = attributes.element;

                    let validateMethods = validateOptions.methods.split('|');

                    if ($(inputID).length !== 0) {

                        let isVisible = element.is(":visible");

                        if(isModel){
                            isVisible = true;
                        }

                        if (isVisible) {


                            if (validateOptions.type === 'radio') {

                                //find radio buttons of the same name
                                let radioInputName = element.attr('name');

                                let allRadioButtons = $('[name="' + radioInputName + '"]');

                                style.addSpan(element, errorID, 'radio');


                                if (helper.getLength(allRadioButtons) > 0) {


                                    let attributes = helper.getAttributes(id);

                                    let _radioSpanID = attributes.spanID;

                                    $.each(allRadioButtons, function (index, radioButton) {


                                        let radioButtonID = $(radioButton).attr('id');

                                        let attributes = helper.getAttributes(radioButtonID);

                                        let _radioInputID = attributes.inputID;
                                        let _radioElement = attributes.element;

                                        if (registerEvents) {
                                            //attach validation scripts
                                            helper.registerEvent(_radioInputID, function () {
                                                helper.runValidations('required', _radioElement, _radioSpanID) //hardcoded required because of radio button
                                            },)
                                        } else {
                                            helper.runValidations('required', _radioElement, _radioSpanID)
                                        }


                                    })
                                }


                            } else if (validateOptions.type === 'password') {

                                let attributes = helper.getAttributes(validateOptions.passwordConfirmID);

                                let _passConfErrorID = attributes.errorID;
                                let _passConfElement = attributes.element;


                                style.addSpan(element, errorID);
                                style.addSpan(_passConfElement, _passConfErrorID);

                                if (registerEvents) {

                                    //attach validation scripts
                                    helper.registerEvent(inputID, function () {
                                        helper.runValidations('password', element, spanID, validateOptions.passwordConfirmID)
                                    });


                                } else {
                                    helper.runValidations('password', element, spanID, validateOptions.passwordConfirmID);

                                }

                            } else {

                                style.addSpan(element, errorID);

                                if (helper.getLength(validateMethods) > 0) {


                                    $.each(validateMethods, function (key, method) {


                                        if (registerEvents) {
                                            //attach validation scripts
                                            helper.registerEvent(inputID, function () {

                                                helper.runValidations(method, element, spanID)
                                            })
                                        } else {
                                            helper.runValidations(method, element, spanID)
                                        }

                                    })

                                }

                            }
                            if (callback) callback();

                        }

                    } else {
                        console.error('Warning! The input with ID ' + inputID + ' does not exist.')
                    }


                })


            }


        }
    };

    let getStatus = function () {


        //check options length and resulsts length
        // if (helper.getOptionsLength() !== helper.getResultsLength()) {

        init(false, function () {

            $.each(check.results, function (index, value) {
                if (value === false) {
                    check.formStatus = false;
                    return false
                } else {
                    check.formStatus = true;
                }
            });


        });
        // }


        if (check.formStatus === false) {
            helper.shakeForm()
        }


        return check.formStatus;

    };


    let resetForm = function () {

        $(':input', '#' + options.formID).not(':button, :submit, :reset, :hidden, :radio').val('').prop('checked', false).prop('selected', false);

        check.formStatus = false;

        // if (helper.getOptionsLength() !== helper.getResultsLength()) {
            // revert styles and form status
            $.each(check.results, function (id, value) {



                let attributes = helper.getAttributes(id);



                let spanID = attributes.spanID;
                let element = attributes.element;
                if (element.is('select')){
                    element.val(-1).trigger('change')
                }

                style.clear(element, spanID);

                if (check.results.hasOwnProperty(id)) {
                    delete check.results[id];
                }

            });


        // }


    };

    let setServerValidations = function (errors) {

        $.each(errors, function (index, value) {

            let attributes, spanID, element;

            if ($('#' + index).length === 0) { //element not found (radio buttons)

                let inputs = $('input[name="' + index + '"]');

                if (inputs.length !== 0) {


                    let id = $(inputs[0]).attr('id');

                    attributes = helper.getAttributes(id);
                    spanID = attributes.spanID;
                    element = attributes.element;
                    style.invalid(element, value, 'radio', spanID);
                }


            } else {
                attributes = helper.getAttributes(index);
                spanID = attributes.spanID;
                element = attributes.element;
                style.invalid(element, value, '', spanID);
            }


        })
    };


    return {
        init: init,
        results: check.results,
        status: getStatus,
        resetForm: resetForm,
        setServerValidations: setServerValidations,

    }


};


