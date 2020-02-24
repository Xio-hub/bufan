@extends('merchants.layouts.app')

@section('title','首页设置')

@section('styles')
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">              
                @include ('errors.list') {{-- 引入错误文件 --}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content">
                    <form id='formData'>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">{{$introduction->title}}</label></div>
                        <div class="ibox-content no-padding">            
                            <textarea id="summernote" name="content">{{$introduction->content}}</textarea>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-lg" id="btn-cancel">Cancel</a>
                                <a class="btn btn-primary btn-lg" id="btn-save" onclick="save()">确认</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SUMMERNOTE -->
    <script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('#summernote').summernote(
                {
                    height: 500,
                    tabsize: 2,
                    lang: 'zh-CN',
                    // toolbar: [
				    //           [ 'style', [ 'style' ] ],
				    //           [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				    //           [ 'fontname', [ 'fontname' ] ],
				    //           [ 'fontsize', [ 'fontsize' ] ],
				    //           [ 'color', [ 'color' ] ],
				    //           [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				    //           [ 'table', [ 'table' ] ],
				    //           [ 'insert', [ 'link'] ],
				    //           [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
				    //       ]
                    callbacks: {
                        onImageUpload: function(files) {
                            uploadImage(files[0])
                        }
                    }
                }
            );
        });

        function uploadImage(file) {
            var formData = new FormData();
            formData.append("file", file);
            $.ajax({
                url: "{{route('merchant.introduction.image.upload')}}",//这里是你的后端控制器 后面会写到后端控制器
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                success: function (data) {
                    $('#summernote').summernote('insertImage', data.path, 'img');//这里是将返回的url地址重新添加到编辑器内
                },
                error : function() {
                    alert("上传图片出错，请稍后再试或联系管理员！");
                }
            });
        }

        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.introduction.index')}}";
        });


        function save()
        {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{route('merchant.introduction.update',$introduction->id)}}",
                data: $('#formData').serialize(),
                success: function (result) {
                    if (result.error == 0) {
                        alert("修改成功");
                    }else{
                        alert(result.message);
                    }
                },
                error : function() {
                    alert("异常！");
                }
            });
        }
    </script>
@endsection