"use strict";

var _token = $('meta[name="csrf_token"]').attr('content');

function set_record_id(id, selector) {

    $('#' + selector).val(id);

}

function deleteRecord(url, data, successMessage, place_selector) {

    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (result) {

            $('#ajax_success_message').show();

            $('#ajax_success_message').html(successMessage);

            $(place_selector).hide();

        }
    });

}

function deleteUser(id) {

    var url = APP_URL + '/users/' + id;

    var data = {
        'id': id,
        '_token': _token,
        '_method': 'delete'
    };

    var successMessage = 'این کاربر با موفقیت حذف شد.';

    var place_selector = "#tr" + id

    deleteRecord(url, data, successMessage, place_selector);

}


function deleteRole(id) {

    var url = APP_URL + '/roles/' + id;

    var data = {
        'id': id,
        '_token': _token,
        '_method': 'delete'
    };

    var successMessage = 'این نقش با موفقیت حذف شد.';

    var place_selector = "#tr" + id

    deleteRecord(url, data, successMessage, place_selector);

}

function deletePermission(id) {

    var url = APP_URL + '/permissions/' + id;

    var data = {
        'id': id,
        '_token': _token,
        '_method': 'delete'
    };

    var successMessage = 'این اجازه با موفقیت حذف شد.';

    var place_selector = "#tr" + id

    deleteRecord(url, data, successMessage, place_selector);

}

function deleteUserRole(user, role) {

    var url = APP_URL + '/deleteUserRole';

    var data = {
        'user': user,
        'role': role,
        '_token': _token,
        '_method': 'delete'
    };

    var successMessage = 'این نقش کاربر با موفقیت حذف شد.';

    var place_selector = "#button_" + user + '_' + role;

    deleteRecord(url, data, successMessage, place_selector);

}

function deleteComment(id) {

    var url = APP_URL + '/comments/' + id;

    var data = {
        'id': id,
        '_token': _token,
        '_method': 'delete'
    };

    var successMessage = 'این نظر با موفقیت حذف شد.';

    var place_selector = "#card" + id

    deleteRecord(url, data, successMessage, place_selector);

}

function inActiveUser(id) {

    var url = APP_URL + '/inActiveUser';

    var data = {
        'id': id,
        '_token': _token
    };

    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (result) {

            var successMessage = 'این کاربر با موفقیت غیر فعال شد.';

            $('#ajax_success_message').show();

            $('#ajax_success_message').html(successMessage);

            var new_button = '<i class="btn fas fa-user-check text-success" id="activeUser' + id + '" ' +
                'onclick="activeUser(' + id + ')" title="فعال کردن کاربر"></i>';

            $('#inActiveUser' + id).replaceWith(new_button);

            $('#active_status' + id).html('<div class="text-danger">' + 'غیر فعال' + '</div>');

        }
    });

}

function activeUser(id) {

    var url = APP_URL + '/activeUser';

    var data = {
        'id': id,
        '_token': _token
    };

    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (result) {

            var successMessage = 'این کاربر با موفقیت فعال شد.';

            $('#ajax_success_message').show();

            $('#ajax_success_message').html(successMessage);

            var new_button = '<i class="btn fa fa-user-lock text-dark" id="inActiveUser' + id + '" ' +
                'onclick="inActiveUser(' + id + ')" title="غیر فعال کردن کاربر"></i>';

            $('#activeUser' + id).replaceWith(new_button);

            $('#active_status' + id).html('<div class="text-success">' + 'فعال' + '</div>');

        }
    });

}

function addPermission(role, permission) {

    var url = APP_URL + "/roles/addPermission";

    var is_checked = $('input#permission' + permission).is(':checked');

    var data = {
        'role': role,
        'permission': permission,
        'is_checked': is_checked,
        '_token': _token,
    };

    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (result) {

            $('#ajax_success_message').show();

            if (is_checked) {

                var successMessage = "اجازه به نقش داده شد.";

                $('#label' + permission).addClass('text-dark');

            } else {

                var successMessage = "اجازه نقش حذف شد.";

                $('#label' + permission).removeClass('text-dark');

            }

            $('#ajax_success_message').html(successMessage);

        }
    });
}

function confirmComment(id) {

    $.ajax({
        url: 'comment/confirmComment/' + id,
        type: 'post',
        data: {
            '_token': _token,
        },
        success: function (result) {

            $('#ajax_success_message').show();

            $('#ajax_success_message').html('این نظر با موفقیت تایید شد.');

            $('#confirmed' + id).hide();

            //===حذف شدن متن پیام از لیست در صورتی که در صفحه نظرات تایید نشده باشیم.




        }

    });

}

function show_post_comments(id, confirmed) {

    $.ajax({
        url: 'posts/ post_comments',
        type: 'post',
        data: {
            'id': id,
            'confirmed': confirmed,
            '_token': _token,
        },
        success: function (result) {

            if (confirmed == '1') {

                $('#all_comments_tab').removeClass('active');
                $('#all_comments').removeClass('active');

                $('#confirmed_comments_tab').addClass('active');
                $('#confirmed_comments').addClass('active');
                $('#confirmed_comments').tab('show');
                $('#confirmed_comments').html(result);

                $('#not_confirmed_comments').removeClass('active');
                $('#not_confirmed_comments_tab').removeClass('active');


            } else if (confirmed == 0) {

                $('#all_comments_tab').removeClass('active');
                $('#all_comments').removeClass('active');

                $('#confirmed_comments_tab').removeClass('active');
                $('#confirmed_comments').removeClass('active');

                $('#not_confirmed_comments_tab').addClass('active');
                $('#not_confirmed_comments').addClass('active');
                $('#not_confirmed_comments').tab('show');
                $('#not_confirmed_comments').html(result);

            } else {

                $('#all_comments_tab').addClass('active');
                $('#all_comments').addClass('active');
                $('#all_comments').tab('show');
                $('#all_comments').html(result);

                $('#confirmed_comments_tab').removeClass('active');
                $('#confirmed_comments').removeClass('active');

                $('#not_confirmed_comments_tab').removeClass('active');
                $('#not_confirmed_comments').removeClass('active');

            }

        }
    });

}
