
function alertMessange(message, page) {
    alert(message);
    window.location.href = "" + page + "";
}
function alertMessange(message, page, name, isbn) {
    alert(message);
    window.location.href = "" + page + '?' + name + '=' + isbn + "";
}
function alertMessanges(message, page, name, isbn) {
    alert(message);
    window.location.href = "" + page + '?' + name + '=' + isbn + "";
}

