$(document).ready(function () {
    $('.rii-content-input').change(function(e) {
        e.preventDefault();
        showFile(this);
    });

    $('.rii-box').click(function(e) {
        e.preventDefault();
        let wraper = riiWraper(this);
        wraper.find('.rii-content-input').trigger('click');
    });

    document.querySelectorAll('.rii-box').forEach(function (dropBox) {
        dropBox.addEventListener('drop', handleDrop)
    });

    $('.rii-box').on('dragover', function(e) {
        e.preventDefault();
    });
});

function riiWraper(el) {
    return $(el).closest('.rii-wrapper');
}

function handleDrop(e) {
    e.preventDefault();

    let file = e.dataTransfer.items[0].getAsFile();

    // Create a new DataTransfer object
    let dataTransfer = new DataTransfer();

    // Add the file to the DataTransfer object
    dataTransfer.items.add(file);

    // Find the file input element
    let fileInput = riiWraper(this).find('.rii-content-input')[0];

    // Assign the DataTransfer object to the file input element
    fileInput.files = dataTransfer.files;

    showFile(e.target);
}

function showFile(el) {
    let wraper = riiWraper(el);
    let input = wraper.find('.rii-content-input');

    // show file name
    let name = input.val().split('\\').pop();
    wraper.find('.rii-filename').val(name);

    // make file alt and title
    name = name.split('.');
    name = name.length==1 ? name[0] : name.slice(0, -1).join('.');
    name = name.replace(/-/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    wraper.find('.rii-filealt').val(name);
    wraper.find('.rii-filetitle').val(name);

    // show file preview
    const [file] = input[0].files;
    if (!file) {
        return;
    }
    el = wraper.find('.rii-box img');
    wraper.find('.rii-box span').addClass('d-none');
    wraper.find('.rii-box img').removeClass('d-none').attr('src', URL.createObjectURL(file));
}