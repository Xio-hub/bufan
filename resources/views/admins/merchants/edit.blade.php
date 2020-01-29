@extends('layouts.app')

@section('title','修改商家配置')

@section('styles')
<link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
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
                    <form method="POST" action="{{route('merchants.update',$merchant->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
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

    <!-- Jasny -->
    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <!-- DROPZONE -->
    <script src="{{asset('js/plugins/dropzone/dropzone.js')}}"></script>

    <!-- CodeMirror -->
    <script src="{{asset('js/plugins/codemirror/codemirror.js')}}"></script>
    <script src="{{asset('js/plugins/codemirror/mode/xml/xml.js')}}"></script>
@endsection