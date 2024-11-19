sessionStorage.clear();

var limit, pejabat, jenis_dokumen, request

$(document).ready(function () {
  table()
  var active = $('.for-active-sidebar').val()
  $('#' + active).addClass('active')
  $('#sidebar_head').addClass('active')
  $('#Master').addClass('show')
})

// $(document).on('change', '#limit', function(){
//   table()
// });

function table() {
  $('#datatable').DataTable().destroy();
  // limit = $('#limit option:selected').val()
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
  			'targets': [0], // column index (start from 0)
  	    'orderable': false, // set orderable false for selected columns
  			className   : 'table__td'
 			},
     ],
     "ordering": false,
    "dom": "lrtip",
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": base_url + '/admin-master-pejabat-data',
      "dataType": "json",
      "data": function ( d ) {
         d.limit = limit;
     },
      "type": 'POST'
    }
  });
}

$( "#proses_data" ).click(function() {
  $('.loading').show();
  var data = {
    proses        :$("#proses").val(),
    enc_id        :$("#enc_id").val(),
    nama_pejabat         :$("#nama_pejabat").val(),
  }
  $.ajax({
      url: base_url + '/admin-master-pejabat-proses',
      method: "POST",
      data: data,
      success: function(res){
        var hasil = $.parseJSON(res);
        if (hasil['status'] == 'success') {
          $('.loading').hide();
          $('#modalData').removeClass('is-active is-animate');
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
  $('#modalData').addClass('modal modal--panel modal--right is-active is-animate');
  // request.abort()

  var id = $(this).data('id')
  if (id == '') {
    $('.loading').hide();
    $("#title_modal").html('Tambah Data');
    $("#button_modal").html('Tambah');
    $("#proses").val('create');
    $("#nama_pejabat").val('');
    $('#enc_id').val('');
  }else{
    $.ajax({
        url: base_url + '/admin-master-pejabat-get-id',
        method: "POST",
        data: {id:id},
        success: function(res){
          $('.loading').hide();
          var hasil = $.parseJSON(res);
          if (hasil['status'] == 'success') {
            $("#title_modal").html('Update Data');
            $("#button_modal").html('Update');
            $("#proses").val('update');
            $("#enc_id").val(hasil['data'][0]['enc_id']);

            $("#nama_pejabat").val(hasil['data'][0]['nama_pejabat']);

          }else{
            console.log(hasil['pesan'])
          }
        },
        error: function (res) {
          console.log('error')
        },
    });
  }
});


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
