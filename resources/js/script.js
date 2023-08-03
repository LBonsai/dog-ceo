$(document).ready(function() {
    var sMethod = 'POST';
    var iCurrentId = 0;
    var sConfirmationMessage = 'Are you sure you want to register this data?';
    var sUrl = '/api/dogs';
    var sAlertMessage = 'Registration successful';
    var sErrorMessages = 'There is an error while saving new data.'

    /**
     * Automatically includes CSRF token in AJAX requests
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadDogTable();

    /**
     * Set tags to its initial text and value once the modal is closed
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $('#formModal').on('hidden.bs.modal', function () {
        resetToInitialData();
    });

    /**
     * Insert or update data upon clicking of the submit button
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $('#btn-save').click(function() {
        if (confirm(sConfirmationMessage) === true) {
            const oFormData = validateFields();
            if (oFormData.bIsValid === true) {
                if (sMethod === 'PUT') {
                    oFormData.form_data['id'] = iCurrentId;
                }

                $.ajax({
                    url: sUrl,
                    method: sMethod,
                    data: oFormData.form_data,
                    success: function() {
                        alert(sAlertMessage);
                        $('#formModal').modal('hide');
                        resetToInitialData();
                        loadDogTable();
                    },
                    error: function(oErrorResponse) {
                        if (oErrorResponse.status === 422) {
                            alert(sErrorMessages);
                            displayBackendErrorMessages(oErrorResponse.responseJSON.errors);
                        } else {
                            alert(oErrorResponse.responseJSON.message);
                        }
                    }
                });
            }
        }
    });

    /**
     * Fetch data by id and populate the update form
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $('#data-list').on('click', '#edit-btn', function() {
        let sDataId = $(this).data('id');

        $.ajax({
            url: '/api/dogs/' + sDataId + '/edit',
            method: 'GET',
            success: function(oSuccessResponse) {
                sMethod = 'PUT';
                sConfirmationMessage = 'Are you sure you want to update data?';
                sUrl = '/api/dogs/' + sDataId;
                iCurrentId = parseInt(sDataId, 10);
                sAlertMessage = 'Modification successful';
                sErrorMessages = 'There is an error while updating data.'
                $('#formModal .modal-title').text('Update Form');
                $('#formModal #name').val(oSuccessResponse['name']);
                $('#formModal #url').val(oSuccessResponse['url']);
                $('#formModal #btn-save').text('Update');
                $('#formModal').modal('show');
            },
            error: function() {
                alert('There is an error while retrieving the data from the database. Please try again.');
            }
        });
    });

    /**
     * Delete data once button for delete is clicked
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $('#data-list').on('click', '#delete-btn', function() {
        if (confirm('Are you sure you want to delete this data?') === true) {
            let sDataId = $(this).data('id');

            $.ajax({
                url: '/api/dogs/' + sDataId,
                type: 'DELETE',
                success: function() {
                    alert('Data deleted successfully.');
                    loadDogTable();
                },
                error: function() {
                    alert('There is an error while deleting the data.');
                }
            });
        }
    });

    /**
     * Fetch random image from Dog Ceo API
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    $('#fetch-image').click(function() {
        let bIsButtonClicked = false;
        if (bIsButtonClicked === true) {
            return false;
        }

        $.ajax({
            url: '/api/dogs/ceo/image',
            method: 'GET',
            success: function(oSuccessResponse) {
                $('#displayedImage').attr('src', oSuccessResponse);
            },
            error: function(oErrorResponse) {
                alert(oErrorResponse.responseJSON.message);
            },
            complete: function() {
                bIsButtonClicked = false;
            }
        });
    });

    /**
     * loadDogTable
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    function loadDogTable() {
        let sNoDataRow = `
            <tr>
                <td colspan="3" class="text-center">No data found</td>
            </tr>
        `;

        $('#data-list').empty();

        $.ajax({
            url: '/api/dogs',
            method: 'GET',
            dataType: 'json',
            success: function (oSuccessResponse) {
                if (window._.isEmpty(oSuccessResponse) === false) {
                    oSuccessResponse.forEach(function (oData) {
                        let sRow = `
                            <tr>
                                <td>${ oData.name }</td>
                                <td>${ oData.url }</td>
                                <td>
                                    <button type="button" class="btn btn-primary" id="edit-btn" data-id="${ oData.id }">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" id="delete-btn" data-id="${ oData.id }">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('#data-list').append(sRow);
                    });
                } else {
                    $('#data-list').append(sNoDataRow);
                }
            },
            error: function () {
                $('#data-list').append(sNoDataRow);
            }
        });
    }

    /**
     * validateFields
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     * @return {object}
     */
    function validateFields() {
        let oFormData = {};

        // Trim input tag value
        $('input', $('#data-form')).each(function() {
            oFormData[$(this).attr('id')] = $.trim($(this).val());
        });

        if (checkIfEmpty(oFormData) === false || checkIfValidCharactersAndLength(oFormData) === false) {
            return {
                form_data : {},
                bIsValid  : false
            };
        }

        return {
            form_data : oFormData,
            bIsValid  : true
        };
    }

    /**
     * checkIfEmpty
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     * @param oFormData
     * @returns {boolean}
     */
    function checkIfEmpty(oFormData) {
        let bIsValid = true;
        $.each(oFormData, function(sKey, sValue) {
            if (sValue === '') {
                let sField = (sKey === 'url') ? sKey.toUpperCase() : sKey.charAt(0).toUpperCase() + sKey.slice(1);
                alert(sField + ' is a required field.');
                bIsValid = false;
            }
        });

        return bIsValid;
    }

    /**
     * checkIfValidCharactersAndLength
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     * @param oFormData
     * @returns {boolean}
     */
    function checkIfValidCharactersAndLength(oFormData) {
        let bIsValid = true;
        const oErrorMessages = {
            name : 'Name should only contain letters, spaces. It must be between 1 and 50 characters long.',
            url  : 'URL must be in the format "https://"'
        }

        const oValidationRules = {
            name : new RegExp('^[A-Za-z ]{1,50}$'),
            url  : new RegExp('^https:\\/\\/')
        };

        $.each(oFormData, function(sKey, sValue) {
            if (oValidationRules.hasOwnProperty(sKey) === true && oValidationRules[sKey].test(sValue) === false) {
                alert(oErrorMessages[sKey]);
                bIsValid = false;
            }
        });

        return bIsValid;
    }

    /**
     * displayBackendErrorMessages
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     * @param {object} oErrors
     */
    function displayBackendErrorMessages(oErrors) {
        $.each(oErrors, function(sField, oMessages) {
            alert(oMessages.join(''));
        });
    }

    /**
     * setToInitialData
     * @author Lee Benedict F. Baniqued
     * @since 2023.08.02
     */
    function resetToInitialData() {
        sMethod = 'POST';
        iCurrentId = 0;
        sConfirmationMessage = 'Are you sure you want to register this data?';
        sUrl = '/api/dogs';
        sAlertMessage = 'Registration successful';
        sErrorMessages = 'There is an error while saving new data.'
        $('#name').val('');
        $('#url').val('');
        $('#formModal .modal-title').text('Register Form');
        $('#formModal #btn-save').text('Create');
    }
});
