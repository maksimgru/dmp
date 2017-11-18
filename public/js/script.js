(function ($) {
    $(function () {
        var form = $('#add-user-form, #access-table-form');
        var filterUserForm = $('#filter-users-form');

        // Reset filter form
        filterUserForm.on('reset', function () {
            var resetBtn = filterUserForm.find('[type="reset"]');
            var redirectTo = resetBtn.attr('data-redirect-to');
            if (redirectTo) window.location = redirectTo;
            return true;
        });

        // Change select
        form.on('change', 'select', null, function () {
            var otherInput = $(this).siblings('.form-control.other');
            otherInput.addClass('hidden');
            if ($(this).find('option:selected').data('value') == 'other') {
                otherInput.removeClass('hidden');
            } else {
                otherInput.removeClass('invalid');
                $(this).siblings('.error').addClass('hidden');
            }
        });
        form.find('.form-control.other').on('keyup', function () {
            var newValue = $(this).val();
            $(this).siblings('select.form-control').children('option.other-value').val(newValue.toLocaleLowerCase());
        });

        // Add new form Items
        form.on('click', '.add-item', null, function () {
            var addItem = $(this);
            var lastItemIndex = addItem.attr('data-last-item-index');
            var formRow = addItem.closest('.form-row');
            var lastItem = formRow.find('.item').last();
            var templateItem = formRow.find('.item.template').last();
            var newItem = templateItem.clone().removeClass('hidden').removeClass('template');
            var newItemIndex = 1*lastItemIndex + 1;
            newItem.find('.form-control').each(function () {
                var formControl = $(this);
                var newAttrName = formControl.attr('name').replace(/(\[\d+\])/g, '[' + newItemIndex+ ']');
                var defaultVal = formControl.attr('data-default-val');
                formControl.attr('name', newAttrName);
                formControl.val(defaultVal);
                formControl.removeAttr('disabled');
            });
            newItem.find('.delete-item').removeClass('hidden');
            newItem.insertAfter(lastItem);
            addItem.attr('data-last-item-index', newItemIndex);
            return false;
        });

        // Delete form Items
        form.on('click', '.delete-item', null, function () {
            $(this).closest('.item').remove();
            return false;
        });

        // Submit Form
        form.on('submit', function (e) {
            var isValid = isValidForm(this);
            form.find('.form-message.error, .form-message.success').addClass('hidden');
            if (!isValid) {
                setTimeout(
                    function () {
                        alert('Error!!! Invalid some form field. Please correct fill form field and try again.');
                    }, 0);
                e.preventDefault();
                return false;
            }
        });

    }); // DOM ready





    // Function validation form
    function isValidForm (formElement) {
        var form = $(formElement);
        var errorsTotal = 0;
        form.find('.form-control:visible').each(function () {
            var formControl = $(this);
            var pattern = formControl.attr('pattern');
            var regexp = new RegExp(pattern, 'ig');
            var value = $.trim(formControl.val());
            var isValidControl = regexp.test(value);
            var $errorTargetSelector = formControl.attr('data-error-target');
            if (pattern) {
                if (isValidControl) {
                    formControl.removeClass('invalid');
                    if ($errorTargetSelector) formControl.siblings($errorTargetSelector).addClass('hidden');
                } else {
                    formControl.addClass('invalid');
                    if ($errorTargetSelector) formControl.siblings($errorTargetSelector).removeClass('hidden');
                    errorsTotal++;
                }
            }
        });
        return (errorsTotal == 0);
    }

})(jQuery); // self-invoked