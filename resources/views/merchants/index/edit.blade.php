@extends('merchants.layouts.app')

@section('title','首页设置')

@section('styles')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/webuploader/webuploader.css')}}" rel="stylesheet">
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

                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">商品信息</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">展示内容(图文)</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">展示内容(视频)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">

                                <fieldset>
                                    <form id='dataForm'>
                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">封面设置</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span><input type="file" name="cover"/></span>
                                                <span class="fileinput-filename"></span>
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                            </div> 
                                        </div>
                                        <div class="hr-line-dashed"></div>
                
                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">类型</label>
                                            <div class="col-sm-5">
                                                <div class="i-checks"><label> <input type="radio" id="image_type" value="image" name="detail_type"> <i></i>图片</label></div>
                                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="detail_type"> <i></i>视频</label></div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                
                                        <div class="form-group row">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary btn-lg" id="btn-save" type="button" onclick="saveData()">确认</button>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>

                            </div>
                        </div>
                        
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content no-padding">            
                                    <textarea id="editor" type="text/plain" style="height:500px;" name='content'>{{$data->content}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-stripped" id='video_panel'>
                                        <thead>
                                        <tr>
                                            <th>视频地址</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($video_resources as $i => $item)

                                            <tr id='img_resource_{{$item->id}}'>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="{{Storage::url($item->source_url)}}">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white" onclick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                         --}}
                                        </tbody>
                                    </table>
                                    <div id='video_upload_progress_box' class="progress" style='display:none'>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div style='margin-top:2rem'>
                                    <div id='btn-add-video'>添加视频</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('vendor/webuploader/webuploader.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            
            var ue = UE.getEditor('editor');
        });

        function saveData()
        {
            var formData = new FormData($('#dataForm')[0]);
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{route('merchant.index.update')}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,		//用于对data参数进行序列化处理 这里必须false
                contentType: false,
                data: formData,
                success: function (result) {
                    console.log(result);//打印服务端返回的数据(调试用)
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