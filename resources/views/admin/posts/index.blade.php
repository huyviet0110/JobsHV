@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        Create
                    </a>

                    <label for="csv" class="btn btn-info mb-0">Import CSV</label>
                    <input type="file" id="csv" name="csv" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Is Remote</th>
                                <th>Is Part-Time</th>
                                <th>Salary Range</th>
                                <th>Currency Salary</th>
                                <th>Requirement</th>
                                <th>Date Range</th>
                                <th>Status</th>
                                <th>Is Pinned</th>
                                <th>Slug</th>
                                <th>Create At</th>
                            </tr>
                        </thead>
                    </table>

                    <nav>
                        <ul class="pagination pagination-rounded mb-0" id="pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('api.posts') }}',
                dataType: 'json',
                data: {page: {{ request()->get('page') ?? 1 }}},
                success: function(response) {
                  response.data.data.forEach(function(each){
                    let location = '';
                    let salary_range = '';
                    let date_range = '';
                    let remotable = each.remotable ? 'x' : '';
                    let is_part_time = each.is_part_time ? 'x' : '';
                    let is_pinned = each.is_pinned ? 'x' : '';
                    let created_at = formatDatetimeToDisplay(each.created_at);

                    if(each.district !== null){
                      location += each.district;
                      if(each.city !== null){
                        location += ', ' + each.city;
                      }
                    } else {
                      if(each.city !== null){
                        location += each.city;
                      }
                    }

                    if(each.min_salary !== null){
                      salary_range += each.min_salary;
                      if(each.max_salary !== null){
                        salary_range += ' - ' + each.max_salary;
                      }
                    } else {
                      if(each.max_salary !== null){
                        salary_range += each.max_salary;
                      }
                    }

                    if(each.start_date !== null){
                      date_range += each.start_date;
                      if(each.end_date !== null){
                        date_range += ' to ' + each.end_date;
                      }
                    } else {
                      if(each.end_date !== null){
                        date_range += each.end_date;
                      }
                    }

                    $('#data-table').append($('<tr>')
                      .append($('<td>').append(each.id))
                      .append($('<td>').append(each.job_title))
                      .append($('<td>').append(location))
                      .append($('<td>').append(remotable))
                      .append($('<td>').append(is_part_time))
                      .append($('<td>').append(salary_range))
                      .append($('<td>').append(each.currency_salary))
                      .append($('<td>').append(each.requirement))
                      .append($('<td>').append(date_range))
                      .append($('<td>').append(each.status))
                      .append($('<td>').append(is_pinned))
                      .append($('<td>').append(each.slug))
                      .append($('<td>').append(created_at))
                    )
                  });

                  renderPagination(response.data.pagination);
                },
                error: function(response) {
                  console.log(response);
                    $.toast({
                        heading: 'Import Error',
                        text: response.responseJSON.message,
                        showHideTransition: 'slide',
                        icon: 'error',
                        position: 'bottom-right'
                    });
                }
            });

            $(document).on('click', '#pagination a', function(event) {
              event.preventDefault();
              let page = $(this).text();
              let current_page = {{ request()->get('page') ?? 1 }};
              if(page === '« Previous' && current_page !== null && current_page > 1) {
                if(current_page <= 1){
                  page = 1;
                }
                page = current_page - 1;
              } else if(page === 'Next »' && current_page !== null && current_page > 1) {
                if(current_page <= 1){
                  page = 1;
                }
                page = current_page + 1;
              }
              console.log(page);

              let urlParams = new URLSearchParams(window.location.search);
              urlParams.set('page', page);
              window.location.search = urlParams;
            });

            $("#csv").change(function(event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);

                $.ajax({
                    url: '{{ route('admin.posts.import_csv') }}',
                    type: 'POST',
                    data : formData,
                    enctype: 'multipart/form-data',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    success: function(response) {
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data have been imported.',
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'bottom-right'
                        });
                    },
                    error: function(response) {
                        // $.toast({
                        //     heading: 'Import Success',
                        //     text: 'Your data have been to import.',
                        //     showHideTransition: 'slide',
                        //     icon: 'fail',
                        //     position: 'bottom-right'
                        // });
                    }
                });
            });
        });
    </script>
@endpush
