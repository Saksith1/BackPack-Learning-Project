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
{{-- <script>
    // var file_input=document.querySelector('#file');
    // document.querySelector('#file').style.display="none";
    $(document).ready(function(){
        $('body').on('click','.btn-upload-file-excel',function(){
            var eThis = $(this);
            var frm = eThis.closest('form.form-upload');
            var formData = new FormData(frm[0]);
            $.ajax({
              url: '/trainer/import',
              type: 'POST',
              data: formData,
              cache:false,
              contentType: false,
              processData: false,
              success: function(result) {
                  // Show an alert with the result
                  console.log(result,route);
                  new Noty({
                      text: "Some Tx had been imported",
                      type: "success"
                  }).show();

                  // Hide the modal, if any
                  $('.modal').modal('hide');

                  crud.table.ajax.reload();
              },
              error: function(result) {
                  // Show an alert with the result
                  new Noty({
                      text: "The new entry could not be created. Please try again.",
                      type: "warning"
                  }).show();
              }
          });
        });
    });
    // file_input.addEventListener('change', function () {
    //     alert('ok');
    // });
    // if (typeof importTransaction != 'function') {
    //   $("[data-button-type=import]").unbind('click');

    //   function importTransaction(button) {
    //       // ask for confirmation before deleting an item
    //       // e.preventDefault();
    //       var button = $(button);
    //     //   var route = button.attr('data-route');

    //       $.ajax({
    //           url: '/trainer/import',
    //           type: 'GET',
    //           success: function(result) {
    //               // Show an alert with the result
    //               console.log(result,route);
    //               new Noty({
    //                   text: "Some Tx had been imported",
    //                   type: "success"
    //               }).show();

    //               // Hide the modal, if any
    //               $('.modal').modal('hide');

    //               crud.table.ajax.reload();
    //           },
    //           error: function(result) {
    //               // Show an alert with the result
    //               new Noty({
    //                   text: "The new entry could not be created. Please try again.",
    //                   type: "warning"
    //               }).show();
    //           }
    //       });
    //   }
    // }
</script> --}}

<!-- Modal -->

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form class="form-upload" method="POST" action="/trainer/import" enctype="multipart/form-data">
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
