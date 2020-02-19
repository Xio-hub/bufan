@extends('layouts.app')

@section('title','修改商家配置')

@section('styles')
{{-- <link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet"> --}}
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
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
                    <form id="dataForm">
                        
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">商家名</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name='merchant_name' value='{{$merchant_base->name}}'></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">顶部logo</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="top_logo"/></span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div> 
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">侧边logo</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="sitebar_logo"/></span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div> 
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">广告语</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='slogan' value='{{$merchant_base->slogan}}'></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">栏目显示</label>
                            <div class="col-sm-5">
                                @foreach($categories as $category)
                                    <div class="i-checks"><label> <input type="checkbox" name='categories[]' value="{{$category->id}}" checked> <i></i>{{$category->name}}</label></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">商家权限</label>
                            <div class="col-sm-5">
                                @foreach($permissions as $permission)
                                    <div class="i-checks"><label> <input type="checkbox" name='permissions[]' value="{{$permission->id}}" checked> <i></i>{{$permission->name}}</label></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-lg" id='btn-cancel'>取消</a>
                                <a class="btn btn-primary btn-lg" id='btn-commit'>确认</a>
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

    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });


        $('#btn-commit').click(function(){
            var formData = new FormData($('#dataForm')[0]);
            $.ajax({
                type : 'post',
                url : "{{route('merchants.update',$merchant->id)}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                processData: false,		//用于对data参数进行序列化处理 这里必须false
               	contentType: false, 
                data: formData,
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('修改成功');
                        window.location.href = "{{route('merchants.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchants.index')}}";
        });
    </script>
@endsection