<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>

</head>
  <style>
  .alert-message {
    color: red;
  }
</style>
<body>

<div class="container">
    <h2><strong>{{ $blog->comments->count() }}</strong> Comments</h2><br>
    <div class="row">
       <div class="col-12 text-right">
         <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-comment" onclick="addComment()">Add Comment</a>
       </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
          <table id="" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blog->comments as $comment)
                <tr id="row_{{$comment->id}}">
                   <td>{{ $comment->id  }}</td>
                   <td>{{ $comment->description }}</td>
                   <td><a href="javascript:void(0)" data-id="{{ $comment->id }}" onclick="editComment(event.target)" class="btn btn-info">Edit</a></td>
                   <td>
                    <a href="javascript:void(0)" data-id="{{ $comment->id }}" class="btn btn-danger" onclick="deleteComment(event.target)" data-confirm="Are you sure?">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

<div class="modal fade" id="comment-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
              <form name="userForm" class="form-horizontal">
                 <input type="hidden" name="comment_id" id="comment_id">
                 @csrf
                 
                 
                 <input type="hidden" id="blog_id" name="blog_id" value="{{ $blog->id }}">
  
                  <div class="form-group">
                      <label class="col-sm-2">Description</label>
                      <div class="col-sm-12">
                          <textarea class="form-control" id="description" name="description" placeholder="Enter description" rows="4" cols="50"></textarea>
                          <span id="descriptionError" class="alert-message"></span>
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="createCmt()">Save</button>
          </div>
      </div>
    </div>
  </div>
</body>

<script>
  function hidemodal(){
    $('#comment-modal').modal('hide');
  }
    $('#laravel_crud').DataTable();
  
    function addComment() {
      $("#comment_id").val('');
      $('#comment-modal').modal('show');
    }
  
    function editComment(event) {
      var id  = $(event).data("id");
      let _url = `/comments/${id}`;
      $('#titleError').text('');
      $('#descriptionError').text('');
      
      $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            if(response) {
              $("#comment_id").val(response.id);
              $("#blog_id").val(response.blog_id);
              $("#description").val(response.description);
              $('#comment-modal').modal('show');
            }
        }
      });
    }
  

    function createCmt() {
      var blog_id = $('#blog_id').val();
      var description = $('#description').val();
      var id = $('#comment_id').val();
  
      let _url     = `/comments`;
      let _token   = $('meta[name="csrf-token"]').attr('content');
  
        $.ajax({
          url: _url,
          type: "POST",
          data: {
            id: id,
            blog_id: blog_id,
            description: description,
            _token: _token
          },
          success: function(response) {
              if(response.code == 200) {
                if(id != ""){
                  $("#row_"+id+" td:nth-child(2)").html(response.data.blog_id);
                  $("#row_"+id+" td:nth-child(3)").html(response.data.description);
                } else {
                  $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.description+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editComment(event.target)" class="btn btn-info">Edit</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteComment(event.target)">Delete</a></td></tr>');
                }
                // $('#blog_id').val('');
                $('#description').val('');
  
                $('#comment-modal').modal('hide');
              }
          },
          error: function(response) {
            $('#titleError').text(response.responseJSON.errors.blog_id);
            $('#descriptionError').text(response.responseJSON.errors.description);
          }
        });
    }
  
    function deleteComment(event) {
      var id  = $(event).data("id");
      let _url = `/comments/${id}`;
      let _token   = $('meta[name="csrf-token"]').attr('content');
  
        $.ajax({
          url: _url,
          type: 'DELETE',
          data: {
            _token: _token
          },
          success: function(response) {
            $("#row_"+id).remove();
          }
        });
    }
  
  </script>

</html>