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
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
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
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 class="panel-title">Clothing</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="true" role="tabpanel"
                         aria-labelledby="headingTwo">
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
