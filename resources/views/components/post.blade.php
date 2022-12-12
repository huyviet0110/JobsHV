<div class="col-md-6 col-lg-4">
    <div class="rotating-card-container manual-flip" style="height: 328.844px; margin-bottom: 30px;">
        <div class="card card-rotate">
            <div class="front" style="height: 328.844px; width: 360px;">
                <div class="card-content">
                    @if($post->is_pinned)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                             style="width: 20px; height: 20px; position: absolute; top: 10px; right: 10px;">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M32 32C32 14.3 46.3 0 64 0H320c17.7 0 32 14.3 32 32s-14.3 32-32 32H290.5l11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3H32c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64H64C46.3 64 32 49.7 32 32zM160 384h64v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V384z"/>
                        </svg>
                    @endif
                    <h5 class="category-social text-success">
                        <a href="{{ route('applicant.show', $post) }}">
                            <i class="fa fa-newspaper-o"></i> {{ $post->job_title }}
                        </a>
                    </h5>
                    <h4 class="card-title">
                        <a href="#pablo">
                            {{ $languages }}
                        </a>
                    </h4>
                    <p class="card-description">
                        {{ $post->location }}
                    </p>
                    <div class="footer text-center"
                         style="justify-content: space-between; display: flex; align-items: center;">
                        <div class="author">
                            {{--                        @todo @huyviet0110 --}}
                            <a href="#">
                                <img src="{{ asset($post->company->logo) }}" alt="..." class="avatar img-raised">
                                <span>{{ $post->company->name }}</span>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div>
                        {{ $post->salary }}
                    </div>
                    @isset($post->end_date)
                        @if($post->is_closed)
                            <br>
                            <div style="position: absolute; right: 10px; bottom: 10px;">
                                <i class="fa fa-close"></i>
                                {{ __('frontpage.is_closed') }}
                            </div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
