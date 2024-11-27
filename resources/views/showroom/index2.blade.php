<div class="mb-3 overflow-hidden position-relative">
    <div class="px-3">
      <h4 class="fs-6 mb-0">Datatable Advanced</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="../horizontal/index.html">Home</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">Datatable Advanced</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="datatables">
    <!-- start File export -->
    <div class="card">
      <div class="card-body">
        <div class="mb-2">
          <h4 class="card-title mb-0">File export</h4>
        </div>
        <p class="card-subtitle mb-3">
          Exporting data from a table can often be a key part of a
          complex application. The Buttons extension for DataTables
          provides three plug-ins that provide overlapping
          functionality for data export. You can refer full
          documentation from here
          <a href="https://datatables.net/">Datatables</a>
        </p>
        <div class="table-responsive">
          <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
            <thead>
              <!-- start row -->
              <tr>
                <th>name</th>
                <th>name_en</th>
                <th>phone</th>
                <th>اجراءات</th>
              </tr>
              <!-- end row -->
            </thead>
            <tbody>
                @foreach ($data as $one)
                    
              
              <!-- start row -->

              <tr>
                <td>{{$one->name_ar}}</td>
                <td>{{$one->name_en}}</td>
                <td>{{$one->place}}</td>
                  <td>
                      <!-- Primary header modal -->
                      <button type="button" class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal" data-bs-target="#primary-header-modal{{ $one->id }}">
                       إرسال رابط
                      </button>
                      <!-- Primary Header Modal -->
                      <div id="primary-header-modal{{ $one->id }}" class="modal fade" tabindex="-1" aria-labelledby="primary-header-modalLabel{{ $one->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header modal-colored-header bg-primary text-white">
                              <h4 class="modal-title text-white" id="primary-header-modalLabel">
                                Modal Heading
                              </h4>
                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <h5 class="mt-0">Primary Background</h5>
                              <p>
                               my broker id is {{ $one->id }}
                              </p>
                              <p>
                                Praesent commodo cursus magna, vel scelerisque
                                nisl consectetur et. Vivamus sagittis lacus vel
                                augue laoreet rutrum faucibus dolor auctor.
                              </p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Close
                              </button>
                              <button type="button" class="btn bg-primary-subtle text-primary ">
                                Save changes
                              </button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->
                  </td>
              </tr>
              <!-- end row -->
              @endforeach
             
              <!-- end row -->
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    </div>
