$(document).ready(function () {
    //share blog
    $('.share-links__item.mail-share').click(function(e){
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
            title: 'Input email address',
            input: 'email',
            inputPlaceholder: 'Email address'
        }).then((result) => {
            if (result.isConfirmed) {
                loading('Blog been shared, please wait...');

                $.ajax({
                    url: '/blogs/share/email',
                    type: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        email: result.value,
                        id: id
                    },
                    success: (response)=>{
                        if (response.success) {
                            swal.fire('Success!', response.message, 'success');
                        } else {
                            swal.fire('Error!', 'Server error', 'error');
                        }
                    },
                    error: function(response) {
                        swal.fire('Error!', 'Server error', 'error');
                    }
                });
            }
        })
    })
    
    //update default payment method
    $('.set-default-method').click(function(e){
        e.preventDefault();
        let _this = $(this);
        if (_this.hasClass('disable')) {
            return;
        }
        loading();
        let method = _this.data('method');
        $.ajax({
            url: `/account/payment-method/${method}/default`,
            type: 'put',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response)=>{
                if (response.success) {
                    swal.fire('Success!', response.message, 'success');
                    $('.set-default-method').removeClass('disable');
                    _this.addClass('disable');
                } else {
                    swal.fire('Error!', 'Server error', 'error');
                }
            },
            error: function(response) {
                swal.fire('Error!', 'Server error', 'error');
            }
        });
    })
    
    //delete payment method
    $('.delete-method').click(function(e){
        e.preventDefault();
        loading();
        let _this = $(this);
        let method = _this.data('method');
        $.ajax({
            url: `/account/payment-method/${method}/destroy`,
            type: 'post',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response)=>{
                if (response.success) {
                    swal.fire('Success!', response.message, 'success');
                    _this.closest('tr').remove();
                } else {
                    swal.fire('Error!', 'Server error', 'error');
                }
            },
            error: function(response) {
                swal.fire('Error!', 'Server error', 'error');
            }
        });
    })

    // change pricing interval tabs
    $('.pricing-actions__item').click(function(){
        let interval = $(this).data('interval');
        $('.pricing-actions__item').removeClass('active');
        $(this).addClass('active');
        $('.pricing-plans').addClass('d-none');
        $(`.pricing-plans[data-interval=${interval}]`).removeClass('d-none');
    })

    //cancel subscription
    $(document).on('click', '.cancel-subscription', function (e) {
        e.preventDefault();
        let sub = jQuery(this).data('subscription');
        let container = jQuery(this).closest('.list-subscription');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                loading();
                $.ajax({
                    url: `/api/v1/subscription/${sub}`,
                    type: 'post',
                    data: {
                        _method: 'DELETE',
                        api_token: $("[name='api_token']").attr("content")
                    },
                    success: (response)=>{
                        if (response.success) {
                            swal.fire("Success!", response.message, 'success');
                            container.removeClass('active');
                            container.find('.active-subscription-label').text('Active (canceled)');
                            container.find('.subscription-item .actions .cancel-subscription').remove();
                        } else {
                            swal.fire("Error!", response.message, 'error');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        swal.fire("Error!", '', 'error');
                    }
                });
            }
        });
    })
});

function loading(text='Request been processed...') {
    swal.fire({
        title: 'Wait!',
        text: text,
        didOpen: () => {
            swal.showLoading();
        },
        showConfirmButton: false,
        allowOutsideClick: false
    });
}

// general error logic, after ajax form submit been processed
function showServerError(response) {
    var $ = jQuery.noConflict();
    if (response.status == 422) {
        for (const [field, value] of Object.entries(response.responseJSON.errors)) {
            let errorText = '';
            let errorElement = $(`.input-error[data-input=${field}]`);
            errorElement = errorElement.length ? errorElement : $(`.input-error[data-input="${field}[]"]`);
            errorElement = errorElement.length ? errorElement : $(`[name=${field}]`).closest('.form-group').find('.input-error');
            errorElement = errorElement.length ? errorElement : $(`[name="${field}[]"]`).closest('.form-group').find('.input-error');
            for (const [key, error] of Object.entries(value)) {
                errorText = errorText ? errorText+'<br>'+error : error;
            }
            errorElement.html(errorText);
        }
    } else {
        swal.fire('Error!', 'Server error', 'error');
    }
}