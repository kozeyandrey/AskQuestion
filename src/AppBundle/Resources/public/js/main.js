$(document).keypress(function(e) {
    var $block = $('#write-tags-number');
    if (e.which == 13 && $block.val() != "" && isInt( $block.val() )) {
        var i,
            number = parseInt( $('#write-tags-number').val() ),
            tags = '',
            li = '<li class="tag"><input type="text" class="form-control" name="tag"/><input type="button" class="btn btn-primary" value="X"/></li>';
        for (i = 0; i < number; i++) {
            tags = tags + li;
        }
        $('#writing-tags').html(tags).after('<input id="adding-tags-button" type="button" class="btn btn-primary" value="Add tag"/>');
        $('#adding-tags-button').on('click', function() {
            $('#writing-tags').append(li);
            $('#writing-tags input[type=button]').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('#writing-tags input[type=button]').on('click', function() {
            $(this).parent().remove();
        });
        $('#write-tags-number').val('');
    }
});

function isInt(n){
    n = parseInt(n);
    return Number(n) === n && n % 1 === 0;
}