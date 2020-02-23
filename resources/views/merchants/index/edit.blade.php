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
                                            @if($data->cover != '')
                                            <div><img src="{{Storage::url($data->cover)}}" width='120' height='90'></div> 
                                            @endif
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">背景音乐1</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span><input type="file" name="music1"  accept="audio/*"/></span>
                                                <span class="fileinput-filename"></span>
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                            </div> 
                                            @if($data->music1 != '')
                                            <div class='form-control col-md-8'>{{Storage::url($data->music1)}}</div> 
                                            @endif
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">背景音乐2</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span><input type="file" name="music2"  accept="audio/*"/></span>
                                                <span class="fileinput-filename"></span>
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                            </div> 
                                            @if($data->music2 != '')
                                            <div class='form-control col-md-8'>{{Storage::url($data->music2)}}</div> 
                                            @endif
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">背景音乐3</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span><input type="file" name="music3"  accept="audio/*"/></span>
                                                <span class="fileinput-filename"></span>
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                            </div> 
                                            @if($data->music3 != '')
                                            <div class='form-control col-md-8'>{{Storage::url($data->music3)}}</div> 
                                            @endif
                                        </div>
                                        <div class="hr-line-dashed"></div>


                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">菜单别名</label>
                                            <div class="col-sm-5">
                                                @foreach($categories as $i => $category)
                                                @if(!empty($category->alias))
                                                <div style="margin-top:10px"><input type='text' class="form-control" date-cat-id='{{$category['id']}}' name='alias[]' value='{{$category['alias']}}' placeholder="{{$category['name']}}"></div>
                                                @else
                                                <div style="margin-top:10px"><input type='text' class="form-control" date-cat-id='{{$category['id']}}' name='alias[]' value='{{$category['name']}}' placeholder="{{$category['name']}}"></div>
                                                @endif    
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                
                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">类型</label>
                                            <div class="col-sm-5">
                                                @if($data->content_type == 'text')
                                                <div class="i-checks"><label> <input type="radio" id="image_type" value="text" name="show_type" checked> <i></i>图文</label></div>
                                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="show_type"> <i></i>视频</label></div>
                                                @else
                                                <div class="i-checks"><label> <input type="radio" id="image_type" value="text" name="show_type"> <i></i>图片</label></div>
                                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="show_type" checked> <i></i>视频</label></div>
                                                @endif
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
                                <div class="ibox-content">
                                    <form id = 'textForm'> 
                                        <input type='hidden' name='resource_type' value='text'>
                                        <input type='hidden' name='index_id' value='{{$data->id}}'>
                                        <textarea id="editor" type="text/plain" style="height:500px;" name='text_content'>{{$text_resource->content}}</textarea>
                                    <div class="col-sm-4 col-sm-offset-2" style="margin-top:2rem">
                                        <button class="btn btn-primary btn-lg" id="btn-save" type="button" onclick="saveText()">保存</button>
                                    </div>
                                    </form>
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
                                            @if($video_resource)

                                            <tr id='resource_{{$item->id}}'>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="{{Storage::url($item->source_url)}}">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white" onclick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                                
                                            @endif
                                        
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

            
            $('a[data-toggle="tab"]').on('shown.bs.tab',function(e){
                var target = e.target.toString();
                if(target.indexOf('tab-3')>0){
                    video_uploader.refresh();
                }
            });
        });

        var video_uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,
            swf: "{{asset('vendor/webuploader/Uploader.swf')}}",
            server: "{{route('merchant.index.resource.store')}}",
            pick: '#btn-add-video',
            accept: {
                title: 'Video',
                mimeTypes: 'video/*'
            },
            formData:{
                _token:'{{csrf_token()}}',
                index_id: '{{$data->id}}',
                resource_type: 'video'
            }
        });

        video_uploader.on( 'uploadProgress', function( file, percentage ) {
            $('#video_upload_progress_box').show();
            $percent = $('#video_upload_progress_box').find('.progress-bar');
            $percent.css( 'width', percentage * 100 + '%' );
        });

        video_uploader.on( 'uploadSuccess', function(file, response) {
            if(response.error == 0){
                data = response.data;
                id = data.id;
                source_url = data.source_url
                priority = data.priority;
                list = $('#video_panel tbody');
                list.append( 
                    "<tr id='resource_"+ id +"'>" +
                        "<td><a>" + source_url + "</a></td>" +    
                        "<td><button class='btn btn-white' onclick='deleteItem(" + id + ")'><i class='fa fa-trash'></i> </button></td>"+
                    "</tr>"
                );
                alert('添加成功');
            }else{
                $('#video_upload_progress_box').hide();
                alert(response.message);
            }
        });

        video_uploader.on( 'uploadError', function( file ) {
            $('#video_upload_progress_box').hide();
            alert('上传出错');
        });

        video_uploader.on( 'uploadComplete', function( file ) {
            $('#video_upload_progress_box').fadeOut();
            $percent = $('#video_upload_progress_box').find('.progress-bar');
            $percent.css( 'width', '0%' );
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
                        window.location.reload();
                    }else{
                        alert(result.message);
                    }
                },
                error : function() {
                    alert("异常！");
                }
            });
        }

        function saveText()
        {
            var formData = new FormData($('#textForm')[0]);
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{route('merchant.index.resource.update',$text_resource->id)}}",
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

        function deleteItem(id)
        {
            if(confirm('确认删除?')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/merchant/management/index/resources/"+id,
                    contentType : 'application/json;charset=UTF-8',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType : 'json',
                    success : function(data,textStatus,jqXHR){
                        if(data.error == 0){
                            alert('删除成功');
                            $('#resource_'+id).remove();
                        }else{
                            alert(data.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection