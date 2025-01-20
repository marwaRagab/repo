<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap" id="slugButtons">
        @foreach ($papers_type as $type)
        <a href="{{ route('installment.papers.status',  $type['slug']) }}"
            data-slug="{{ $type['slug'] ?? 'index' }}"
            class="btn {{ $type['style'] }} {{ $status == $type['slug'] ? 'active' : '' }}">
            {{ $type['name_ar'] }} ({{ $type['count'] }})
        </a>
        @endforeach
    </div>
</div>






