<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المحفوظات</h4>
        <div class="d-flex">



        </div>
    </div>

    <div class="card-body">
        @include('installment.papers.links', ['papers_type' => $papers_type, 'slug' => $status])


        <div class="table-responsive pb-4">
            <table id="papersTable" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم المعاملة</th>
                        <th>اسم العميل</th>
                        <th>التاريخ </th>
                        <th>معتمد المعاملة</th>

                        @if ($status == 'index' || $status == 'not_finished')
                            <th>تسليم معاملة</th>
                        @else
                            <th>خيارات</th>
                        @endif
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let slug = '';

        const table = $('#papersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('installment.papers.getAllData') }}",
                data: function(d) {
                    d.slug = slug || $('#slugButtons a.active').data('slug');
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'transaction_number',
                    name: 'transaction_number'
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'received_date',
                    name: 'received_date'
                },

                {
                    data: 'created_by',
                    name: 'created_by'
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
            ],
            language: {
                url: "{{ asset('assets/js/datatables/i18n/ar.json') }}", // Arabic translations
            }
        });
        $('#slugButtons a').on('click', function() {
            slug = $(this).data('slug');
            console.log(slug);
            table.ajax.reload();
        });
    });
</script>
