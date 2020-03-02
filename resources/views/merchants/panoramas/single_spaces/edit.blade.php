@extends('merchants.layouts.app')

@section('title','修改单个空间')

@section('styles')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">
<link href="{{asset('vendor/webuploader/webuploader.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">基本信息</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">详细(图片)</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">详细(视频)</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-4">详细(PDF)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <fieldset>
                                    <form id='dataForm'>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">材质</label>
                                            <div class="col-sm-5">
                                                <select class="form-control m-b" name="material">
                                                    @foreach($materials as $material)
                                                    @if($material->id == $single_space->material_id)
                                                    <option value="{{$material->id}}" selected>{{$material->name}}</option>
                                                    @else
                                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                                    @endif
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
                                                    @if($category->id == $single_space_style_category->id)
                                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                    @else
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                
                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">风格</label>
                                            <div class="col-sm-5">
                                                <select class="form-control m-b" name="style" id='style_selector'>
                                                    @foreach($styles as $style)
                                                    @if($style->id == $single_space->style_id)
                                                    <option value="{{$style->id}}" selected>{{$style->name}}</option>
                                                    @else
                                                    <option value="{{$style->id}}">{{$style->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">产品展示类型</label>
                                            <div class="col-sm-5">
                                                <div class="i-checks"><label> <input type="radio" id="image_type" value="image" name="detail_type" @if($single_space->type == 'image') checked @endif> <i></i>图片</label></div>
                                                <div class="i-checks"><label> <input type="radio" id="video_type" value="video" name="detail_type" @if($single_space->type == 'video') checked @endif> <i></i>视频</label></div>
                                                <div class="i-checks"><label> <input type="radio" id="video_type" value="pdf" name="detail_type" @if($single_space->type == 'pdf') checked @endif> <i></i>pdf</label></div>
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
                                </fieldset>

                            </div>
                        </div>
                        
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-stripped" id='image_panel'>
                                        <thead>
                                        <tr>
                                            <th>图片预览</th>
                                            <th>热点连接</th>
                                            <th>展示优先级</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($image_resources as $i => $item)

                                        <tr id='resource_{{$item->id}}'>
                                            <td>
                                                <img src="{{Storage::url($item->source_url)}}" width='{{config('constant.IMAGE_RESOURCE_WIDTH')}}' height='{{config('constant.IMAGE_RESOURCE_HEIGHT')}}'>
                                            </td>

                                            <td>
                                                <div class="col-sm-7">
                                                    <select class="form-control m-b" name="hotspot">
                                                        <option value="0">无</option>
                                                        @foreach($articles as $article)
                                                            @if($article->id == $item->hotspot)
                                                            <option value="{{$article->id}}" selected>{{$article->title}}</option>
                                                            @else
                                                            <option value="{{$article->id}}">{{$article->title}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td> 

                                            <td>
                                                <input type='text' value="{{$item->priority}}"  maxlength="4" class="ipt_priority">
                                            </td>
                                            <td>
                                                <button data-id='{{$item->id}}' class='btn btn-white btn-priority'>更新</button>
                                                <button class="btn btn-white" onclick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i> </button>
                                            </td>
                                        </tr>
                                            
                                        @endforeach
                                        
                                        </tbody>
                                    </table>
                                    <div id='image_upload_progress_box' class="progress" style='display:none'>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div style='margin-top:2rem'>
                                    <div id='btn-add-image'>添加图片</div>
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
                                            @foreach ($video_resources as $i => $item)

                                            <tr id='resource_{{$item->id}}'>
                                                <td>
                                                    <div class="form-control">{{Storage::url($item->source_url)}}</div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white" onclick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                        
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

                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-stripped" id='pdf_panel'>
                                        <thead>
                                        <tr>
                                            <th>pdf链接地址</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pdf_resources as $i => $item)

                                            <tr id='resource_{{$item->id}}'>
                                                <td>
                                                   <div class="form-control">{{Storage::url($item->source_url)}}</div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white" onclick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                        
                                        </tbody>
                                    </table>

                                    <div id='pdf_upload_progress_box' class="progress" style='display:none'>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>

                                </div>
                                <div style='margin-top:2rem'>
                                    <div id='btn-add-pdf'>添加PDF</div>
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
        $(document).ready(function () {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            

            $('a[data-toggle="tab"]').on('shown.bs.tab',function(e){
                var target = e.target.toString();
                if(target.indexOf('tab-2')>0){
                    image_uploader.refresh();
                }else if(target.indexOf('tab-3')>0){
                    video_uploader.refresh();
                }else if(target.indexOf('tab-4')>0){
                    pdf_uploader.refresh();
                }
            });

            bindImageItemEvent();



            var image_uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,
                swf: "{{asset('vendor/webuploader/Uploader.swf')}}",
                server: "{{route('merchant.single_spaces.resource.store')}}",
                pick: '#btn-add-image',
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                formData:{
                    _token:'{{csrf_token()}}',
                    single_space_id: '{{$single_space->id}}',
                    resource_type: 'image'
                }
            });

            image_uploader.on( 'uploadProgress', function( file, percentage ) {
                $('#image_upload_progress_box').show();
                $percent = $('#image_upload_progress_box').find('.progress-bar');
                $percent.css( 'width', percentage * 100 + '%' );
            });

            image_uploader.on( 'uploadSuccess', function(file, response) {
                if(response.error == 0){
                    data = response.data;
                    id = data.id;
                    source_url = data.source_url
                    priority = data.priority;
                    list = $('#image_panel tbody');
                    list.append( 
                        "<tr id='resource_"+ id +"'>" +
                            "<td><img src='"+ source_url +"' width='{{config('constant.IMAGE_RESOURCE_WIDTH')}}' height='{{config('constant.IMAGE_RESOURCE_HEIGHT')}}'></td>" +
                            "<td><div class='col-sm-7'>" + 
                                    "<select class='form-control m-b' name='hotspot'>" +
                                        "<option value='0'>无</option>" +
                                        @foreach($articles as $article)
                                            @if($article->id == $item->hotspot)
                                            "<option value'{{$article->id}}' selected>{{$article->title}}</option>" +
                                            @else
                                            "<option value='{{$article->id}}'>{{$article->title}}</option>" +
                                            @endif
                                        @endforeach
                                    "</select>" +
                                "</div>" +
                            "</td>" +
                            "<td><input type='text' value='"+ priority +"'  maxlength='4' class='ipt_priority'></td>" +
                            "<td><button data-id='"+id+"' class='btn btn-white btn-priority'>更新</button> " +
                            "<button class='btn btn-white' onclick='deleteItem(" + id + ")'><i class='fa fa-trash'></i> </button></td>"+
                        "</tr>"
                    );
                    bindImageItemEvent();
                    alert('添加成功');
                }else{
                    $('#image_upload_progress_box').hide();
                    alert(response.message);
                }
            });

            image_uploader.on( 'uploadError', function( file ) {
                $('#image_upload_progress_box').hide();
                alert('上传出错');
            });

            image_uploader.on( 'uploadComplete', function( file ) {
                $('#image_upload_progress_box').fadeOut();
                $percent = $('#image_upload_progress_box').find('.progress-bar');
                $percent.css( 'width', '0%' );
            });


            var video_uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,
                swf: "{{asset('vendor/webuploader/Uploader.swf')}}",
                server: "{{route('merchant.single_spaces.resource.store')}}",
                pick: '#btn-add-video',
                accept: {
                    title: 'Video',
                    mimeTypes: 'video/*'
                },
                formData:{
                    _token:'{{csrf_token()}}',
                    single_space_id: '{{$single_space->id}}',
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
                            "<td><div class='form-control'>" + source_url + "</div></td>" +    
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


            var pdf_uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,
                swf: "{{asset('vendor/webuploader/Uploader.swf')}}",
                server: "{{route('merchant.single_spaces.resource.store')}}",
                pick: '#btn-add-pdf',
                accept: {
                    title: 'Pdf',
                    mimeTypes: 'application/pdf'
                },
                formData:{
                    _token:'{{csrf_token()}}',
                    single_space_id: '{{$single_space->id}}',
                    resource_type: 'pdf'
                }
            });

            pdf_uploader.on( 'uploadProgress', function( file, percentage ) {
                $('#pdf_upload_progress_box').show();
                $percent = $('#pdf_upload_progress_box').find('.progress-bar');
                $percent.css( 'width', percentage * 100 + '%' );
            });

            pdf_uploader.on( 'uploadSuccess', function(file, response) {
                if(response.error == 0){
                    data = response.data;
                    id = data.id;
                    source_url = data.source_url
                    priority = data.priority;
                    list = $('#pdf_panel tbody');
                    list.append( 
                        "<tr id='resource_"+ id +"'>" +
                            "<td><div class='form-control'>" + source_url + "</div></td>" +    
                            "<td><button class='btn btn-white' onclick='deleteItem(" + id + ")'><i class='fa fa-trash'></i> </button></td>"+
                        "</tr>"
                    );
                        alert('添加成功');
                }else{
                    $('#pdf_upload_progress_box').hide();
                    alert(response.message);
                }
            });

            pdf_uploader.on( 'uploadError', function( file ) {
                $('#pdf_upload_progress_box').hide();
                alert('上传出错');
            });

            pdf_uploader.on( 'uploadComplete', function( file ) {
                $('#pdf_upload_progress_box').fadeOut();
                $percent = $('#pdf_upload_progress_box').find('.progress-bar');
                $percent.css( 'width', '0%' );
            });

        });

        $('#btn-commit').click(function(){
            var formData = new FormData($('#dataForm')[0]);
            $.ajax({
                type : 'post',
                url : "{{route('merchant.panorama.single_space.update',$single_space->id)}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                processData: false,
               	contentType: false, 
                data: formData,
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('修改成功');
                        window.location.href = "{{route('merchant.panorama.single_space.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.panorama.single_space.index')}}";
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

        function deleteItem(id)
        {
            if(confirm('确认删除?')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/merchant/management/panoramas/single_spaces/resources/"+id,
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

        function bindImageItemEvent(){
            //控制输入框的输入==只能输入四位，且必须是数字
            $(".ipt_priority").attr("onkeyup", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");
            $(".ipt_priority").attr("onpaste", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");
            $(".ipt_priority").attr("oncontextmenu", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");

            $('.btn-priority').on('click', function () {
                var id = $(this).attr('data-id');
                var hotspot = $("#resource_"+id).find("select[name=hotspot]").val();
                var priority =  $("#resource_"+id).find(".ipt_priority").val();
                $.ajax({
                    type : 'patch',
                    url : "{{env('APP_URL')}}/merchant/management/panoramas/single_spaces/resources/"+id,
                    contentType : 'application/x-www-form-urlencoded;charset=UTF-8',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType : 'json',
                    data: {"priority":priority,"hotspot":hotspot},
                    success : function(data,textStatus,jqXHR){
                        if(data.error == 0){
                            alert('修改成功');
                        }else{
                            alert(data.message);
                        }
                    }
                });
            });
        }
    </script>
@endsection