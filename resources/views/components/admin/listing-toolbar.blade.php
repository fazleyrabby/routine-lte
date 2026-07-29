@props([
    'search' => '',
    'searchPlaceholder' => 'Search…',
    'perPage' => 20,
    'perPageOptions' => [10, 20, 50, 100],
    'filters' => [], // array of ['field' => 'status', 'label' => 'Status', 'options' => ['active' => 'Active', ...]]
    'appliedFilters' => [],
])

<form method="GET" action="{{ url()->current() }}" class="d-flex flex-wrap gap-2 align-items-center mb-3">
    <!-- Hidden inputs to preserve non-filter params -->
    @foreach(request()->except(['search', 'page', 'per_page']) as $key => $value)
        @if(!str_starts_with($key, 'filter_') && $key !== 'sort' && $key !== 'direction')
            @if(is_array($value))
                @foreach($value as $vk => $vv)
                    <input type="hidden" name="{{ $key }}[{{ $vk }}]" value="{{ $vv }}">
                @endforeach
            @elseif($value !== '')
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endif
    @endforeach
    <input type="hidden" name="sort" value="{{ request('sort', 'id') }}">
    <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">

    <!-- Search -->
    <div style="min-width: 200px; max-width: 300px;">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ $searchPlaceholder }}" value="{{ $search }}" autocomplete="off" onchange="this.form.submit()">
            @if($search)
            <span class="input-group-text">
                <a href="{{ url()->current() . '?' . http_build_query(request()->except(['search', 'page'])) }}" class="text-secondary text-decoration-none">&times;</a>
            </span>
            @endif
        </div>
    </div>

    <!-- Filters -->
    @foreach($filters as $filter)
    <div>
        <select name="filter_{{ $filter['field'] }}" class="form-select" onchange="this.form.submit()" style="width: auto;">
            <option value="">— {{ $filter['label'] }} —</option>
            @foreach($filter['options'] as $val => $label)
            <option value="{{ $val }}" {{ ($appliedFilters[$filter['field']] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @endforeach

    <!-- Per Page -->
    <div>
        <select name="per_page" class="form-select" onchange="this.form.submit()" style="width: auto;">
            @foreach($perPageOptions as $opt)
            <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>{{ $opt }} / page</option>
            @endforeach
        </select>
    </div>
</form>
