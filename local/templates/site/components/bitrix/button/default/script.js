(function() {
    var buttons = document.getElementsByClassName('js-general-button');
    console.log(buttons.length);
    for(var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function() {
            alert('click');
        });
    }
})();
