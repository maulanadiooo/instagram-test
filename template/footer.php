

<!-- Modal -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form action = '<?=$url_website?>settings/action' class="form-horizontal" method="post" enctype="multipart/form-data" id="order-form">
        <div class="form-group">
          <div class="file-drop-area"> <span class="choose-file-button"><img src="<?=$url_website?>assets/images/uploadlogo.png" width="100px" height="100px"></span> <span class="file-message">or drag and drop files here</span> <input class="file-input" type="file" name="photoupload">
          </div>
        </div>
        <div class="form-group">
            <label  class="form-label text-bold">Caption (max 400 character)</label>
            <div class="input-group mb-3">
                <textarea class="form-control"  name="caption"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="uploadphoto" value="uploadphoto" class="btn btn-primary">Upload</button>
      </div>
    
      <input type="hidden" name="redirectUpload" value="<?=$_SERVER['REQUEST_URI']?>">
      </form>
    </div>
  </div>
</div>
<script>
  $(document).on('change', '.file-input', function() {


  var filesCount = $(this)[0].files.length;

  var textbox = $(this).prev();

  if (filesCount === 1) {
  var fileName = $(this).val().split('\\').pop();
  textbox.text(fileName);
  } else {
  textbox.text(filesCount + ' files selected');
  }
  });
</script>
<!-- vue dan axios -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>
</html>