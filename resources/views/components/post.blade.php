<div class="col-md-6 col-lg-4">
    <div class="rotating-card-container manual-flip" style="height: 328.844px; margin-bottom: 30px;">
        <div class="card card-rotate">
            <div class="front" style="height: 328.844px; width: 360px;">
                <div class="card-content">
                    <h5 class="category-social text-success">
                        <i class="fa fa-newspaper-o"></i> {{ $post->job_title }}
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
                </div>
            </div>
        </div>
    </div>
</div>
