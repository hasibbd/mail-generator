$(document).ready(function () {
    var base = window.location.origin;
    $('#call_modal').on('click', function () {
        $(".modal").modal('toggle');
    })
    $('#form4submit').submit(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = new FormData(this);
        var my_url = base + "/add-user";


        $.ajax({
            type: 'post',
            url: my_url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $(".modal").modal('toggle');
                $('#form4submit')[0].reset();
                $(".table").load(location.href + " .table");

            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});
