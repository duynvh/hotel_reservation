function successMsg(msg){
    $.notify({
        // options
        icon: 'glyphicon glyphicon-ok',
        title: msg,
        message: '',
    },{
        //setting
        type: "success",
        placement: {
            from: "bottom",
            align: "right"
        },
        allow_dismiss: false,
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '</div>'
    });
}

function errorMsg(msg){
    $.notify({
        // options
        icon: 'glyphicon glyphicon-remove',
        title: msg,
        message: '',
    },{
        //setting
        type: "error",
        placement: {
            from: "bottom",
            align: "right"
        },
        allow_dismiss: false,
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '</div>'
    });
}

function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ""); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđñç·/_,:;";
    var to   = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyydnc------";

    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
        .replace(/\s+/g, "-") // collapse whitespace and replace by -
        .replace(/-+/g, "-") // collapse dashes
        .replace(/^-+/, "") // trim - from start of text
        .replace(/-+$/, ""); // trim - from end of text

    return str;
}

$(document).ready(function() {
    //Multi Select
    $('.select-category').select2();
    //Show message
    $('.ui-pnotify').remove();
    $('button.status').click(function(){
        $.notify({
            // options
            icon: 'glyphicon glyphicon-ok',
            title: 'Trạng thái đã thay đổi thành công!',
            message: '',
        },{
            //setting
            type: "success",
            placement: {
                from: "bottom",
                align: "right"
            },
            allow_dismiss: false,
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            },
            template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '</div>'
        });
    });
    //popup
    $('#preview').popup();
    $('.btn-preview').click(function(){
        $('#preview').popup('show');
    });
    $('.btn-close').click(function(){
        $('#preview').popup('hide');
    })
    //datePicker
    $('#dateSaleOff').datetimepicker({
        format: 'DD.MM.YYYY'
    });
});
//Show TotalCheck
function showTotalCheck(number){
    if(number < 1){
        $('span.btn-show-total').text('');
    }else{
        $('span.btn-show-total').text(number);
    }
}

function previewSelectImage(input, location = 'imagePreview') {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + location)
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);

        if ($('#' + location).hasClass('hidden')) {
            $("#" + location).removeClass('hidden');
        }
    }
}
