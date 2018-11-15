$('select[name="category_id"]').on('click', function() {
    var category_id = $(this).val();
    $.ajax({
        url : '/admin/select-ajax/' + category_id,
        type : 'GET',
        dataType : 'json',
        success :function(data) {
            $('select[name="topic_id"]').empty();
            $.each(data, function(key, topic) {
                $('select[name="topic_id"]').append(
                "<option value='" + topic.id + "'>" + topic.name + "</option>"
            );
          });
        }
    });
});