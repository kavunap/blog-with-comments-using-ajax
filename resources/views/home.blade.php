@extends('layouts.app')
 
@section('content')
<div class="container">
    <h1 class="page-header text-center">Laravel User Post using AJAX</h1>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="postForm">
                        <textarea class="form-control" name="post" id="post" placeholder="What's on your mind?"></textarea>
                        <button type="button" id="postBtn" class="btn btn-primary" style="margin-top:5px;"><i class="fa fa-pencil-square-o"></i> POST</button>
                    </form>
                </div>
            </div>
            <div id="postList"></div>
        </div>
    </div>
</div>
@endsection
 
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            showPost();
 
            $('#postBtn').click(function(){
                var post = $('#post').val();
                if(post==''){
                    alert('Please write a Post first!');
                    $('#post').focus();
                }
                else{
                    var postForm = $('#postForm').serialize();
                    $.ajax({
                        type: 'POST',
                        url: '/post',
                        data: postForm,
                        dataType: 'json',
                        success: function(){
                            showPost();
                            $('#postForm')[0].reset();
                        },
                    });
                }
            });
 
            $(document).on('click', '.comment', function(){
                var id = $(this).val();
                if($('#commentField_'+id).is(':visible')){
                    $('#commentField_'+id).slideUp();
                }
                else{
                    $('#commentField_'+id).slideDown();
                    getComment(id);
                }
            });
 
            $(document).on('click', '.submitComment', function(){
                var id = $(this).val();
                if($('#commenttext').val()==''){
                    alert('Please write a Comment First!');
                }
                else{
                    var commentForm = $('#commentForm_'+id).serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'writecomment',
                        data: commentForm,
                        success: function(){
                            getComment(id);
                            $('#commentForm_'+id)[0].reset();
                        },
                    });
                }
 
            });
 
        });
 
        function showPost(){
            $.ajax({
                url: '/show',
                success: function(data){
                    $('#postList').html(data); 
                },
            });
        }
 
        function getComment(id){
            $.ajax({
                url: 'getcomment',
                data: {id:id},
                success: function(data){
                    $('#comment_'+id).html(data); 
                }
            });
        }
    </script>
@endsection