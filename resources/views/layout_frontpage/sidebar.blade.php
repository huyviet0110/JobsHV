<div class="col-md-3">
    <div class="card card-refine card-plain">
        <div class="card-content">
            <form action="{{ route('applicant.index') }}">
                <h4 class="card-title">
                    Refine
                    <a class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" rel="tooltip" title=""
                       data-original-title="Reset Filter"
                       href="{{ route('applicant.index') }}"
                    >
                        <i class="material-icons">cached</i>
                    </a>
                </h4>
                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="tabFilter">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                            <h4 class="panel-title">Filter</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseFilter" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="tabFilter">
                        <div class="panel-body">
                            <div class="checkbox">
                                <label>Remoteable</label>
                                <select class="form-control" name="remotable">
                                    @foreach($filtersPostRemotable as $key => $val)
                                        <option value="{{ $val }}" @if((int)$remotable === $val) selected @endif>
                                            {{ __('frontpage.' . $key) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        value="1"
                                        data-toggle="checkbox"
                                        name="is_part_time"
                                        @if($is_part_time)
                                            checked
                                        @endif
                                    >
                                    {{ __('frontpage.can_part_time') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="tabPrice">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                            <h4 class="panel-title">Price Range</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingOne">
                        <input type="hidden" name="min_salary" value="{{ $minSalary }}" id="input-min-salary">
                        <input type="hidden" name="max_salary" value="{{ $maxSalary }}" id="input-max-salary">
                        <div class="panel-body panel-refine">
                            <span class="pull-left">
                                $
                                <span id="span-min-salary">
                                    {{ $minSalary }}
                                </span>
                            </span>
                            <span class="pull-right">
                                $
                                <span id="span-max-salary">
                                    {{ $maxSalary }}
                                </span>
                            </span>
                            <div class="clearfix"></div>
                            <div id="sliderRefine"
                                 class="slider slider-rose noUi-target noUi-ltr noUi-horizontal">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="tabLocation">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
                            <h4 class="panel-title">{{ __('frontpage.location')  }}</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseLocation" class="panel-collapse collapse in" aria-expanded="true" role="tabpanel"
                         aria-labelledby="collapseLocation">
                        <div class="panel-body">
                            @foreach($arrCity as $city)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="cities[]" value="{{ $city }}"
                                               data-toggle="checkbox"
                                               @if(in_array($city, $searchCities, true))
                                                   checked
                                            @endif
                                        >
                                        {{ $city }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>

                <button class="btn btn btn-rose btn-round">
                    <i class="material-icons">search</i>
                    Search
                </button>
            </form>
        </div>
    </div>
</div>
