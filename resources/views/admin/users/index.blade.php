@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline" id="form-filter">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="col-5">
                                <select class="form-control select-filter" id="role" name="role">
                                    <option value="">All</option>
                                    @foreach($roles as $role => $value)
                                        <option value="{{ $value }}" @if((string)$value === $selectedRole) selected @endif>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">City</label>
                            <div class="col-5">
                                <select class="form-control select-filter" id="city" name="city">
                                    <option value="">All</option>
                                    @foreach($cities as $city)
                                        <option @if($city === $selectedCity) selected @endif>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">Company</label>
                            <div class="col-5">
                                <select class="form-control select-filter" id="company" name="company">
                                    <option value="">All</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if((string)$company->id === $selectedCompany) selected @endif>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Info</th>
                                <th>Role</th>
                                <th>Position</th>
                                <th>City</th>
                                <th>Company</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data as $each)
                                <tr>
                                    <td>
                                        <a href="{{ route("admin.$table.show", $each) }}">
                                            {{ $each->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <img src="{{ $each->avatar }}" width="100px">
                                    </td>
                                    <td>
                                        {{ $each->name }} - {{ $each->gender_name }}
                                        <br>
                                        <a href="mailto:{{ $each->email }}" target="_blank">
                                            {{ $each->email }}
                                        </a>
                                        <br>
                                        <a href="tel:{{ $each->phone }}">
                                            {{ $each->phone }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $each->role_name }}
                                    </td>
                                    <td>
                                        {{ $each->position }}
                                    </td>
                                    <td>
                                        {{ $each->city }}
                                    </td>
                                    <td>
                                        {{ optional($each->company)->name }}
                                    </td>
                                    <td>
                                        <form action="{{ route("admin.$table.destroy", $each) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>

                    <nav>
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".select-filter").change(function() {
            $("#form-filter").submit();
        });
    });
</script>
@endpush
