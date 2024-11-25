@extends('user.template')

@section('title', $title)

@section('css')

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

@endsection

@section('tag')
  {!! $tag !!}
@endsection

@section('content')
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
                                      <h3 style="margin:0 0 15px">{{ $text->judul }}</h3>
                                  </div>
                              </div>
                          </section>
                          <!-- End: Search Section -->
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                            {!! $text->isi !!}
                          </div>
                      </div>
                  </div>
              </div>
          </main>
      </div>
  </div>
  <!-- End: Products Section -->
@endsection

@section('script')
  <script type="text/javascript">
    var base_url = '{{ url('') }}';
  </script>
  <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


@endsection
