sessionStorage.clear();

var kategori, pejabat, jenis_dokumen, tahun, status, publish

$(document).ready(function () {
    table()
    var active = $('.for-active-sidebar').val()
    $('#' + active).addClass('active')
})

function table() {
    kategori = $('#filter_kategori').val()
    pejabat = $('#filter_pejabat').val()
    jenis_dokumen = $('#filter_jenis_dokumen').val()
    tahun = $('#filter_tahun').val()
    status = $('#filter_status').val()
    publish = $('#filter_publish').val()
    $('#datatable').DataTable().destroy();
    dTable = $('#datatable').DataTable({
        // "pagingType": "simple",
        // oLanguage: {
        //     oPaginate: {
        //       sPrevious: '<div class="table-wrapper__pagination col-auto"><ol class="pagination"><li class="pagination__item"><a class="pagination__arrow pagination__arrow--prev" href="#"><svg class="icon-icon-keyboard-left"><use xlink:href="#icon-keyboard-left"></use></svg></a></li>',
        //       sNext: '<li class="pagination__item"><a class="pagination__arrow pagination__arrow--next" href="#"><svg class="icon-icon-keyboard-right"><use xlink:href="#icon-keyboard-right"></use></svg></a></li></ol></div>',
        //     }
        // },
        // "bLengthChange": false,
        columnDefs: [{
            'targets': [0],
            'orderable': false,
            className: 'table__td'
        },],
        "ordering": false,
        "dom": "lrtip",
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + '/admin-document-data',
            "type": 'POST',
            "dataType": "json",
            "data": function (d) {
                d.kategori = kategori;
                d.pejabat = pejabat;
                d.jenis_dokumen = jenis_dokumen;
                d.tahun = tahun;
                d.status = status;
                d.publish = publish;
            }

        }
    });
}

// $(document).on('change', '#filter_kategori, #filter_pejabat, #filter_jenis_dokumen, #filter_tahun, #filter_status, #filter_publish', function () {
//     $('#myCustomSearchBox').val('')
//     table()
// });
$('#myCustomSearchBox').keyup(function () {
    dTable.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
})


$(document).on('change', '#filter_kategori, #filter_pejabat, #filter_jenis_dokumen, #filter_tahun, #filter_status, #filter_publish', function () {
    table()
});

$("#proses_data").click(function () {
    $('.loading').show();
    var data = {
        proses: $("#proses").val(),
        enc_id: $("#enc_id").val(),
        old_file: $("#old_file").val(),
        old_token: $("#old_token").val(),
        terbit: $(".terbit.active").data('set'),
        no_sk: $("#no_sk").val(),
        nama_standar: $("#nama_standar").val(),
        kategori: $("#kategori").val(),
        pejabat: $("#pejabat").val(),
        jenis_dokumen: $("#jenis_dokumen").val(),
        tahun: $("#tahun").val(),
        status: $(".status.active").data('set'),
        keterangan: $("#keterangan").text(),
        file: $('#enc_name').val()
    }
    $.ajax({
        url: base_url + '/admin-document-proses',
        method: "POST",
        data: data,
        success: function (res) {
            var hasil = $.parseJSON(res);
            if (hasil['status'] == 'success') {
                $('.loading').hide();
                $('#modalDocument').removeClass('is-active is-animate');
                toastr.success(hasil['pesan'])
                setTimeout(function () {
                    location.reload(true);
                }, 1500);
            } else if (hasil['status'] == 'validate') {
                $('.loading').hide();
                $.each(hasil['pesan'], function (index, value) {
                    toastr.error(value[0])
                });
            } else {
                toastr.error(hasil['pesan'])
            }
        },
        error: function (res) {
            console.log('error')
        },
    });

});

$('#myCustomSearchBox').keyup(function () {
    dTable.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
})

$("#drop_zone").on("dragover", function (event) {
    event.preventDefault();
    event.stopPropagation();
    return false;
});

$("#drop_zone").on("drop", function (event) {
    event.preventDefault();
    event.stopPropagation();
    fileobj = event.originalEvent.dataTransfer.files[0];
    var fname = fileobj.name;
    var fsize = fileobj.size;
    if (fname.length > 0) {
        upload(fileobj);
    }
    document.getElementById('selectfile').files[0] = fileobj;
});

$('#btn_file_pick').click(function () {
    /*normal file pick*/
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function () {
        fileobj = document.getElementById('selectfile').files[0];
        if (fileobj == "" || fileobj == null) {
            alert("Please select a file");
            return false;
        } else {
            upload(fileobj);
        }
    };
});

function upload(file_obj) {
    if (file_obj != undefined) {
        $("#drop_zone").addClass('d-none');
        $(".media-file").removeClass('d-none');
        var fname = fileobj.name;
        var fsize = fileobj.size;
        var form_data = new FormData();
        form_data.append('upload_file', file_obj);
        request = $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round(((evt.loaded / evt.total) * 100));
                        $(".media-file__progressbar-item").attr('style', 'width:' + percentComplete + '%');
                        $("#text-percentage").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            url: base_url + '/admin-document-upload',
            method: "POST",
            data: form_data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".media-file__progressbar-item").attr('style', 'width:0%');
                $("#button_proses").addClass('d-none');
                $("#button_close").addClass('d-none');
                $("#button_wait").removeClass('d-none');
            },
            success: function (res) {
                $("#drop_zone").removeClass('d-none');
                $(".media-file").addClass('d-none');
                $("#button_proses").removeClass('d-none');
                $("#button_close").removeClass('d-none');
                $("#button_wait").addClass('d-none');
                var hasil = $.parseJSON(res);
                if (hasil['status'] == 'success') {
                    $('#file_info').html('<svg class="icon-icon-doc"> <use xlink:href="#icon-doc"></use> </svg> ' + fname);
                    $('#enc_name').val(hasil['enc_name']);
                } else {
                    $('#file_info').html(hasil['pesan']);
                }
            },
            error: function (res) {
                console.log('error')
            },
        });
    }

}

$(document).on('click', '.openModal', function () {
    $('.loading').show();
    $('#modalDocument').addClass('modal modal--panel modal--right is-active is-animate');
    $(".terbit").removeClass("active");
    $(".status").removeClass("active");
    // request.abort()
    $("#drop_zone").removeClass('d-none');
    $(".media-file").addClass('d-none');


    var id = $(this).data('id')
    if (id == '') {
        $('.loading').hide();
        $("#title_modal").html('Tambah Dokumen');
        $("#button_modal").html('Tambah');
        $("#proses").val('create');
        $("#no_sk").val('');
        $("#nama_standar").val('');
        $("#old_file").val('');
        $("#old_token").val('');
        // $("#kategori option[value='']").prop("selected",true);
        // $("#pejabat option[value='']").prop("selected",true);
        // $("#jenis_dokumen option[value='']").prop("selected",true);
        $("#tahun").val('');

        $(".ql-editor").html('');

        $('.terbit[data-set="Ya"]').addClass('active');
        $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(0px);')

        $('.status[data-set="Ada"]').addClass('active');
        $('.switcher-button__float.status-float').attr('style', 'width: 80px; transform: translateX(0px);')

        $('#enc_id').val('');
        $('#enc_name').val('');
        $('#file_info').html('');

    } else {
        $.ajax({
            url: base_url + '/admin-document-get-id',
            method: "POST",
            data: {
                id: id
            },
            success: function (res) {
                $('.loading').hide();
                var hasil = $.parseJSON(res);
                if (hasil['status'] == 'success') {
                    $("#title_modal").html('Update Dokumen');
                    $("#button_modal").html('Update');
                    $("#proses").val('update');
                    $("#enc_id").val(hasil['data'][0]['enc_id']);
                    $("#old_file").val(hasil['data'][0]['enc_file']);
                    $("#old_token").val(hasil['data'][0]['token']);

                    $('.terbit[data-set="' + hasil['data'][0]['terbit'] + '"]').addClass('active');
                    if (hasil['data'][0]['terbit'] == 'Ya') {
                        $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(0px);')
                    } else {
                        $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(81px);')
                    }

                    $('.status[data-set="' + hasil['data'][0]['status'] + '"]').addClass('active');
                    if (hasil['data'][0]['status'] == 'Ada') {
                        $('.switcher-button__float.status-float').attr('style', 'width: 80px; transform: translateX(0px);')
                    } else {
                        $('.switcher-button__float.status-float').attr('style', 'width: 80px; transform: translateX(81px);')
                    }

                    $("#no_sk").val(hasil['data'][0]['no_sk']);
                    $("#nama_standar").val(hasil['data'][0]['nama_standar']);

                    $(".select-kategori .select2-selection__rendered").attr('title', hasil['data'][0]['kategori']['nama_kategori']).html(hasil['data'][0]['kategori']['nama_kategori']);
                    $("#kategori option[value=" + hasil['data'][0]['kategori']['enc_id'] + "]").prop("selected", true);

                    $(".select-pejabat .select2-selection__rendered").attr('title', hasil['data'][0]['pejabat']['nama_pejabat']).html(hasil['data'][0]['pejabat']['nama_pejabat']);
                    $("#pejabat option[set=" + hasil['data'][0]['pejabat']['id'] + "]").prop("selected", true);

                    $(".select-jenis-dokumen .select2-selection__rendered").attr('title', hasil['data'][0]['jenis_dokumen']['nama_jenis_dokumen']).html(hasil['data'][0]['jenis_dokumen']['nama_jenis_dokumen']);
                    $("#jenis_dokumen option[value=" + hasil['data'][0]['jenis_dokumen']['enc_id'] + "]").prop("selected", true);

                    $("#tahun").val(hasil['data'][0]['tahun']);

                    $(".ql-editor").html(hasil['data'][0]['keterangan']);
                    $('#enc_name').val('');
                    $('#file_info').html('');
                } else {
                    console.log(hasil['pesan'])
                }
            },
            error: function (res) {
                console.log('error')
            },
        });
    }
});

$(document).on('click', '.download-file', function () {

    var id = $(this).data('id')
    $.ajax({
        url: base_url + '/admin-file',
        method: "POST",
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

    if (evt.target.className == 'subSelect') {



        // alert( parseInt(sessionStorage.getItem('count')) );

        if (sessionStorage.getItem('count') == 'NaN' || sessionStorage.getItem('count') == null) {

            sessionStorage.setItem('count', 0);

        }

        if (evt.target.checked == true) {
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

            if (sessionStorage.getItem('count') == 1) {

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

// $(".kelola_button").click(function() {
//   var formData = $(this).closest('form').serializeArray();
//   formData.push({ name: this.name, value: this.value });
//   //now use formData, it includes the submit button
//   $.ajax({
//           url: base_url + '/admin-document-kelola',
//           type: 'POST',
//           dataType: 'application/json',
//           data: formData,
//           success: function(data) {
//
//           }
//       });
// });

// $("#kelola").submit(function(e) {
//     e.preventDefault();
//     var actionurl = e.currentTarget.action;
//     $.ajax({
//         url: base_url + '/admin-document-kelola',
//         type: 'POST',
//         dataType: 'application/json',
//         data: $("#kelola").serialize(),
//         success: function(data) {
//
//         }
//     });
// });
