@extends('merchants.layouts.app')

@section('title','添加新品')

@section('styles')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
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
                            <label class="col-sm-2 col-form-label">新品名称</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='name'></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        {{-- <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">热点连接</label>
                            <div class="col-sm-5"><input type="url" class="form-control" name='hotspot'></div>
                        </div>
                        <div class="hr-line-dashed"></div> --}}

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">产品展示类型</label>
                            <div class="col-sm-5">
                                <div class="i-checks"><label> <input type="radio" id="image_type" value="image" name="detail_type" checked> <i></i>图片</label></div>
                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="detail_type"> <i></i>视频</label></div>
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">产品详细</label>
                            <div class='col-sm-5'>
                                <div id="image_fileinput_box">

                                    <div class="dropzone" id="image_detail_box">
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>
                                    </div>

                                </div>

                                <div id="video_fileinput_box" style="display: none">

                                    <div class="dropzone" id="video_detail_box">
                                        <div class="fallback">
                                            <input name="file" type="file"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">封面设置</label>
                            <div class='col-sm-5'>
                                <div class="dropzone" id="cover_box">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        {{-- <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">背景音乐</label>

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class='col-sm-5'>
                                    <div class="dropzone" id="music_upload_box">
                                        <div class="fallback">
                                            <input name="file"  accept="audio/*" />
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="hr-line-dashed"></div> --}}

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

    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script>

        $("#image_detail_box").dropzone({
            acceptedFiles: 'image/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.image.upload')}}",
            addRemoveLinks: true,
            maxFiles: 9,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择图片文件进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='image_detail[]' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });


        $("#video_detail_box").dropzone({
            acceptedFiles: 'video/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.video.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 20, // MB
            dictDefaultMessage: "<strong>请选择视频文件进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='video_detail[]' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });


        $("#cover_box").dropzone({
            acceptedFiles: 'image/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.cover.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择封面图片进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='cover' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });

        $("#music_upload_box").dropzone({
            acceptedFiles: 'audio/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.audio.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择封面图片进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='music' value='"+ responseText +"' />");
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
                url : "{{route('merchant.product.store')}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                data: $('#dataForm').serialize(),
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('添加成功');
                        window.location.href = "{{route('merchant.product.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.product.index')}}";
        });


        $(document).ready(function () {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }); 

            $('#image_type').on('ifChecked', function(event){ //ifCreated 事件应该在插件初始化之前绑定 
                $('#video_fileinput_box').css('display','none');
                $('#image_fileinput_box').css('display','block'); 
            }); 

            $('#video_type').on('ifChecked', function(event){ //ifCreated 事件应该在插件初始化之前绑定 
                $('#image_fileinput_box').css('display','none'); 
                $('#video_fileinput_box').css('display','block'); 
            }); 
        });
    </script>
@endsection