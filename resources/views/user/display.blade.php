@extends('user.template')

@section('title', $title)

@section('css')

  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
  <style>
    .custom-select {
      border: 3px solid #f4f4f4;
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      border-radius: 0;
      padding: 15px 10px;
      width: 100%;
    }
    .content-scroll {
      overflow-x: scroll ;
    }
    .btn-custom {
      padding: 1rem 1rem;
      font-size: 1.5rem;
      line-height: 1.5;
      border-radius: 0.2rem;
    }
    .table_action {
      white-space: nowrap;
      text-align: center;
    }
  </style>

@endsection

@section('tag')
  {!! $tag !!}
@endsection

@section('content')
<input hidden type="text" class="slug" name="slug" id='slug' value="{{$slug}}">
  <!-- Start: Products Section -->
  <div id="content" class="site-content">
      <div id="primary" class="content-area">
          <main id="main" class="site-main">
              <div class="books-media-gird">
                  <div class="container">
                      <div class="row">
                          <!-- Start: Search Section -->
                          <section class="search-filters">
                              <div class="container">
                                  <div class="filter-box">
                                      <h3>Dokumen apa yang sedang anda cari?</h3>
                                      <form action="http://libraria.demo.presstigers.com/index.html" method="get">
                                          <div class="col-md-12 col-sm-12">
                                              <div class="form-group">
                                                  <label class="sr-only" for="keywords">Masukan kata kunci </label>
                                                  <input class="form-control" id="myCustomSearchBox" placeholder="Search by Keyword"  type="text">
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="row">
                                                  <div class="col-md-6 col-sm-6">
                                                      <div class="form-group">
                                                        <select class="input js-input-select custom-select " id='filter_kategori' data-placeholder="">
                                                            <option value="empty__" selected="selected">-- Kategori --</option>
                                                            @foreach ($kategori as $key => $value)
                                                            <option value="{{ $value['enc_id'] }}">
                                                                {{ $value['menu']['nama_menu'] . ' - ' . $value['nama_kategori'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-6 col-sm-6">
                                                      <div class="form-group">
                                                        <select class="input js-input-select custom-select " id='filter_pejabat' data-placeholder="">
                                                            <option value="empty__" selected="selected">-- Pejabat--</option>
                                                            @foreach ($pejabat as $key => $value)
                                                            <option value="{{ $value['enc_id'] }}">{{ $value['nama_pejabat'] }}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-12 col-sm-12">
                                                      <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <select class="input js-input-select custom-select " id='filter_jenis_dokumen' data-placeholder="">
                                                                    <option value="empty__" selected="selected">-- Jenis Dokumen --</option>
                                                                    @foreach ($jenis_dokumen as $key => $value)
                                                                    <option value="{{ $value['enc_id'] }}">{{ $value['nama_jenis_dokumen'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                <select class="input js-input-select custom-select " id='filter_tahun' data-placeholder="">
                                                                    <option value="empty__" selected="selected">-- Tahun --</option>
                                                                    @foreach ($tahun as $key => $value)
                                                                    <option value="{{ $value['tahun'] }}">{{ $value['tahun'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                <select class="input js-input-select custom-select " id='filter_status' data-placeholder="">
                                                                    <option value="empty__" selected="selected">-- Status --</option>
                                                                    <option value="Ada">Ada</option>
                                                                    <option value="Belum Ada">Belum Ada</option>
                                                                </select>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                  </div>
                              </div>
                          </section>
                          <!-- End: Search Section -->
                      </div>

                      <div class="row">

                          <div class="col-md-12">
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
                                        <th class="table__th-sort"><span>NO. SK</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Nama</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Kategori</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Pejabat Yang Mengesahkan</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Jenis Dokumen</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Tahun</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__th-sort"><span class="align-middle">Status</span><span class="sort sort--down"></span>
                                        </th>
                                        <th class="table__actions"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                          </div>
                      </div>
                  </div>
              </div>
          </main>
      </div>
  </div>
  <br>
  <br>
  <!-- End: Products Section -->
@endsection

@section('modal')
  <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="col-12 form-group form-group--lg">
                  <span id="keterangan"></span>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    var base_url = '{{ url('') }}';
  </script>
  <script type="text/javascript" src="{{ asset('public/js/user.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>


@endsection
