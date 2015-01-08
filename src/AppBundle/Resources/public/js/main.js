$(document).keypress(function(e) {
    var $block = $('#write-tags-number');
    if (e.which == 13 && $block.val() != "" && isInt( $block.val() )) {
        var i,
            number = parseInt( $('#write-tags-number').val() ),
            tags = '',
            li0 = '<li class="tag"><input type="text" class="form-control" name="tag[',
            li1 = ']"/><input class="btn btn-primary" type="button" value="X"/></li>';
        for (i = 0; i < number; i++) {
            tags = tags + li0 + i + li1;
        }
        $('#writing-tags').html(tags).after('<input id="adding-tags-button" type="button" class="btn btn-primary" value="Add tag"/>');
        $('#adding-tags-button').on('click', function() {
            $('#writing-tags').append(li0 + i + li1);
            i++;
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
$(document).keypress(function(e) {
    if(e.which == 13) {
        e.target.preventDefault();
    }
});
$('#submit_send').keypress(function(e) {
    if (e.which == 13) {
        e.target.preventDefault();
    }
});
function isInt(n){
    n = parseInt(n);
    return Number(n) === n && n % 1 === 0;
}

//$.get( "ajax/test.html", function( data ) { data += 1; }).post( "ajax/test.html", data);