@extends('merchants.layouts.app')

@section('title','添加新品')

@section('styles')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/bootstrap-fileinput/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css" />

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
                    <form method="POST" action="{{route('merchants.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">新品名称</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='merchant_name'></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">产品展示类型</label>
                            <div class="col-sm-5">
                                <div class="i-checks"><label> <input type="radio" id="image_type" value="image" name="detail_type" checked> <i></i>图片</label></div>
                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="detail_type"> <i></i>视频</label></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">产品详细</label>
                            <div class='col-sm-5'>
                                <div id="image_fileinput_box">
                                    <input id="product_detail_image" name="product_detail" type="file" class="file" data-preview-file-type="text"  multiple >
                                </div>
                                <div id="video_fileinput_box" style="display: none">
                                    <input id="product_detail_video" name="product_detail" type="file" class="file" data-preview-file-type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">封面设置</label>
                            <div class='col-sm-5'>
                                <div class="custom-file">
                                    <input id="product_cover" type="file" class="file" data-preview-file-type="text" >
                                </div> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-lg" type="submit">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">确认</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
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

    <script src="{{asset('js/plugins/bootstrap-fileinput/plugins/piexif.min.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap-fileinput/plugins/sortable.min.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap-fileinput/plugins/purify.min.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap-fileinput/fileinput.min.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap-fileinput/themes/fa/theme.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap-fileinput/locales/zh.js')}}"></script>

    <script>
    // with plugin options
    $("#product_detail_image").fileinput(
        {
            'dropZoneEnabled':false,
            'allowedFileTypes':['image'],'maxFileCount':9
        }
    );

    $("#product_detail_video").fileinput(
        {
            'dropZoneEnabled':false,
            'allowedFileTypes':['image'],
            'maxFileCount':1
        }
    );

    $("#product_cover").fileinput(
        {
            'dropZoneEnabled':false,
            'allowedFileTypes':['image'],
            'maxFileCount':1,
            'autoReplace':true,
            'uploadUrl': "{{route('image.upload')}}",
            'uploadExtraData': {'filepath':'product_cover','_token':$('meta[name="csrf-token"]').attr('content')},
        }
    );
    </script>
@endsection