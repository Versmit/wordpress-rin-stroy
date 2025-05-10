jQuery(document).ready(function($) {
    // Обработчик для кнопки "Добавить в список желаний"
    $('body').on('click', '.mywl-add-to-wishlist', function(e) {
        e.preventDefault();
        var button = $(this);
        var product_id = button.data('product-id');

        $.post(mywl_wishlist_ajax.ajax_url, {
            action: 'mywl_add_to_wishlist',
            product_id: product_id,
        }, function(response) {
            if (response.success) {
                alert(response.data);
            } else {
                alert('Ошибка: ' + response.data);
            }
        });
    });

    // Обработчик для кнопки "Удалить из списка желаний"
    $('body').on('click', '.mywl-remove-from-wishlist', function(e) {
        e.preventDefault();
        var button = $(this);
        var product_id = button.data('product-id');

        $.post(mywl_wishlist_ajax.ajax_url, {
            action: 'mywl_remove_from_wishlist',
            product_id: product_id,
        }, function(response) {
            if (response.success) {
                alert(response.data);
                location.reload(); // Обновляем страницу
            } else {
                alert('Ошибка: ' + response.data);
            }
        });
    });
});
