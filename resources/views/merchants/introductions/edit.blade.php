@extends('merchants.layouts.app')

@section('title','首页设置')

@section('styles')
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
                            <label class="col-sm-1 col-form-label">栏目名称</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='title' value="{{$introduction->title}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="ibox-content no-padding">            
                            <input id="editorValue" value="{{$introduction->content}}" type="hidden" />
                            <textarea id="editor" type="text/plain" style="height:500px;" name='content'></textarea>
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
    <script>
        $(document).ready(function(){
            var ue = UE.getEditor('editor');
            var htmlStr = $("#editorValue").val();
            ue.ready(function() {
                ue.setContent(htmlStr, false);
            });
        });

        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.introduction.index')}}";
        });


        function save()
        {
            $.ajax({
                type: "patch",
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