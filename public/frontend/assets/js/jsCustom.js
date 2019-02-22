// $(document).ready(function () {
//     alert(1);
// });

function redirectUrl(e) {
    // window.location.href = "trangchu.html";
    var q = document.URL.split('?')[1];
    var query = q;
    var baseURL = location.protocol + '//' + location.host + window.location.pathname;
    var newURL = "";
    var vars = [], hash;
    if (q !== undefined) {
        q = q.split('&');
        for (var i = 0; i < q.length; i++) {
            hash = q[i].split('=');
            vars.push(hash[1]);
            vars[hash[0]] = hash[1];
        }
    }
    if (e.value === 'default') {
        window.location.href = location.protocol + '//' + location.host + '/san-pham.html';
    } else {
        newURL = baseURL + "?" + e.value;
        if (vars['q'] !== undefined) {
            newURL = baseURL + "?q=" + vars['q'] + '&' + e.value;
        }
        window.location.href = newURL;
    }
}