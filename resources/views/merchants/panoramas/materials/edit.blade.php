@extends('merchants.layouts.app')

@section('title','修改材质')

@section('styles')
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
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
                            <label class="col-sm-2 col-form-label">名称</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name='name' value='{{$material->name}}'></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">封面设置</label>
                            <div class='col-sm-5'>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span><input type="file" name="cover" accept="image/*"/></span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                </div> 
                                @if($material->cover != '')
                                <div><img src="{{Storage::url($material->cover)}}" width='120' height='90'></div> 
                                @endif
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
    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <script>
        $('#btn-commit').click(function(){
            var formData = new FormData($('#dataForm')[0]);
            $.ajax({
                type : 'post',
                url : "{{route('merchant.material.update',$material->id)}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                processData: false,
               	contentType: false, 
                data: formData,
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('修改成功');
                        window.location.href = "{{route('merchant.material.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.material.index')}}";
        });
    </script>
@endsection