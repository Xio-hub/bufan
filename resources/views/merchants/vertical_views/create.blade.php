@extends('merchants.layouts.app')

@section('title','添加俯视图')

@section('styles')
<link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">

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
                    <form id='dataForm' enctype="multipart/form-data">
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">风格</label>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="style">
                                    @foreach($styles as $style)
                                    <option value="{{$style->id}}">{{$style->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">俯视图</label>
                            <div class='col-sm-5'>
       
                                    <div class="dropzone" id="image_box">
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-lg" id='btn-cancel'>取消</a>
                                <a class="btn btn-primary btn-lg" id="btn-commit">确认</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $("#image_box").dropzone({
            acceptedFiles: 'image/*,application/pdf',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('vertical_view.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择封面图片进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='vertical_view'' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });

        $('#btn-commit').click(function(){
            $.ajax({
                type : 'post',
                url : "{{route('merchant.vertical_view.store')}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                data: $('#dataForm').serialize(),
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('添加成功');
                        window.location.href = "{{route('merchant.vertical_view.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.vertical_view.index')}}";
        });
    </script>
@endsection