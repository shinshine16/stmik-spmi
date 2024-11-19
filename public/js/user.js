sessionStorage.clear();

var slug, kategori, pejabat, jenis_dokumen, tahun, status, publish

$(document).ready(function () {
    table()
    var active = $('.for-active-sidebar').val()
    $('#' + active).addClass('active')
})

$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})

function table() {
    slug = $('#slug').val()
    kategori = $('#filter_kategori').val()
    pejabat = $('#filter_pejabat').val()
    jenis_dokumen = $('#filter_jenis_dokumen').val()
    tahun = $('#filter_tahun').val()
    status = $('#filter_status').val()
    publish = $('#filter_publish').val()
    $('#datatable').DataTable().destroy();
    dTable = $('#datatable').DataTable({
        columnDefs: [{
            'targets': [0], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            className: 'table__td'
        }, ],
        "ordering": false,
        "dom": "lrtip",
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + '/user-data',
            "dataType": "json",
            "data": function (d) {
                d.slug = slug;
                d.kategori = kategori;
                d.pejabat = pejabat;
                d.jenis_dokumen = jenis_dokumen;
                d.tahun = tahun;
                d.status = status;
                d.publish = publish;
            },
            "type": 'GET'
        }
    });
    $('#datatable').wrapAll('<div class="content-scroll"></div>');
    $('#datatable_info').addClass('col-sm-6');
    $('#datatable_paginate').addClass('pull-right');
}

$('#myCustomSearchBox').keyup(function () {
    dTable.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
})


$(document).on('change', '#filter_kategori, #filter_pejabat, #filter_jenis_dokumen, #filter_tahun, #filter_status, #filter_publish', function () {
  table()
});

$(document).on('click', '.openModal', function () {
    var id = $(this).data('id')
    $.ajax({
        url: base_url + '/user-data-id',
        method: "get",
        data: {
            id: id
        },
        success: function (res) {
            var hasil = $.parseJSON(res);
            if (hasil['status'] == 'success') {
                $('#dataModal').modal('show');
                $("#exampleModalLabel").html('Keterangan Dokumen');
                $("#keterangan").html(hasil['data'][0]['keterangan']);
            } else {
                console.log(hasil['pesan'])
            }
        },
        error: function (res) {
            console.log('error')
        },
    });
});

$(document).on('click', '.download-file', function () {

    var id = $(this).data('id')
    $.ajax({
        url: base_url + '/user-download',
        method: "GET",
        data: {
            id: id
        },
        success: function (res) {
            var hasil = $.parseJSON(res);
            if (hasil['status'] == 'success') {
                window.open(hasil['path'], '_blank');
            } else {
                toastr.warning(hasil['message'])
            }
        },
        error: function (res) {
            console.log('error')
        },
    });
});

$("tbody").click(function (evt) {

    if (evt.target.className == 'subSelect')

    {

        if (sessionStorage.getItem('count') == 'NaN' || sessionStorage.getItem('count') == null)

        {

            sessionStorage.setItem('count', 0);

        }

        if (evt.target.checked == true)

        {
            $('#datatable_paginate').addClass('d-none');

            $('#datatable_length').addClass('d-none');

            $('.toolbox').addClass('d-none');

            $('.items-more').addClass('d-none');

            let input_ = document.createElement('input');

            input_.setAttribute('type', 'hidden');

            input_.setAttribute('value', 'selected_' + evt.target.defaultValue);

            input_.setAttribute('name', 'data[]');

            $('#input-selected').append(input_);

            sessionStorage.setItem('count', parseInt(sessionStorage.getItem('count')) + 1);

            $('.MYbounce').show();

            $('body').css('background', 'rgba(46, 49, 49, 1)');

            if ($('#template').data('theme') == 'light') {
                $('#title_page').css('color', 'rgba(249, 250, 251, 1)');
            }

            $('#fixedbutton').show();

            $('#fixedbutton2').show();

            $('#fixedbutton3').show();

        } else {

            $('#datatable_paginate').removeClass('d-none');

            $('#datatable_length').removeClass('d-none');

            $('.toolbox').removeClass('d-none');

            $('.items-more').removeClass('d-none');

            $("input[value='selected_" + evt.target.defaultValue + "']").remove();

            if (sessionStorage.getItem('count') == 1)

            {

                $('.MYbounce').hide();

                if ($('#template').data('theme') == 'light') {
                    $('body').css('background', 'rgba(249, 250, 251, 1)');
                    $('#title_page').css('color', 'rgba(68, 85, 108, 1)');
                } else {
                    $('body').css('background', 'rgba(21, 35, 46, 1)');
                }

                $('#fixedbutton').hide();

                $('#fixedbutton2').hide();

                $('#fixedbutton3').hide();

            }

            sessionStorage.setItem('count', parseInt(sessionStorage.getItem('count')) - 1);

        }

        $('#counter-selected').html(sessionStorage.getItem('count'));
        $('#text-selected').css('color', 'rgba(249, 250, 251, 1)');
        $(".MYbounce").effect("bounce", {
            times: 2
        }, 100);

    }

});
