@extends('merchants.layouts.app')

@section('title','首页设置')

@section('styles')
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
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
                    <form id='index_data' method='POST' action="{{route('merchant.index.update')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    
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

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">封面文字</label></div>
                        <div class="ibox-content no-padding">            
                            <textarea id="summernote" name="editordata">{{$data->content}}</textarea>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-lg" type="button">Cancel</button>
                                <button class="btn btn-primary btn-lg" id="btn-save" type="button" onclick="saveData()">确认</button>
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

    <!-- SUMMERNOTE -->
    <script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('#summernote').summernote(
                {
                    height: 500,
                    tabsize: 2,
                    lang: 'zh-CN',
                    toolbar: [
				              [ 'style', [ 'style' ] ],
				              [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				              [ 'fontname', [ 'fontname' ] ],
				              [ 'fontsize', [ 'fontsize' ] ],
				              [ 'color', [ 'color' ] ],
				              [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				              [ 'table', [ 'table' ] ],
				              [ 'insert', [ 'link'] ],
				              [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
				          ]
                }
            );
        });

        function saveData()
        {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{route('merchant.index.update')}}",
                data: $('#index_data').serialize(),
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