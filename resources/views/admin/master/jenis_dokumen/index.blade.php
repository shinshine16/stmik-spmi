@extends('admin.template')

@section('title', 'Jenis Dokumen')

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

@section('sidebar_active')
  <input type="hidden" class="for-active-sidebar" value="sidebar_jenis_dokumen">
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-header__title" id="title_page">Jenis Dokumen</h1>
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
                        <li class="breadcrumbs__item disabled"><a class="breadcrumbs__link" href="#"><span>Master</span>
            <svg class="icon-icon-keyboard-right breadcrumbs__arrow">
              <use xlink:href="#icon-keyboard-right"></use>
            </svg></a>
                        </li>
                        <li class="breadcrumbs__item active"><span class="breadcrumbs__link">Jenis Dokumen</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="toolbox">
        <div class="toolbox__row row gutter-bottom-xs">
          <div class="toolbox__left col-12 col-lg">

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
                    <input class="input" id="myCustomSearchBox" type="text" placeholder="Search product">
                </div>
              </div>
              <div class="col-auto">
                  <button class="button-add button-add--blue openModal" data-id=""><span class="button-add__icon">
      <svg class="icon-icon-plus">
        <use xlink:href="#icon-plus"></use>
      </svg></span><span class="button-add__text"></span>
                  </button>
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

    <form action="{{ route('admin_master_jenis_dokumen_kelola') }}" method="post" id="kelola">
      @csrf
      <div class="text-center" style="position:relative;">

        <button class="button button--primary" type="submit" name="action" value='delete' id="fixedbutton" onclick="return confirm('Apakah anda yakin, ingin menghapusnya ?')">
          <i class="fa fa-trash"></i>
          <span class="button__text">Delete</span>
        </button>

        {{-- <button class="button button--primary" type="submit" name="action" value='draft' id="fixedbutton2">
          <i class="fa fa-archive"></i>
          <span class="button__text">Draft</span>
        </button>

        <button class="button button--primary" type="submit" name="action" value='publish' id="fixedbutton">
          <i class="fa fa-flag"></i>
          <span class="button__text">Publish</span>
        </button> --}}

      </div>

      <div id='input-selected'></div>

    </form>

    <div class="table-wrapper">

        <div class="table-wrapper__content table-collapse scrollbar-thin scrollbar-visible table-responsive">
            <table class="table table--lines" id="datatable">
                <colgroup>
                    <col width="90px">
                        <col width="100px">
                            <col width="350px">
                                <col>
                                    <col>
                                        <col>
                                            <col>
                                                <col>
                </colgroup>
                <thead class="table__header">
                    <tr class="table__header-row">
                        <th width="10%">
                            {{-- <div class="table__checkbox table__checkbox--all">
                                <label class="checkbox">
                                    <input class="js-checkbox-all" type="checkbox" data-checkbox-all="product"><span class="checkbox__marker"><span class="checkbox__marker-icon">
                  <svg class="icon-icon-checked">
                    <use xlink:href="#icon-checked"></use>
                  </svg></span></span>
                                </label>
                            </div> --}}
                            #
                        </th>
                        <th class="table__th-sort" width="80%"><span class="align-middle">Nama Jenis Dokumen</span><span class="sort sort--down"></span>
                        </th>
                        <th class="table__actions" width="10%"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modal')
  <div class="modal modal--panel modal--right" id="modalData">
    <div class="modal__overlay" data-dismiss="modal"></div>
    <div class="modal__wrap">
        <div class="modal__window scrollbar-thin" data-simplebar>
          <div class="loading">Loading&#8230;</div>
          <div class="modal__content">
              <div class="modal__header">
                  <div class="modal__container">
                      <h2 class="modal__title" id="title_modal"></h2>
                  </div>
              </div>
              <div class="modal__body">
                  <div class="modal__container">
                      <form id="proses_modal">
                          <div class="row row--md">
                              <div class="col-12 form-group form-group--lg">
                                  <label class="form-label">Nama Jenis Dokumen</label>
                                  <div class="input-group">
                                      <input type="hidden" id="proses" value="">
                                      <input type="hidden" id="enc_id" value="">
                                      <input class="input" type="text" id="nama_jenis_dokumen" value="" required>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
              <div class="modal__footer">
                  <div class="modal__container">
                      <div class="modal__footer-buttons">
                          <div class="modal__footer-button" id="button_proses">
                              <button class="button button--primary button--block" id="proses_data"><span class="button__text" id="button_modal"></span>
                              </button>
                          </div>
                          <div class="modal__footer-button" id="button_close">
                              <button class="button button--secondary button--block" data-dismiss="modal"><span class="button__text">Kembali</span>
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    var base_url = '{{ url('') }}';
  </script>
  <script type="text/javascript" src="{{ asset('public/js/jenis_dokumen.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@endsection
