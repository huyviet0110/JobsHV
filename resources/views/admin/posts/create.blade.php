@extends('layout.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/summernote-bs4.css') }}">
    <style>
      .error {
        color: red !important;
      }
      input[data-switch]:checked + label:after {
        left: 90px;
      }
      input[data-switch] + label {
        width: 110px;
      }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="alert alert-danger" id="error" style="display: none;"><ul id="list-error"></ul></div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="post" class="form-horizontal" id="form-create-post">
                        @csrf
                        <div class="form-group">
                            <label for="select-company">Company</label>
                            <select class="form-control col-md-6" name="company" id="select-company"></select>
                        </div>

                        <div class="form-group">
                            <label for="select-language">Language (*)</label>
                            <select class="form-control" name="languages[]" id="select-language" multiple></select>
                        </div>

                        <div class="form-row select-location">
                          <div class="form-group col-6">
                            <label for="select-city">City (*)</label>
                            <select class="form-control select-city" name="city" id="select-city"></select>
                          </div>
                          <div class="form-group col-6">
                              <label for="select-district">District</label>
                              <select class="form-control select-district" name="district" id="select-district"></select>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-3">
                            <label for="min_salary">Min Salary</label>
                            <input type="number" name="min_salary" id="min_salary" class="form-control">
                          </div>
                          <div class="form-group">
                            <br><br>
                            <label>-</label>
                          </div>
                          <div class="form-group col-3">
                            <label for="max_salary">Max Salary</label>
                            <input type="number" name="max_salary" id="max_salary" class="form-control">
                          </div>
                          <div class="form-group col-3">
                            <label for="currency_salary">Currency</label>
                            <select class="form-control" name="currency_salary" id="currency_salary">
                              @foreach ($currencies as $currency => $value)
                                <option value="{{ $value }}">
                                  {{ $currency }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="requirement">Requirement</label>
                            <textarea class="form-control" id="text-requirement" name="requirement"></textarea>
                          </div>

                          <div class="form-group col-6">
                            <label for="number_applicants">Number Applicants</label>
                            <input type="number" name="number_applicants" id="number_applicants" class="form-control">
                            <br>
                            <input type="checkbox" id="remote" name="remotables[remote]" checked data-switch="success"/>
                            <label for="remote" data-on-label="Can remote" data-off-label="No remote"></label>
                            <input type="checkbox" id="office" name="remotables[office]" checked data-switch="success"/>
                            <label for="office" data-on-label="Can office" data-off-label="No office"></label>
                            <br>
                            <input type="checkbox" id="is_part_time" name="is_part_time" checked data-switch="infor"/>
                            <label for="is_part_time" data-on-label="Can part-time" data-off-label="No part-time"></label>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                          </div>
                          <div class="form-group">
                            <br><br>
                            <label>-</label>
                          </div>
                          <div class="form-group col-3">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="title">Title (*)</label>
                            <input type="text" name="job_title" id="title" class="form-control">
                          </div>
                          <div class="form-group col-6">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control">
                          </div>
                        </div>

                        <div class="form-group">
                          <button class="btn btn-primary" id="btn-submit" >
                            Create
                          </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-company" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title float-left">Create Company</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.companies.store') }}" method="post" id="form-create-company" class="form-horizontal">
              @csrf
              <div class="form-group">
                <label for="company">Company</label>
                <input readonly type="text" name="name" id="company" class="form-control">
              </div>

              <div class="form-row select-location">
                <div class="form-group col-4">
                  <label for="country">Country</label>
                  <select id="country" name="country" class="form-control">
                    @foreach ($countries as $code => $name)
                    <option value="{{ $code }}">
                      {{ $name }}
                    </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="city">City (*)</label>
                  <select class="form-control select-city" name="city" id="city"></select>
                </div>
                <div class="form-group col-4">
                  <label for="district">District</label>
                  <select class="form-control select-district" name="district" id="district"></select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-6">
                  <label for="address">Address</label>
                  <input type="text" name="address" id="address" class="form-control">
                </div>
                <div class="form-group col-6">
                  <label for="address2">Address2</label>
                  <input type="text" name="address2" id="address2" class="form-control">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-6">
                  <label for="zipcode">Zipcode</label>
                  <input type="number" name="zipcode" id="zipcode" class="form-control">
                </div>
                <div class="form-group col-6">
                  <label for="phone">Phone</label>
                  <input type="number" name="phone" id="phone" class="form-control">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group col-6">
                  <label for="logo">Logo</label>
                  <input type="file" name="logo" id="logo" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                  <img id="pic" height="100px" />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="submitForm('company')" class="btn btn-success">Create</button>
          </div>
        </div>

      </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>
<script>
    function checkCompany(){
      $.ajax({
        url: '{{ route('api.companies.check') }}',
        type: 'POST',
        dataType: 'json',
        data: {company: $("#select-company").val()},
        success: function(response){
          if(response.data){
            submitForm('post');
          } else {
            $("#modal-company").modal('show');
            $("#company").val($("#select-company").val());
            $("#city").val($("#select-city").val()).trigger('change');
          }
        }
      });

    }

    function submitForm(type){
      const obj = $("#form-create-" + type);
      const formData = new FormData(obj[0]);
      $.ajax({
        url: obj.attr('action'),
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        enctype: 'multipart/form-data',
        data: formData,
        success: function(response){
          if(response.success){
            $("#list-error").empty();
            $("#error").hide();
            $("#modal-company").modal("hide");
            notifySuccess();
          } else {
            showError(response.message);
          }
        },
        error: function(response){
          let errors;
          if(response.responseJSON.errors){
            errors = Object.values(response.responseJSON.errors);
            showError(errors);
          } else {
            errors = response.responseJSON.message;
            showError(errors);
          }
        }
      });
    }

    function showError(errors){
      let message = '';
      $("#list-error").empty();
      message += `<ul>`;
      if(Array.isArray(errors)){
        errors.forEach(function(each){
          each.forEach(function(error){
            message += `<li>${error}</li>`;
          });
        });
      } else {
        message += `<li>${errors}</li>`;
      }
      message += `</ul>`;
      $("#list-error").append(message);
      $("#error").show();
      notifyError(message);
    }

    function generateTitle(){
      let city = $("#select-city").val();
      let company = $("#select-company").val();
      let languages = [];
      $('#select-language :selected').each(function(index, selected){
        languages.push($(selected).text());
      });
      languages = languages.join(', ');
      if(company !== ''){
        company = '- ' + company;
      }
      let title = `(${city}) ${languages} ${company}`;

      $("#title").val(title);
      generateSlug(title);
    }

    function generateSlug(title){
      $.ajax({
        url: '{{ route('api.posts.slug.generate') }}',
        type: 'POST',
        dataType: 'json',
        data: {title},
        success: function(response) {
          $("#slug").val(response.data);
          $("#slug").trigger('change');
        },
        error: function(response) {

        },
      });
    }

    async function loadDistrict(parent) {
      parent.find(".select-district").empty();
      const path = parent.find(".select-city option:selected").data('path');
      const response = await fetch('{{ asset('locations/') }}' + path);
      const districts = await response.json();
      const selectedValue = $("#select-district").val();
      let string = '';
      $.each(districts.district, function(index, each) {
        if(each.pre === 'Quận' || each.pre === 'Huyện'){
          string += `<option`;
          if(each.name === selectedValue){
            string += ` selected`;
          }
          string += `>${each.name}</option>`;
        }
      });
      parent.find(".select-district").append(string);
    }

    $(document).ready(async function() {
      $("#text-requirement").summernote();
      $("#select-city").select2({tags: true});
      $("#city").select2({tags: true});
      const response = await fetch('{{ asset('locations/index.json') }}');
      const cities = await response.json();
      $.each(cities, function(index, each) {
        $('#select-city').append(`
          <option data-path='${each.file_path}'>
            ${index}
          </option>
        `);
        $('#city').append(`
          <option data-path='${each.file_path}'>
            ${index}
          </option>
        `);
      });

      $("#select-city, #city").change(function() {
        loadDistrict($(this).parents('.select-location'));
      });
      $("#select-district").select2({tags: true});
      $("#district").select2({tags: true});
      loadDistrict($('#select-city').parents('.select-location'));

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
                        id: item.name
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

      $(document).on('change', '#select-city, #select-language, #select-company', function(){
        generateTitle();
      });

      $("#slug").change(function() {
        $.ajax({
          url: '{{ route('api.posts.slug.check') }}',
          type: 'GET',
          dataType: 'json',
          data: { slug: $(this).val() },
          success: function(response){
            $("#btn-submit").attr('disabled', false);
          },
          error: function(response){

          }
        });
      });

      $("#form-create-post").validate({
        rules: {
          company: {
            required: true,
          }
        },
        submitHandler: function(form) {
          checkCompany();
        }
      });
    });
</script>
@endpush
