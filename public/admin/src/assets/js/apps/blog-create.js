/**
 * ===================================
 *    Blog Description Editor
 * ===================================
*/

const descriptionElement = document.querySelector('#blog-description');
const hiddenInput = document.querySelector('#input-blog-description');

if (descriptionElement && hiddenInput) {

    const quill = new Quill(descriptionElement, {
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        placeholder: 'محتوا ...',
        theme: 'snow'
    });

    // مقدار قبلی مقاله در صفحه ویرایش
    if (hiddenInput.value) {
        quill.clipboard.dangerouslyPasteHTML(
            hiddenInput.value
        );
    }

    // انتقال محتوای Quill به textarea مخفی
    quill.on('text-change', function () {
        const html = quill.root.innerHTML;

        hiddenInput.value = html === '<p><br></p>'
            ? ''
            : html;
    });
}




/**
 * ====================
 *      File Pond
 * ====================
*/

// We want to preview images, so we register
// the Image Preview plugin, We also register
// exif orientation (to correct mobile image
// orientation) and size validation, to prevent
// large files from being added
// FilePond.registerPlugin(
//     FilePondPluginImagePreview,
//     FilePondPluginImageExifOrientation,
//     FilePondPluginFileValidateSize,
//     // FilePondPluginImageEdit
// );
//
// // Select the file input and use
// // create() to turn it into a pond
// // var ecommerce = FilePond.create(document.querySelector('.file-upload-multiple'));
//
// document.querySelectorAll('.file-upload-multiple').forEach(function (inputElement) {
//     const existingFile = inputElement.dataset.existingFile;
//
//     const pond = FilePond.create(inputElement, {
//         storeAsFile: true,
//         allowMultiple: inputElement.multiple,
//         maxFiles: inputElement.dataset.maxFiles || null,
//         allowReorder: inputElement.dataset.allowReorder === 'true',
//
//         server: {
//             load: (source, load, error, progress, abort, headers) => {
//
//                 fetch(source)
//                     .then((response) => {
//                         if (!response.ok) {
//                             throw new Error('Failed to load: ' + response.status);
//                         }
//                         return response.blob();
//                     })
//                     .then((blob) => {
//                         load(blob);
//                     })
//                     .catch((err) => {
//                         error(err);
//                     });
//
//                 return {
//                     abort: () => {
//                         abort();
//                     },
//                 };
//             },
//         },
//
//         files: existingFile
//             ? [
//                 {
//                     source: existingFile,
//                     options: { type: 'local' },
//                 },
//             ]
//             : [],
//     });
//
// });

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize
);

document.querySelectorAll('.file-upload-multiple').forEach(function (inputElement) {

    const pond = FilePond.create(inputElement, {
        storeAsFile: true,
        allowMultiple: false,
        maxFiles: 1,
        allowReorder: false,
    });

    const existingFile = inputElement.dataset.existingFile;

    if (existingFile) {
        pond.addFile(existingFile);
    }

});
/**
 * =====================
 *      Blog Tags
 * =====================
*/
// The DOM element you wish to replace with Tagify
var input = document.querySelector('.blog-tags');

// initialize Tagify on the above input node reference
new Tagify(input)


/**
 * =======================
 *      Blog Category
 * =======================
*/
// var input = document.querySelector('input[name=category]');

// new Tagify(input, {
//     whitelist: ["Themeforest","Admin","Dashboard","Laravel","Sale","Vue","React","Cork Admin"],
//     userInput: false
// })

document.querySelectorAll('.select-beast').forEach((element) => {
    new TomSelect(element, {
        create: true,
        sortField: {
            field: 'text',
            direction: 'asc',
        },
    });
});
