@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">Add Product</h6>
    <a href="{{url('storage/sample_excel_template/sample_template_for_uploading_products_list.xlsx')}}" class="btn btn-primary btn-sm float-right" download data-toggle="tooltip" data-placement="bottom" title="Add Product"><i class="fas fa-download"></i> Download Sample temple</a>
    {{-- <a href="{{url('/downloadExcel/xls')}}" class="btn btn-info btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Dowload Products List"><i class="fas fa-upload"></i> Upoload Excel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
    
  </div>
    {{-- <h5 class="card-header">Add Product</h5> --}}
    {{-- <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Product"><i class="fas fa-plus"></i> Add Product</a> |  --}}
      {{-- <a href="{{url('/downloadExcel/xls')}}" class="btn btn-info btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Dowload Products List"><i class="fas fa-download"></i> Dowload Products List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
    <div class="card-body">
      <form method="post" action="{{ URL::to('importExcel') }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Upload excel file <span class="text-danger">*</span></label>
          <div class="input-group">
              {{-- <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span> --}}
          <input id="thumbnail" class="form-control" type="file" required name="import_file" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        @if (session()->has('success'))
            <p class="alert {{ Session::get('alert-class', 'alert-success', 'alert-dismissible fade in') }}">{{ Session::get('success') }}</p>
        @endif
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
          @if (session()->has('failures'))

                        <table class="table table-danger alert-danger">
                            <tr>
                                <th>Row</th>
                                <th>Attribute</th>
                                <th>Errors</th>
                                <th>Value</th>
                            </tr>

                            @foreach (session()->get('failures') as $validation)
                                <tr>
                                    <td>{{ $validation->row() }}</td>
                                    <td>{{ $validation->attribute() }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($validation->errors() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $validation->values()[$validation->attribute()] }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    @endif
        </div>
        
        <div class="form-group mb-3">
          {{-- <button type="reset" class="btn btn-warning">Reset</button> --}}
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

@endpush