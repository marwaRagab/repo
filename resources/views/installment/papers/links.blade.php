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
            ['route' => 'installment.papers.not_finished', 'label' => 'المعاملات الغير مستلمة', 'count' => $all_counters['not_finished_counter'], 'slug' => 'not_finished', 'class' => 'btn-info'],
            ['route' => 'installment.papers.index', 'label' => 'المعاملات المستلمة', 'count' => $all_counters['received_counter'], 'slug' => 'received', 'class' => 'btn-success'],
            ['route' => 'installment.papers.tadqeeq', 'label' => 'التدقيق', 'count' => $all_counters['tadqeeq_counter'], 'slug' => 'tadqeeq', 'class' => 'btn-danger'],
            ['route' => 'installment.papers.manage_review', 'label' => 'الإدارة', 'count' => $all_counters['manage_review_counter'], 'slug' => 'manage_review', 'class' => 'btn-default'],
            ['route' => 'installment.papers.archive', 'label' => 'تسليم المحفوظات', 'count' => $all_counters['archive_counter'], 'slug' => 'archive', 'class' => 'btn-info'],
            ['route' => 'installment.papers.archive_finished', 'label' => 'المحفوظات', 'count' => $all_counters['archive_finished_counter'], 'slug' => 'archive_finished', 'class' => 'btn-warning'],
        ];
    @endphp

    @foreach ($routes as $route)
        <a href="{{ route($route['route']) }}" class="btn btn-block btn-rounded {{ $route['class'] }}" role="button">
            @if ($slug == $route['slug'])
                <span class="btn-label"><i class="fa fa-check"></i></span>
            @endif
            {{ $route['label'] }} ({{ $route['count'] }})
        </a>
    @endforeach
</div>
