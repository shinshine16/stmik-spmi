@extends('admin.template')

@section('title', 'Configurations')

@section('style')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-header__title">Configurations</h1>
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
                            <li class="breadcrumbs__item active"><span class="breadcrumbs__link">Configurations</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card add-product card--content-center">
                    <div class="card__wrapper">
                        <div class="card__container">
                            @php
                                    $nama_aplikasi = $config->nama_aplikasi;  
                                    $deskripsi = $config->deskripsi;  
                                    $lokasi = $config->lokasi;  
                                    $email = $config->email;  
                                    $telpon = $config->telpon;  
                                    $facebook = $config->facebook;  
                                    $whatsapp = $config->whatsapp;  
                                    $instagram = $config->instagram;  
                                    $youtube = $config->youtube;  
                                    $linkedin = $config->linkedin; 
                                    $logo = $config->logo; 
                            @endphp
                            <form class="add-product__form" method="POST" action="{{ route('admin_config_store') }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="add-product__right">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-3 col-xl-3">
                                                <div class="mx-autos">
                                <div class="modal-account__upload profile-upload js-profile-upload">
                                    <input id="imageFile" class="profile-upload__input" type="file" name="file_upload" accept="image/png, image/jpeg">
                                    <svg class="profile-upload__thumbnail" viewBox="0 0 252 272" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g filter="url(#filter1)">
                                            <path d="M18.235 43.2287C19.2494 23.1848 35.1848 7.24941 55.2287 6.23501C76.8855 5.13899 104.551 4 126 4C147.449 4 175.114 5.13898 196.771 6.23501C216.815 7.24941 232.751 23.1848 233.765 43.2287C234.861 64.8855 236 92.5512 236 114C236 135.449 234.861 163.114 233.765 184.771C232.751 204.815 216.815 220.751 196.771 221.765C175.114 222.861 147.449 224 126 224C104.551 224 76.8855 222.861 55.2287 221.765C35.1848 220.751 19.2494 204.815 18.235 184.771C17.139 163.114 16 135.449 16 114C16 92.5512 17.139 64.8855 18.235 43.2287Z"
                                            fill="url(#pattern1)" />
                                        </g>
                                        <path class="profile-upload__overlay" opacity="0.6" d="M18.235 43.2287C19.2494 23.1848 35.1848 7.24941 55.2287 6.23501C76.8855 5.13899 104.551 4 126 4C147.449 4 175.114 5.13899 196.771 6.23501C216.815 7.24941 232.751 23.1848 233.765 43.2287C234.861 64.8855 236 92.5512 236 114C236 135.449 234.861 163.114 233.765 184.771C232.751 204.815 216.815 220.751 196.771 221.765C175.114 222.861 147.449 224 126 224C104.551 224 76.8855 222.861 55.2287 221.765C35.1848 220.751 19.2494 204.815 18.235 184.771C17.139 163.114 16 135.449 16 114C16 92.5512 17.139 64.8855 18.235 43.2287Z"
                                        fill="#44566C" />
                                        <defs>
                                            <filter id="filter0" x="23" y="183" width="206" height="89" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                <feOffset dy="8" />
                                                <feGaussianBlur stdDeviation="8" />
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                <feOffset dy="16" />
                                                <feGaussianBlur stdDeviation="16" />
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow" result="shape" />
                                            </filter>
                                            <filter id="filter1" x="0" y="0" width="252" height="252" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                <feOffset dy="12" />
                                                <feGaussianBlur stdDeviation="8" />
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0" />
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                <feOffset dy="2" />
                                                <feGaussianBlur stdDeviation="2" />
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0" />
                                                <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow" result="shape" />
                                            </filter>
                                            <pattern id="pattern1" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                <use xlink:href="#profileImageAddPlaceholder" transform="scale(0.00142857)" />
                                                <use xlink:href="#profileImageAdd" transform="scale(0.00142857)" />
                                            </pattern>
                                            <image id="profileImageAddPlaceholder" width="700" height="700" xlink:href='' />
                                            <image id="profileImageAdd" class="profile-upload__image" width="700" height="700" xlink:href='{{ url('storage/app/public/config/'. $logo) }}' />
                                        </defs>
                                    </svg>
                                    <div class="profile-upload__label">
                                        <svg class="icon-icon-camera" width="50px" height="50px">
                                            <use xlink:href="#icon-camera"></use>
                                        </svg>
                                        <p class="mb-0">Click & Drop
                                            <br>to change photo</p>
                                    </div>
                                </div>
                            </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-9 col-xl-9">
                                                <div class="row">
                                             <div class="col-12 form-group form-group--lg">
                                                <label class="form-label">Nama Aplikasi</label>
                                                <div class="input-group">
                                                    <input name="nama_aplikasi" class="input" type="text" placeholder="Nama aplikasi" required value="{{ $nama_aplikasi }}">
                                                </div>
                                            </div>
                                            <div class="col-12 form-group form-group--lg">
                                                <label class="form-label">Deskripsi Aplikasi</label>
                                                <textarea name="deskripsi" rows="4" class="input" placeholder="Deskripsi aplikasi .." required>{{ $deskripsi }}</textarea>
                                            </div>
                                            <div class="col-12 form-group form-group--lg">
                                                <label class="form-label">Lokasi Perusahaan</label>
                                                <textarea name="lokasi" rows="3" class="input" placeholder="Lokasi .." required>{{ $lokasi }}</textarea>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Email</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-solid fa-envelope"></i></span>
                                                    </div>
                                                    <input name="email" class="input" type="text" value="{{ $email }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Telpon</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-solid fa-phone"></i></i></span>
                                                    </div>
                                                    <input name="telpon" class="input" type="text" value="{{ $telpon }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Facebook</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-brands fa-facebook-f"></i></span>
                                                    </div>
                                                    <input name="facebook" class="input" type="text" value="{{ $facebook }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Whatsapp</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-brands fa-whatsapp"></i></span>
                                                    </div>
                                                    <input name="whatsapp" class="input" type="text" value="{{ $whatsapp }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Instagram</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-brands fa-instagram"></i></span>
                                                    </div>
                                                    <input name="instagram" class="input" type="text" value="{{ $instagram }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Youtube</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-brands fa-youtube"></i></span>
                                                    </div>
                                                    <input name="youtube" class="input" type="text" value="{{ $youtube }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group form-group--lg">
                                                <label class="form-label">Linkedin</label>
                                                <div class="input-group input-group--prepend">
                                                    <div class="input-group__prepend"><span class="input-group__symbol"><i class="fa-brands fa-linkedin-in"></i></span>
                                                    </div>
                                                    <input name="linkedin" class="input" type="text" value="{{ $linkedin }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-product__submit">
                                            <div class="modal__footer-button">
                                                <button class="button button--primary button--block" type="submit"><span class="button__text">Submit</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                                </div>
                    </div>
                </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
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
            @foreach ($errors->all() as $error)
                toastr.error('{{ $errors }}')
            @endforeach
        @endif
        $(document).on("change", "#imageFile", function() {
            alert("Files changed.");
        });
    });
</script>
@endsection

