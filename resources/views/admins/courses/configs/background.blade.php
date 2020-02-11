@extends('layouts.app')

@section('title','课程背景')

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
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">原有背景</label>
                            <div class='col-sm-5'>
                                @if($background != '')
                                <img src='{{$background}}' width="300" height="300" οnlοad='javascript:drawImage(this,"300","300");'/>
                                @endif    
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">上传背景</label>
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
    <script>
        $("#image_box").dropzone({
            acceptedFiles: 'image/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('courses.background.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择背景图片图片进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='background' value='"+ responseText +"' />");
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
                type : 'patch',
                url : "{{route('courses.config.background.update')}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                data: $('#dataForm').serialize(),
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('添加成功');
                        window.location.reload();
                    }else{
                        alert(data.message);
                    }
                }
            });
        });

        function drawImage(ImgD,FitWidth,FitHeight){
            var image=new Image();
            image.src=ImgD.src;
            if(image.width>0 && image.height>0){
                if(image.width/image.height>= FitWidth/FitHeight){
                    if(image.width>FitWidth){
                        ImgD.width=FitWidth;
                        ImgD.height=(image.height*FitWidth)/image.width;
                    }else{
                        ImgD.width=image.width; 
                        ImgD.height=image.height;
                    }
                } else{
                    if(image.height>FitHeight){
                        ImgD.height=FitHeight;
                        ImgD.width=(image.width*FitHeight)/image.height;
                    }else{
                        ImgD.width=image.width; 
                        ImgD.height=image.height;
                    } 
                }
            }
        }

    </script>
@endsection