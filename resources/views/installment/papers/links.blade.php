<div class="row bg-title">
    <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
</div>

<div class="btn-group btn-group-justified m-b-20">
    @php
    $routes = [
        ['route' => 'installment.papers.status', 'label' => 'المعاملات الغير مستلمة', 'count' => $all_counters['not_finished_counter'], 'status' => 'not_finished', 'class' => 'btn-info'],
        ['route' => 'installment.papers.status', 'label' => 'المعاملات المستلمة', 'count' => $all_counters['received_counter'], 'status' => 'received', 'class' => 'btn-success'],
        ['route' => 'installment.papers.status', 'label' => 'التدقيق', 'count' => $all_counters['tadqeeq_counter'], 'status' => 'tadqeeq', 'class' => 'btn-danger'],
        ['route' => 'installment.papers.status', 'label' => 'الإدارة', 'count' => $all_counters['manage_review_counter'], 'status' => 'manage_review', 'class' => 'btn-default'],
        ['route' => 'installment.papers.status', 'label' => 'تسليم المحفوظات', 'count' => $all_counters['archive_counter'], 'status' => 'archive', 'class' => 'btn-info'],
        ['route' => 'installment.papers.status', 'label' => 'المحفوظات', 'count' => $all_counters['archive_finished_counter'], 'status' => 'archive_finished', 'class' => 'btn-warning'],
    ];
    @endphp

    @foreach ($routes as $route)
        <a href="{{ route($route['route'], ['status' => $route['status']]) }}" class="btn {{ $route['class'] }}">
            {{ $route['label'] }} ({{ $route['count'] }})
        </a>
    @endforeach
</div>
