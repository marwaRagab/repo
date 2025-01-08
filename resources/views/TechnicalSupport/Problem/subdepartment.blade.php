<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap mb-3">
       
        @php
            $btnColors = [
                1 => 'info',
                2 => 'warning',
                3 => 'danger',
                4 => 'primary',
                5 => 'secondary',
                6 => 'success',
                7 => 'dark',
            ];
        @endphp
      
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الاقسام الرئيسية 
        </h4>
        
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id ="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم القسم</th>
                        <th>عدد التذاكر </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $problem)
                        <tr>
                            
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if($problem != NuLL)
                                    {{ $problem->name_ar  }}
                                @else
                                   لا يوجد
                                @endif
                            </td>
                                                        
                            <td> <a href="{{ route('supportProblem.getSubproblems', $problem->id) }}"><span class="badge bg-primary">{{ $problem->problems->count() }}</span></a>
                            </td>
                            
                        </tr>
                   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>


</div>

</div>


