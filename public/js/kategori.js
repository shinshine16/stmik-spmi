sessionStorage.clear();

var menu, type, publish

$(document).ready(function () {
  table()
  var active = $('.for-active-sidebar').val()
  $('#' + active).addClass('active')
  $('#sidebar_head').addClass('active')
  $('#Master').addClass('show')
})

function table() {
  $('#datatable').DataTable().destroy();
  menu = $('#filter_menu').val()
  type = $('#filter_type').val()
  publish = $('#filter_publish').val()
  dTable = $('#datatable').DataTable( {
    // "pagingType": "simple",
    // oLanguage: {
    //     oPaginate: {
    //       sPrevious: '<div class="table-wrapper__pagination col-auto"><ol class="pagination"><li class="pagination__item"><a class="pagination__arrow pagination__arrow--prev" href="#"><svg class="icon-icon-keyboard-left"><use xlink:href="#icon-keyboard-left"></use></svg></a></li>',
    //       sNext: '<li class="pagination__item"><a class="pagination__arrow pagination__arrow--next" href="#"><svg class="icon-icon-keyboard-right"><use xlink:href="#icon-keyboard-right"></use></svg></a></li></ol></div>',
    //     }
    // },
    // "bLengthChange": false,
    columnDefs:
 		 [
      {
  			'targets': [0],
  	    'orderable': false,
  			className   : 'table__td'
 			},
     ],
     "ordering": false,
    "dom": "lrtip",
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": base_url + '/admin-master-kategori-data',
      "dataType": "json",
      "data": function ( d ) {
         d.menu = menu;
         d.type = type;
         d.publish = publish;
     },
      "type": 'POST'
    }
  });
}

$(document).on('change', '#filter_menu, #filter_type, #filter_publish', function(){
  $('#myCustomSearchBox').val('')
  table()
});

$( "#proses_data" ).click(function() {
  $('.loading').show();
  var data = {
    proses        :$("#proses").val(),
    enc_id        :$("#enc_id").val(),
    menu          :$("#menu").val(),
    parent        :$("#parent").val(),
    nama_kategori     :$("#nama_kategori").val(),
    type          :$("#type").val(),
    terbit        :$(".terbit.active").data('set'),
  }
  $.ajax({
      url: base_url + '/admin-master-kategori-proses',
      method: "POST",
      data: data,
      success: function(res){
        var hasil = $.parseJSON(res);
        if (hasil['status'] == 'success') {
          $('.loading').hide();
          $('#modalDocument').removeClass('is-active is-animate');
          toastr.success(hasil['pesan'])
          setTimeout(function () {
             location.reload(true);
           }, 1500);
        }else if(hasil['status'] == 'validate'){
          $('.loading').hide();
          $.each(hasil['pesan'], function( index, value ) {
            toastr.error(value[0])
          });
        }else{
          toastr.error(hasil['pesan'])
        }
      },
      error: function (res) {
        console.log('error')
      },
  });

});

$('#myCustomSearchBox').keyup(function() {
    dTable.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
})

$(document).on('click', '.openModal', function(){
  $('.loading').show();
  $('#modalDocument').addClass('modal modal--panel modal--right is-active is-animate');
  $( ".terbit" ).removeClass( "active" );
  // request.abort()

  var id = $(this).data('id')
  if (id == '') {
    $('.loading').hide();
    $("#title_modal").html('Tambah Data');
    $("#button_modal").html('Tambah');
    $("#proses").val('create');
    $('#enc_id').val('');
    $(".select-parent .select2-selection__rendered").attr('title', '-- Pilih --').html('-- Pilih --');
    $("#parent option[value='empty__']").prop("selected",true);
    $("#nama_kategori").val('');
    $("#type").val('');
    $(".select-type .select2-selection__rendered").attr('title', 'Dokumen').html('Dokumen');
    $("#type option[value='document']").prop("selected",true);

    $('.terbit[data-set="Ya"]').addClass('active');
    $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(0px);')
  }else{
    $.ajax({
        url: base_url + '/admin-master-kategori-get-id',
        method: "POST",
        data: {id:id},
        success: function(res){
          $('.loading').hide();
          var hasil = $.parseJSON(res);
          console.log(hasil['data'][0])
          if (hasil['status'] == 'success') {
            $("#title_modal").html('Update Data');
            $("#button_modal").html('Update');
            $("#proses").val('update');
            $("#enc_id").val(hasil['data'][0]['enc_id']);

            $(".select-menu .select2-selection__rendered").attr('title', hasil['data'][0]['menu']['nama_menu']).html(hasil['data'][0]['menu']['nama_menu']);
            $("#menu option[set=" + hasil['data'][0]['menu']['id'] + "]").prop("selected",true);

            if (hasil['data'][0]['parent'] === null) {
              $(".select-parent .select2-selection__rendered").attr('title', '-- Pilih --').html('-- Pilih --');
              $("#parent option[value='empty__']").prop("selected",true);
            }else{
              $(".select-parent .select2-selection__rendered").attr('title', hasil['data'][0]['parent']['nama_kategori']).html(hasil['data'][0]['parent']['nama_kategori']);
              $("#parent option[set=" + hasil['data'][0]['parent']['id'] + "]").prop("selected",true);
            }

            $(".select-type .select2-selection__rendered").attr('title', hasil['data'][0]['type']).html(hasil['data'][0]['type']);
            $("#type option[value=" + hasil['data'][0]['type'] + "]").prop("selected",true);

            $("#nama_kategori").val(hasil['data'][0]['nama_kategori']);

            $('.terbit[data-set="' + hasil['data'][0]['terbit'] + '"]').addClass('active');
            if (hasil['data'][0]['terbit'] == 'Ya') {
              $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(0px);')
            }else{
              $('.switcher-button__float.terbit-float').attr('style', 'width: 80px; transform: translateX(81px);')
            }

          }else{
            console.log(hasil['pesan'])
          }
        },
        error: function (res) {
          console.log('error')
        },
    });
  }
})

$("tbody").click(function(evt){

	if( evt.target.className == 'subSelect' )

	{

		if( sessionStorage.getItem('count') == 'NaN' || sessionStorage.getItem('count') == null)

		{

			sessionStorage.setItem('count',0);

		}

		if( evt.target.checked == true )

		{
      $('#datatable_paginate').addClass('d-none');

      $('#datatable_length').addClass('d-none');

      $('.toolbox').addClass('d-none');

      $('.items-more').addClass('d-none');

			let input_ = document.createElement('input');

			input_.setAttribute('type','hidden');

			input_.setAttribute('value','selected_' + evt.target.defaultValue);

			input_.setAttribute('name','data[]');

			$('#input-selected').append(input_);

			sessionStorage.setItem('count', parseInt(sessionStorage.getItem('count')) + 1 );

			$('.MYbounce').show();

			$('body').css('background','rgba(46, 49, 49, 1)');

      if ($('#template').data('theme') == 'light') {
        $('#title_page').css('color','rgba(249, 250, 251, 1)');
      }

			$('#fixedbutton').show();

			$('#fixedbutton2').show();

			$('#fixedbutton3').show();

		}

		else{

      $('#datatable_paginate').removeClass('d-none');

      $('#datatable_length').removeClass('d-none');

      $('.toolbox').removeClass('d-none');

      $('.items-more').removeClass('d-none');

			$("input[value='selected_"+ evt.target.defaultValue +"']").remove();

			if(  sessionStorage.getItem('count')  == 1 )

			{

				$('.MYbounce').hide();

        if ($('#template').data('theme') == 'light') {
          $('body').css('background','rgba(249, 250, 251, 1)');
          $('#title_page').css('color','rgba(68, 85, 108, 1)');
        }else{
          $('body').css('background','rgba(21, 35, 46, 1)');
        }

				$('#fixedbutton').hide();

				$('#fixedbutton2').hide();

				$('#fixedbutton3').hide();

			}

				sessionStorage.setItem('count', parseInt( sessionStorage.getItem('count') ) - 1 );

		}

		$('#counter-selected').html( sessionStorage.getItem('count') );
    $('#text-selected').css('color','rgba(249, 250, 251, 1)');
		$(".MYbounce").effect( "bounce", {times:2}, 100 );

	}

});
