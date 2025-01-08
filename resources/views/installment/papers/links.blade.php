
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap">
        @foreach ($papers_type as $type)
    <a href="{{ route('installment.papers.status', ['status' => $type['slug']??'index']) }}" class="btn {{ $type['style'] }}">
        {{ $type['name_ar'] }} ({{ $type['count'] }})
    </a>
@endforeach
    </div>
</div>
