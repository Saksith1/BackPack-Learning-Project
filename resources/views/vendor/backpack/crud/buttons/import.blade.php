@if ($crud->hasAccess('create'))
    <a href="javascript:void(0)" onclick="importTransaction(this)" data-route="{{ url($crud->route.'/import') }}" class="btn btn-sm btn-success btn-import"
         data-toggle="modal" data-target="#myModal"
         data-button-type="import">
    <span class="ladda-label"><i class="far fa-file-excel"></i> Excel</span>
</a>

@endif
@error('file')
    <span class="text-danger">{{ $message }}</span>
@enderror
@if ($errors->any())
<span class="text-danger">
     @foreach ($errors->all as $error)
         {{ $error }}
     @endforeach
<span>
@endif
@push('after_scripts')
<script>
    $(document).ready(function(){
        $('body').on('click','.btn-upload-file-excel',function(e){
            e.preventDefault();
            var eThis = $(this);
            var frm = eThis.closest('form.form-upload');
            var file=frm.find('#file');
            var formData = new FormData(frm[0]);
            //check file extension
            var extension = file.val().replace(/^.*\./,"");
            if(file.val()==""){
                new Noty({
                      text: "Please Select File",
                      type: "warning"
                  }).show();
            }
            else if(extension != 'xlsx' && extension != 'csv'){
                new Noty({
                      text: "File not supported check your file extension",
                      type: "warning"
                  }).show();
            }
            else{
                // var extension=getFileExtension(file.val());
                // alert(extension);
                $.ajax({
                type:'POST',
                url: "/trainer/import",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                },
                success: (data) => {
                    $("#crudTable").DataTable().ajax.reload();
                    $('.btn-default').click();
                    new Noty({
                      text: "Trainer had been imported",
                      type: "success"
                    }).show();
                },
                error: function(data){
                  // Show an alert with the result
                  $('.btn-default').click();
                  new Noty({
                      text: "The new entry could not be created. Please try again.",
                      type: "warning"
                  }).show();
                }
            })
            }
        });
    });
</script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form class="form-upload" method="POST"  enctype="multipart/form-data">
          @csrf
            <div class="modal-header">
                <h4 class="modal-title float-left">Upload File</h4>
                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="file" name="file" id="file">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-upload-file-excel">Upload</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </form>
    </div>

  </div>
</div>
@endpush
