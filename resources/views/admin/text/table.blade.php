<div class="table-wrapper__content table-collapse scrollbar-thin scrollbar-visible table-responsive">
	 <table class="table table--lines" id="table">
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
	            <th>
	                <div class="table__checkbox table__checkbox--all">
	                    <label class="checkbox">
	                        <input class="js-checkbox-all" type="checkbox" data-checkbox-all="product">
	                        <span class="checkbox__marker">
		                        <span class="checkbox__marker-icon">
							      <svg class="icon-icon-checked">
							        <use xlink:href="#icon-checked"></use>
							      </svg>
							    </span>
							</span>
	                    </label>
	                </div>
	            </th>
	            <th class="table__th-sort">
	            	<span class="align-middle">Judul</span>
	            	<span class="sort sort--down"></span>
	            </th>
	            <th class="table__th-sort">
	            	<span class="align-middle">Kategori</span>
	            	<span class="sort sort--down"></span>
	            </th>
	            <th class="table__th-sort">
	            	<span class="align-middle">Publish</span>
	            	<span class="sort sort--down"></span>
	            </th>
	            <th class="table__actions"> </th>
	        </tr>
	    </thead>
	    <tbody>
	        @foreach($data as $key => $value)
            <tr>
                {{-- <td>{{ $key+1 }}</td> --}}
                <td><div class="table__checkbox table__checkbox--all">
                    <label class="checkbox">
                      <input type="checkbox" class="subSelect" value="{{ $value->id }}" data-checkbox="product"><span class="checkbox__marker"><span class="checkbox__marker-icon">
                      <svg class="icon-icon-checked">
                        <use xlink:href="#icon-checked"></use>
                      </svg></span></span>
                    </label>
                  </div></td>
                <td>{{ $value->judul }}</td>
                <td>{{ $value->kategori['nama_kategori'] }}</td>
                <td>
                	@if ($value->terbit == 'Ya')
                		<div class="label badge--green label--md"><span class="label__icon"><i class="fa fa-flag"></i></span>Ya</div>
                	@else
                		<div class="label badge--red label--md"><span class="label__icon"><i class="fa fa-archive"></i></span>Tidak</div>
                	@endif
                	</td>
                <td><div class="items-more">
					            <button class="items-more__button">
					                <svg class="icon-icon-more">
					                    <use xlink:href="#icon-more"></use>
					                </svg>
					            </button>

					            <div class="dropdown-items dropdown-items--right dropdown-items--down" s>
					                <div class="dropdown-items__container">
					                    <ul class="dropdown-items__list">
					                        <li class="dropdown-items__item">
						                        <button class="dropdown-items__link openModal" data-id="{{ $value->id }}" onclick="openEdit(this)"><span class="dropdown-items__link-icon">
																    <svg class="icon-icon-view">
																      <use xlink:href="#icon-view"></use>
																    </svg></span>Update</button>
					                        </li>
						                      <li class="dropdown-items__item">
						                      	<form action="{{ route('text_delete', $value->id)}}" method="post">
																		   @method('DELETE')
																		   @csrf

																		   <button type="submit" class="dropdown-items__link">
																		   	<span class="dropdown-items__link-icon">
																		    <svg class="icon-icon-trash">
																		      <use xlink:href="#icon-trash"></use>
																		    </svg>
																		  	</span>Delete
																		   </button>
																		</form>
					                        </li>
					                    </ul>
					                </div>
					            </div>
					        </div>
					      </td>
            </tr>
        	@endforeach
	    </tbody>
	</table>
</div>
<div class="table-wrapper__footer">
	<div class="row">
	    <div class="table-wrapper__show-result col text-grey"><span class="d-none d-sm-inline-block">Showing</span> 1 to 10 <span class="d-none d-sm-inline-block">of {{ $data->count() }} items</span>
	    </div>
	    <div class="table-wrapper__pagination col-auto" id="text-pagination">
	        	{!! $data->render() !!}
	    </div>
	</div>
</div>