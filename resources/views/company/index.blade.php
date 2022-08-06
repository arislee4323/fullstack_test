@extends('layouts.admin')
@section('header', 'Employe')
@section('content')
@section('css')
        <!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
@endsection
<div id="controller">
  <div class="card">
    <div class="card-header">

           <a href="#" @click="addData()" class="btn btn-primary pull-right">Create New Employe</a>
    </div>
    

    <div class="card-body">
              <table id="datatables" class="table table-striped table-bordered">
              <thead>
            <tr>
                <th>No</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                <th>Actions</th>
            </tr>
              </thead>
          </table>

            </div>


  <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <form :action="actionUrl" method="post" autocomplete="off" @submit="submitForm($event, data.id)">
                <div class="modal-header">
                  <h4 class="modal-title">Default Modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                      <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" name="firstname" :value="data.firstname" class="form-control" placeholder="Input Name" required="">
                      </div>
                      <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" name="lastname" :value="data.lastname" class="form-control" placeholder="Input Lastname" required="">
                      </div>
                      <div class="form-group">
                        <label>Company</label>
                                 <select name="company_id" class="form-control">
                                    @foreach($companies as $company)
                                    <option :selected="data.company_id" value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                 </select>
                            </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" :value="data.email" class="form-control" placeholder="Input Email" required="">
                      </div>
                     <div class="form-group">
                        <label>Phone</label>
                        <input type="number" name="phone" :value="data.phone" class="form-control" placeholder="Input Phone" required="">
                      </div>
                    </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
  </div>
</div>

@endsection
@section('js')

<!-- DataTables -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
});
</script>
<script>
    var actionUrl = '{{ url('employe') }}';
    var apiUrl = '{{ url('api/employe') }}';

    var columns = [
    {data: 'DT_RowIndex', class: 'text-center', orderable: true},
    {data: 'firstname', class: 'text-center', orderable: true},
    {data: 'lastname', class: 'text-center', orderable: true},
    {data: 'company_id', class: 'text-center', orderable: true},
    {data: 'email', class: 'text-center', orderable: true},
    {data: 'phone', class: 'text-center', orderable: true},
    {render: function(index, row, data, meta) {
        return `
            <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
            Edit
            </a>
            <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
            Delete</a>
    `}, orderable: false, width: '200px', class:'text-center'},
    ];

    var controller = new Vue({
        el: '#controller',
        data: {
                datas: [],
                data: {},
                actionUrl,
                apiUrl,
                editStatus : false,
                createStatus : false,
            

            },
            mounted: function () {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatables').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    }); 
                },
                addData() {
                    this.data = {};
                    this.actionUrl = '{{ url('employe') }}';
                    this.editStatus = false;
                    this.createStatus = true;
                    $('#modal-default').modal();
                },
                editData(event, row) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    this.createStatus = false;
                    $('#modal-default').modal(); 
                },
                deleteData(event, id) {
                    if (confirm("Are you sure ?")) {
                        $(event.target).parents('tr').remove();
                            axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                            // location.reload();
                            alert('Data has been removed');
                    });
                }
             },
             submitForm(event, id){
                event.preventDefault();
                const _this = this;
                var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl+'/'+id;
                axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                    $('#modal-default').modal('hide');
                    _this.table.ajax.reload();
                });
             },
        }      
    });

</script>
@endsection
