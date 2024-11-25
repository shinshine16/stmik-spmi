@extends('admin.template')

@section('title', 'Text')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <style>
    /* Absolute Center Spinner */
    .loading {
      position: fixed;
      z-index: 999;
      height: 2em;
      width: 2em;
      overflow: show;
      margin: auto;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
      content: '';
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));
      background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
      /* hide "loading..." text */
      font: 0/0 a;
      color: transparent;
      text-shadow: none;
      background-color: transparent;
      border: 0;
    }

    .loading:not(:required):after {
      content: '';
      display: block;
      font-size: 10px;
      width: 1em;
      height: 1em;
      margin-top: -0.5em;
      -webkit-animation: spinner 150ms infinite linear;
      -moz-animation: spinner 150ms infinite linear;
      -ms-animation: spinner 150ms infinite linear;
      -o-animation: spinner 150ms infinite linear;
      animation: spinner 150ms infinite linear;
      border-radius: 0.5em;
      -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @-moz-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @-o-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
  </style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-header__title" id="title_page">{{ $title }}</h1>
    </div>
    <div class="page-tools">
        <div class="page-tools__breadcrumbs">
            <div class="breadcrumbs">
                <div class="breadcrumbs__container">
                    <ol class="breadcrumbs__list">
                        <li class="breadcrumbs__item">
                            <a class="breadcrumbs__link" href="index.html">
                                <svg class="icon-icon-home breadcrumbs__icon">
                                    <use xlink:href="#icon-home"></use>
                                </svg>
                                <svg class="icon-icon-keyboard-right breadcrumbs__arrow">
                                    <use xlink:href="#icon-keyboard-right"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumbs__item active"><span class="breadcrumbs__link">Text</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="page-tools__right">
            {{-- <div class="page-tools__right-row">
                <div class="page-tools__right-item"><a class="button-icon" href="#"><span class="button-icon__icon">
          <svg class="icon-icon-print">
            <use xlink:href="#icon-print"></use>
          </svg></span></a>
                </div>
                <div class="page-tools__right-item"><a class="button-icon" href="#"><span class="button-icon__icon">
          <svg class="icon-icon-import">
            <use xlink:href="#icon-import"></use>
          </svg></span></a>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="toolbox">
        <div class="toolbox__row row gutter-bottom-xs">
            <div class="toolbox__left col-12 col-lg">
                <div class="toolbox__left-row row row--xs gutter-bottom-xs">
                    <div class="form-group form-group--inline col-12 col-sm-auto">
                        <div class="input-group input-group--white input-group--append">
                            <select class="input js-input-select" data-placeholder="" id="limit">
                                <option value="10" selected="selected">10
                                </option>
                                <option value="20">20
                                </option>
                                <option value="40">40
                                </option>
                                <option value="80">80
                                </option>
                                <option value="100">100
                                </option>
                            </select><span class="input-group__arrow">
                            <svg class="icon-icon-keyboard-down">
                              <use xlink:href="#icon-keyboard-down"></use>
                            </svg></span>
                        </div>
                    </div>
                    <div class="form-group form-group--inline col col-sm-auto">
                        <div class="input-group input-group--white input-group--append">
                             <select class="input js-input-select" id="kategori">
                                <option value="" selected="selected">All Categories </option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->enc_id }}">{{ $kategori->nama_kategori }} 
                                    </option>
                                @endforeach
                            </select><span class="input-group__arrow">
            <svg class="icon-icon-keyboard-down">
              <use xlink:href="#icon-keyboard-down"></use>
            </svg></span>
                        </div>
                    </div>
                    <div class="form-group form-group--inline col-12 col-sm-auto">
                        <div class="toolbox__status input-group input-group--white input-group--append">
                             <select class="input js-input-select" id="status">
                                <option value="" selected="selected">All status </option>
                                <option value="Ya" >Aktif </option>
                                <option value="Tidak" >Tidak Aktif </option>
                            </select><span class="input-group__arrow">
                            <svg class="icon-icon-keyboard-down">
                              <use xlink:href="#icon-keyboard-down"></use>
                            </svg></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="toolbox__right col-12 col-lg-auto">
                <div class="toolbox__right-row row row--xs flex-nowrap">
                    <div class="col col-lg-auto">
                            <div class="input-group input-group--white input-group--prepend">
                                <div class="input-group__prepend">
                                    <svg class="icon-icon-search">
                                        <use xlink:href="#icon-search"></use>
                                    </svg>
                                </div>
                                <input class="input" type="text" placeholder="Search Text" id="search">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-wrapper" id="text">
           @include('admin.text.table')
        </div>
    </div>
</div>	
<div class="modal modal--panel modal--right" id="addText">
    <div class="modal__overlay" data-dismiss="modal"></div>
    <div class="modal__wrap">
        <div class="modal__window scrollbar-thin" data-simplebar>
            <div class="loading">Loading&#8230;</div>
            <div class="modal__content">
                <div class="modal__header">
                    <div class="modal__container">
                        <h2 class="modal__title">Text</h2>
                    </div>
                </div>
                <div class="modal__body">
                    <form method="POST" action="{{ route('text_store') }}" id="formText">
                    <div class="modal__container">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id_input">
                            <div class="row row--md">
                                 <div class="col-6 form-group form-group--lg">
                                  <label class="form-label">Publish</label>
                                  <div class="col-auto">
                                      <div class="switcher-button">
                                          <div class="switcher-button__items">
                                              <div class="switcher-button__float status-float"></div>
                                              <input type="hidden" name="terbit" id="terbit_input">
                                              <div class="switcher-button_custom switcher-button__item status" id="switcher-ya">
                                                <input type="button" class="switcher-button__btn switcher-button_input" value="Ya" />
                                              </div>
                                              <div class="switcher-button_custom switcher-button__item status" id="switcher-tidak">
                                                <input type="button" class="switcher-button__btn switcher-button_input" value="Tidak" />
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6 form-group form-group--lg">
                                  <label class="form-label">Preview</label>
                                  <div class="col-auto">
                                    <button id="preview" class="button button--primary" type="button"><span class="button__icon button__icon--left">
                                        <svg class="icon-icon-view">
                                          <use xlink:href="#icon-view"></use>
                                        </svg></span><span class="button__text"></span>
                                    </button>
                                  </div>
                              </div>
                                <div class="col-4 form-group form-group--lg">
                                    <label class="form-label">Kategori</label>
                                    <div class="input-group">
                                        <input class="input" name="kategori" type="text" placeholder="" value="" readonly id="kategori_input">
                                    </div>
                                </div>
                                <div class="col-8 form-group form-group--lg">
                                    <label class="form-label">Judul</label>
                                    <div class="input-group">
                                        <input name="judul" class="input" type="text" placeholder="" value="" id="judul_input">
                                    </div>
                                </div>
                                <div class="col-12 form-group form-group--lg">
                                    <label class="form-label">Description</label>
                                    <div class="input-editor">
                                        <textarea  name="isi" id="isi_input" cols="60" rows="5"> </textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal__footer">
                    <div class="modal__container">
                        <div class="modal__footer-buttons">
                            <div class="modal__footer-button">
                                <button class="button button--primary button--block" type="submit"><span class="button__text">Submit</span>
                                </button>
                            </div>
                            <div class="modal__footer-button">
                                <button class="button button--secondary button--block" data-dismiss="modal"><span class="button__text">Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-compact modal-success scrollbar-thin" id="addProductSuccess" data-simplebar>
    <div class="modal__overlay" data-dismiss="modal"></div>
    <div class="modal__wrap">
        <div class="modal__window">
            <div class="modal__content">
                <div class="modal__body">
                    <div class="modal__container">
                        <img class="modal-success__icon" src="{{ asset('arion') }}/img/content/checked-success.svg" alt="#">
                        <h4 class="modal-success__title">Product was added</h4>
                    </div>
                </div>
                <div class="modal-compact__buttons">
                    <div class="modal-compact__button-item">
                        <button class="modal-compact__button button" data-dismiss="modal" data-modal="#addProduct"><span class="button__text">Add new product</span>
                        </button>
                    </div>
                    <div class="modal-compact__button-item">
                        <button class="modal-compact__button button" data-dismiss="modal"><span class="button__text">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='MYbounce bg-primary'>
    <h4 class="text-center" id='text-selected' style="padding: 0; margin: 0;">
    <label class="text-center" id='counter-selected' style="padding: 0; margin: 0;"></label> Item terpilih
    </h4>
</div>
<form action="{{ route('admin_text_kelola') }}" method="post" id="kelola">
@csrf
<div class="text-center" style="position:relative;">

<button class="button button--primary" type="submit" name="action" value='delete' id="fixedbutton3" onclick="return confirm('Apakah anda yakin, ingin menghapusnya ?')">
  <i class="fa fa-trash"></i>
  <span class="button__text">Delete</span>
</button>

<button class="button button--primary" type="submit" name="action" value='draft' id="fixedbutton2">
  <i class="fa fa-archive"></i>
  <span class="button__text">Draft</span>
</button>

<button class="button button--primary" type="submit" name="action" value='publish' id="fixedbutton">
  <i class="fa fa-flag"></i>
  <span class="button__text">Publish</span>
</button>

</div>

<div id='input-selected'></div>

</form>
@endsection
@section('script')
<script src="{{ asset('ckeditor') }}/ckeditor.js"></script>
<script>    
    sessionStorage.clear();
    var limit, kategori, status, url, search;
    url =  new URL('{{ route('admin_text') }}')

    $(document).ready(function(){
        CKEDITOR.replace('isi_input',{
              filebrowserBrowseUrl: '{{ asset('ckfinder') }}/ckfinder.html',
              filebrowserUploadUrl: '{{ asset('ckfinder') }}/core/connector/php/connector.php?command=QuickUpload&type=Files',
        });

        @if ($message = Session::get('success'))
            toastr.success('{{ $message }}')
        @endif
          
        @if ($message = Session::get('error'))
            toastr.error('{{ $message }}')
        @endif
           
        @if ($message = Session::get('warning'))
            toastr.warning('{{ $message }}')
        @endif
           
        @if ($message = Session::get('info'))
            toastr.info('{{ $message }}')
        @endif
          
        @if ($errors->any())
            toastr.error('{{ $errors->first() }}')
        @endif

        @if (!empty(old()))
            $('#addText').toggleClass('is-active is-animate')
            $('#id_input').val("{{ old('id') }}")
            $('#kategori_input').val("{{ old('kategori') }}")
            $('#judul_input').val("{{ old('judul') }}")
            CKEDITOR.instances['isi_input'].setData("{!! old('isi') !!}")
        @endif

    $('body').on('change', '#limit, #kategori, #status', function (e) {
        e.preventDefault();
        window.history.pushState("", "", url);
        loadPosts(url);
    });

    $('body').on('keyup', '#search', function (e) {
        e.preventDefault();
        window.history.pushState("", "", url);
        loadPosts(url);
    });


    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();
        url = $(this).attr('href');

        window.history.pushState("", "", url);

        loadPosts(url);
    });
    function loadPosts(url) {
        limit       = $('#limit option:selected').val();
        kategori    = $('#kategori option:selected').val();
        status      = $('#status option:selected').val();
        search      = $('#search').val();

        url = insertParam('limit',limit,url)
        url = insertParam('kategori',kategori,url)
        url = insertParam('status',status,url)
        url = insertParam('search',search,url)

        $.ajax({
            url: url
        }).done(function (data) {
            $('#text').html(data);
        }).fail(function () {
            console.log("Failed to load data!");
        });
    }
    });

    $("tbody").click(function(evt){

        if( evt.target.className == 'subSelect' )
        {
            // alert( parseInt(sessionStorage.getItem('count')) );
            $('#text-pagination').hide()
            if( sessionStorage.getItem('count') == 'NaN' || sessionStorage.getItem('count') == null)

            {

                sessionStorage.setItem('count',0);

            }

            if( evt.target.checked == true )

            {

                let input_ = document.createElement('input');

                input_.setAttribute('type','hidden');

                input_.setAttribute('value',evt.target.defaultValue);

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

                    $('#text-pagination').show()
                }

                sessionStorage.setItem('count', parseInt( sessionStorage.getItem('count') ) - 1 );

            }

            $('#counter-selected').html( sessionStorage.getItem('count') );
            $('#text-selected').css('color','rgba(249, 250, 251, 1)');
            $(".MYbounce").effect( "bounce", {times:2}, 100 );

        }

    });

    function insertParam(key,value,url)
    {
        var s = new URL(url);
        if (value != '') {
            s.searchParams.append(key, value);
        }
        return s;
    }

    function openEdit(obj){
        $('.loading').show();
        $('#addText').toggleClass('is-active is-animate')
        var id = $(obj).data("id") 
        $.ajax({
          url: '{{ route('text_edit') }}',
          method: "GET",
          data: { id : id},
          success: function(res){
            if (res.status == 'success') {
                $('#id_input').val(res.data.id)
                $('#kategori_input').val(res.data.kategori['nama_kategori'])
                $('#judul_input').val(res.data.judul)
                if (res.data.terbit == 'Ya') {
                    $('#terbit_input').val('Ya')
                    $('.switcher-button__float').attr('style', 'width: 80px; transform: translateX(0px);')
                    $('#switcher-tidak').removeClass('active')
                    $('#switcher-ya').addClass('active')
                }else{
                    $('#terbit_input').val('Tidak')
                    $('.switcher-button__float').attr('style', 'width: 80px; transform: translateX(81px);')
                    $('#switcher-ya').removeClass('active')
                    $('#switcher-tidak').addClass('active')
                }
                CKEDITOR.instances['isi_input'].setData(res.data.isi)
                $('.loading').hide();
            }else{
                toastr.error('Data tidak ditemukan!')
            }
          },
          error: function (res) {
            // console.log('error')
          },
        });
    }

    $(".switcher-button_custom").on("click", function () {
       var terbit = $(this).find('input.switcher-button_input').val();
       $('#terbit_input').val(terbit);
    });

    $('body').on('click', '#preview', function (e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
        }
        var data = $('#formText').serializeArray()
        $.ajax({
          url: '{{ route('text_preview') }}',
          method: "POST",
          data: data,
          success: function(res){
            var w = window.open('about:blank');
            w.document.open();
            w.document.write(res);
            w.document.close();
          },
          error: function (res) {
            // console.log('error')
          },
        });
    });
</script>
@endsection
