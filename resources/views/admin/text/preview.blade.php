@extends('user.template')

@section('title', $title)

@section('css')

@endsection

@section('tag')
  <li>{{ $title}}</li>
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
                                      <h3 style="margin:0 0 15px">{{ $judul }}</h3>
                                  </div>
                              </div>
                          </section>
                          <!-- End: Search Section -->
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                           {!! $isi !!}
                          </div>
                      </div>
                  </div>

                  <!-- Start: Staff Picks -->
                  <section class="team staff-picks">
                      <div class="container">
                          <div class="center-content">
                              <h2 class="section-title">Staff Picks</h2>
                              <span class="underline center"></span>
                              <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                          </div>
                      </div>
                  </section>
                  <!-- End: Staff Picks -->
              </div>
          </main>
      </div>
  </div>
  <!-- End: Products Section -->
@endsection
