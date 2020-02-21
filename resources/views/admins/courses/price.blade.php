@extends('layouts.app')

@section('title','课程价格')

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
                    <form id='formData'>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group  row">     
                            <label class="col-sm-2 col-form-label">价格</label>
                            <div class="col-sm-5"><input type="text" class="form-control" min='0' name='price' value="{{$course->price}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-primary btn-lg" id="btn-save" onclick="save()">确认</a>
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
        function save()
        {
            $.ajax({
                type: "Patch",
                dataType: "json",
                url: "{{route('courses.update')}}",
                data: $('#formData').serialize(),
                success: function (result) {
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