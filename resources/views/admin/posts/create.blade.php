@extends('layout.master')
@push('css')

@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label for="">Company</label>
                            <select class="form-control" name="company" id="select-company"></select>
                        </div>

                        <div class="form-group">
                            <label for="">Language</label>
                            <select class="form-control" name="language" id="select-language" multiple></select>
                        </div>

                        <div class="form-group">
                            <label for="">City</label>
                            <select class="form-control" name="city" id="select-city"></select>
                        </div>

                        <div class="form-group">
                            <label for="">District</label>
                            <select class="form-control" name="district" id="select-district"></select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    async function loadDistrict() {
      $('#select-district').empty();
      const path = $("#select-city option:selected").data('path');
      const response = await fetch('{{ asset('locations/') }}' + path);
      const districts = await response.json();
      $.each(districts.district, function(index, each) {
        if(each.pre === 'Quận'){
          $('#select-district').append(`
            <option>
              ${each.name}
            </option>
          `);
        }
      });
    }

    $(document).ready(async function() {
      $("#select-city").select2();
      const response = await fetch('{{ asset('locations/index.json') }}');
      const cities = await response.json();
      $.each(cities, function(index, each) {
        $('#select-city').append(`
          <option data-path='${each.file_path}'>
            ${index}
          </option>
        `);
      });

      $("#select-city").change(function() {
        loadDistrict();
      });
      $("#select-district").select2();
      loadDistrict();

      $("#select-company").select2({
          tags: true,
          ajax: {
            url: '{{ route('api.companies') }}',
            data: function (params) {
              var queryParameters = {
                q: params.term
              }
              return queryParameters;
            },
            processResults: function (data) {
              return {
                results: $.map(data.data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
              };
            }
          }
      });

      $("#select-language").select2({
          ajax: {
            url: '{{ route('api.languages') }}',
            data: function (params) {
              var queryParameters = {
                q: params.term
              }
              return queryParameters;
            },
            processResults: function (data) {
              return {
                results: $.map(data.data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
              };
            }
          }
      });
    }); 
</script>
@endpush