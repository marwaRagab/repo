
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap" id="slugButtons">
        @foreach ($papers_type as $type)
            <a href="javascript:void(0);"
               data-slug="{{ $type['slug'] ?? 'index' }}"
               class="btn {{ $type['style'] }}">
               {{ $type['name_ar'] }} ({{ $type['count'] }})
            </a>
        @endforeach
    </div>
</div>
