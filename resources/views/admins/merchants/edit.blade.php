@extends('layouts.app')

@section('title','修改商家配置')

@section('styles')
{{-- <link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet"> --}}
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
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
                            <div class="fileinput fileinput-new col-md-2" data-provides="fileinput">
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="top_logo"/></span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div>
                            @if($merchant_base->top_logo != '')
                                <div><img src="{{Storage::url($merchant_base->top_logo)}}" width='50' height='50'></div> 
                            @endif
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">侧边logo</label>
                            <div class="fileinput fileinput-new col-md-2" data-provides="fileinput">
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="sitebar_logo"/></span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div>
                            @if($merchant_base->sitebar_logo != '')
                            <div><img src="{{Storage::url($merchant_base->sitebar_logo)}}" width='50' height='50'></div> 
                            @endif
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

                        <div class="form-group  row" id='datepicker'>
                            <label class="col-sm-2 col-form-label">到期时间</label>
                            <div class="col-sm-5 input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name='expired_at' class="form-control" value="{{$expired_date}}">
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

    <script src="{{asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#datepicker .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
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