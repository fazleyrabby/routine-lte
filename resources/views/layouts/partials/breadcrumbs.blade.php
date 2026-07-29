<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                    @php $segments = ''; @endphp
                    <li class="breadcrumb-item">
                        <a href="{{ url('/admin') }}">Home</a>
                    </li>
                    @foreach(Request::segments() as $segment)
                        @php
                            $slug = str_replace('_',' ',$segment);
                            $segments .= '/'.$segment;
                        @endphp
                        <li class="breadcrumb-item">
                            <a href="{{ $segments }}">{{ ucfirst($slug) }}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
