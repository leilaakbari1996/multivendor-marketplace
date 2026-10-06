$(document).on('click', '.delete-item', function (e) {
    e.preventDefault();

    const button = $(this);
    const url = button.data('url');

    if (!url) {
        console.error('Delete URL is missing.');
        return;
    }

    confirmDelete().then((result) => {
        if (!result.isConfirmed) {
            return;
        }

        console.log('DELETE URL:', url);
        Ajax.delete(url)
            .done(function (response) {
                toast.success(
                    response.message ?? 'با موفقیت حذف شد.'
                );

                $('#list').DataTable().ajax.reload(null, false);
            })
            .fail(function (xhr) {
                toast.error(
                    xhr.responseJSON?.message ?? 'حذف انجام نشد.'
                );
            });
    });
});
