$(document).ready(function () {
    $(document).on('change', '.rii-content-input', function (e) {
        e.preventDefault();
        showFile(this);
    });

    $(document).on('click', '.rii-box', function (e) {
        e.preventDefault();
        let wraper = riiWraper(this);
        wraper.find('.rii-content-input').trigger('click');
    });

    document.querySelectorAll('.rii-box').forEach(function (dropBox) {
        dropBox.addEventListener('drop', handleDrop)
    });

    $(document).on('dragover', '.rii-box', function (e) {
        e.preventDefault();
    });

    $(document).on('click', '.rii-multiple-add', function (e) {
        e.preventDefault();
        let wraper = $(this).parent().find('.rii-multiple-wrapper');
        let clone = wraper.find('.rii-wrapper').first().clone();
        clone.find('input').val(''); // clear inputs
        clone.find('.rii-box span').removeClass('d-none'); // remove image visualization
        clone.find('.rii-box img').addClass('d-none').attr('src', ''); // remove image visualization
        clone.find('.rii-box').get(0).addEventListener('drop', handleDrop); // add event for drag&drop
        wraper.append(clone);
    })

    $(document).on('click', '.rii-wrapper-multiple-remove', function (e) {
        e.preventDefault();
        let wraper = $(this).closest('.rii-multiple-wrapper');
        let item = $(this).closest('.rii-wrapper');

        if (wraper.find('.rii-wrapper').length > 1) {
            item.remove();
            return;
        }

        item.find('input').val('');
        item.find('.rii-box span').removeClass('d-none');
        item.find('.rii-box img').addClass('d-none').attr('src', '');
    })
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

    wraper.find('.rii-box span').addClass('d-none');
    wraper.find('.rii-box img').removeClass('d-none').attr('src', URL.createObjectURL(file));
}