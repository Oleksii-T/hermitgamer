$(document).ready(function () {
    $('.more-posts').click(function(e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass('cursor-wait')) {
            return;
        }
        btn.addClass('cursor-wait');
        let page = btn.data('page');

        $.ajax({
            url: '/posts/more',
            type: 'get',
            data: {
                page: page,
                category: btn.data('category')
            },
            success: (response)=>{
                btn.removeClass('cursor-wait');
                btn.closest('.blog-news__body').find('.blog-news__row').append(response.data.posts);
                btn.data('page', page+1);
                if (response.data.isLast) {
                    btn.addClass('d-none');
                }
            },
            error: function(response) {
                btn.removeClass('cursor-wait');
                swal.fire("Oops!", 'Something goes wrong, please try again later', 'error');
            }
        });
    })
});
