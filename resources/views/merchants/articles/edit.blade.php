@extends('merchants.layouts.app')

@section('title','修改文章')

@section('styles')
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection

@include('vendor.ueditor.assets')

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

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">文章标题</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='title' value="{{$article->title}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">文章内容</label></div>
                        <div class="ibox-content no-padding">            
                            <input id="editorValue" value="{{$article->content}}" type="hidden" />
                            <textarea id="editor" type="text/plain" style="height:500px;" name='content'></textarea>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-lg" id='btn-cancel'>取消</a>
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

    <script>
        $(document).ready(function(){
            var ue = UE.getEditor('editor');
            var htmlStr = $("#editorValue").val();
            ue.ready(function() {
                ue.setContent(htmlStr, false);
            });
        });

        function save()
        {
            $.ajax({
                type: "put",
                dataType: "json",
                url: "{{route('articles.update',$article->id)}}",
                data: $('#formData').serialize(),
                success: function (result) {
                    if (result.error == 0) {
                        alert("修改成功");
                        window.location.href = "{{route('articles.index')}}";
                    }else{
                        alert(result.message);
                    }
                },
                error : function() {
                    alert("异常！");
                }
            });
        }

        $('#btn-cancel').click(function(){
            window.location.href = "{{route('articles.index')}}";
        });
    </script>
@endsection