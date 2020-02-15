@extends('merchants.layouts.app')

@section('title','添加新品')

@section('styles')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">

@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Product info</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2"> Data</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-3"> Discount</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4"> Images</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">

                                    <fieldset>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Name:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Product name"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Price:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="$160.00"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
                                            <div class="col-sm-10">
                                                <div class="summernote">
                                                    <h3>Lorem Ipsum is simply</h3>
                                                    dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                                                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                                    typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                                                    <br/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Title:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="..."></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Description:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Sheets containing Lorem"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Keywords:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Lorem, Ipsum, has, been"></div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">

                                    <fieldset>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">ID:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="543"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Model:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="..."></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Location:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="location"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Tax Class:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" >
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Quantity:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Quantity"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Minimum quantity:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="2"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Sort order:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="0"></div>
                                        </div>
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Status:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" >
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>


                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table class="table table-stripped table-bordered">

                                            <thead>
                                            <tr>
                                                <th>
                                                    Group
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>
                                                    Discount
                                                </th>
                                                <th style="width: 20%">
                                                    Date start
                                                </th>
                                                <th style="width: 20%">
                                                    Date end
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                        <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" >
                                                        <option selected>Group 1</option>
                                                        <option>Group 2</option>
                                                        <option>Group 3</option>
                                                        <option>Group 4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="10">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="$10.00">
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-stripped">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Image preview
                                                </th>
                                                <th>
                                                    Image url
                                                </th>
                                                <th>
                                                    Sort order
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/2s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image1.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="1">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/1s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image2.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="2">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/3s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image3.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="3">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/4s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image4.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="4">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/5s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image5.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="5">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/6s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image6.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="6">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="img/gallery/7s.jpg">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled value="http://mydomain.com/images/image7.png">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="7">
                                                </td>
                                                <td>
                                                    <button class="btn btn-white"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
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
    <script src="{{asset('js/plugins/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script>

        $("#image_detail_box").dropzone({
            acceptedFiles: 'image/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.image.upload')}}",
            addRemoveLinks: true,
            maxFiles: 9,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择图片文件进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='image_detail[]' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });


        $("#video_detail_box").dropzone({
            acceptedFiles: 'video/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.video.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 20, // MB
            dictDefaultMessage: "<strong>请选择视频文件进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='video_detail[]' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });


        $("#cover_box").dropzone({
            acceptedFiles: 'image/*',
            params:{'_token':$('meta[name="csrf-token"]').attr('content')},
            url: "{{route('product.cover.upload')}}",
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            dictDefaultMessage: "<strong>请选择封面图片进行上传</strong>",
            init: function() {
                this.on("success", function(file, responseText) {
                    var html = Dropzone.createElement("<input type='hidden' name='cover' value='"+ responseText +"' />");
                    file.previewElement.appendChild(html);
                });
                this.on("error", function (file, message) {
                    alert(message);
                    this.removeFile(file);
                });
            }
        });

        $('#btn-commit').click(function(){
            $.ajax({
                type : 'post',
                url : "{{route('merchant.product.store')}}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType : 'json',
                data: $('#dataForm').serialize(),
                success : function(data,textStatus,jqXHR){
                    if(data.error == 0){
                        alert('添加成功');
                        window.location.href = "{{route('merchant.product.index')}}";
                    }else{
                        alert(data.message);
                    }
                }
            });
        });
        
        $('#btn-cancel').click(function(){
            window.location.href = "{{route('merchant.product.index')}}";
        });


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
@endsection