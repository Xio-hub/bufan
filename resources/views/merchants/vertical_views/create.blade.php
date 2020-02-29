@extends('merchants.layouts.app')

@section('title','添加俯视图')

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
                            <label class="col-sm-2 col-form-label">材质</label>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="material">
                                    @foreach($materials as $material)
                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">风格分类</label>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="category" id='category_selector'>
                                    <option value="">请选择分类</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">风格</label>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="style" id='style_selector'>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">展示类型</label>
                            <div class="col-sm-5">
                                <div class="i-checks"><label> <input type="radio" id="image_type" value="image" name="source_type" checked> <i></i>鸟瞰图</label></div>
                                <div class="i-checks"><label> <input type="radio" id="link_type" value="link" name="source_type"> <i></i>鸟瞰连接</label></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">鸟瞰图</label>
                            <div class='col-sm-5'>
                                <div class="dropzone" id="image_box">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </div>

                                <div id="link_box" style="display: none">
                                    <div class="col-sm-12"><input type="text" class="form-control" name='link'></div>
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
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#image_type').on('ifChecked', function(event){ //ifCreated 事件应该在插件初始化之前绑定 
                $('#link_box').css('display','none');
                $('#image_box').css('display','block'); 
            }); 

            $('#link_type').on('ifChecked', function(event){ //ifCreated 事件应该在插件初始化之前绑定 
                $('#image_box').css('display','none'); 
                $('#link_box').css('display','block'); 
            }); 
        });


        $("#image_box").dropzone({
            acceptedFiles: 'image/*,application/pdf',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('vertical_view.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择文件进行上传</strong>",
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

        $("#category_selector").change(function(){
            var category_id =  $("#category_selector").val();
            $("#style_selector").empty();

            $.ajax({
                type : 'get',
                url : "{{env('APP_URL')}}/merchant/management/getCategoryStyles/"+category_id,
                dataType : 'json',
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        var styles = data.data;
                        $.each(styles,function(i,val){
                            var option = $("<option>").val(val.id).text(val.name);
                            $("#style_selector").append(option);
                        });
                    }else{
                        alert('获取失败，请刷新重试');
                    }
                }
            });
        });
    </script>
@endsection