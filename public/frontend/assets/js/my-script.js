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
        type: "danger",
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

function addFavorite(id) {
    var objProductFavorite = [];
    if (localStorage.getItem("favoriteProduct")) {
        objProductFavorite = JSON.parse(localStorage.getItem("favoriteProduct"));
        let flag = objProductFavorite.filter((obj) => {
            return obj.id === id
        });
        if (flag.length == 0) {
            objProductFavorite.push({id});
            localStorage.setItem("favoriteProduct", JSON.stringify(objProductFavorite));
            successMsg("Thêm sản phẩm vào danh sách yêu thích thành công");
            return;
        }
        errorMsg("Đã có sản phẩm này ở trong danh sách yêu thích");
    }
    else {
        objProductFavorite.push({id: id});
        localStorage.setItem("favoriteProduct", JSON.stringify(objProductFavorite));
        successMsg("Thêm sản phẩm vào danh sách yêu thích thành công");
    }
}

function removeWishlistProduct(id) {
    var obj = JSON.parse(localStorage.getItem("favoriteProduct"));
    console.log(obj, id);
    var objProductFavorite = obj.filter((item) => {
        return item.id != id;
    });

    localStorage.setItem("favoriteProduct", JSON.stringify(objProductFavorite));
    successMsg("Xóa sản phẩm yêu thích thành công");
    setTimeout("location.reload(true);", 1000);
}


$(document).ready(function() {

});
