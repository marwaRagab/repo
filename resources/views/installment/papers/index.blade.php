<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المحفوظات</h4>
        <div class="d-flex">



        </div>
    </div>

    <div class="card-body">
        @include('installment.papers.links', $papers_type)

<table class="table table-bordered" id="papersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم المعاملة</th>
                                <th>اسم العميل</th>
                                <th>تاريخ الإستلام</th>
                                <th>صورة الإستلام</th>
                                <th>خيارات</th>
                            </tr>
                        </thead>
                    </table>


</div>
</div>
<script>
    $(document).ready(function() {
        $('#papersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('installment.papers.getAllData', $slug ?? '') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'transaction_number', name: 'transaction_number' },
                { data: 'client_name', name: 'client_name' },
                { data: 'received_date', name: 'received_date' },
                {
                    data: 'paper_img_dir',
                    name: 'paper_img_dir',
                    render: function(data) {
                        return data ? `<a href="${data}" target="_blank" class="btn btn-info">عرض</a>` : 'N/A';
                    }
                },
                {
                    data: 'actions',
                    name: 'actions', 
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    }
                }
            ]
        });
    });
</script>
