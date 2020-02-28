@extends('merchants.layouts.app')

@section('title','企业风采')

@section('styles')
<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>新品列表</h5>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id='dataTables-products' >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>栏目名称</th>
                                <th>展示优先级</th>
                                <th>展示状态</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($introductions as $i => $introduction)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$introduction->title}}</td>
                                    <td>
                                        <span style="display:none">{{$introduction->priority}}</span>
                                        <input type='text' value="{{$introduction->priority}}"  maxlength="4" class="ipt_priority">
                                        <button data-id='{{$introduction->id}}' class='down btn btn-default btn-xs btn-priority'>确认</button>
                                    </td>
                                    <td class='data_{{$introduction->id}}_status'>
                                        @if($introduction->status == 1)
                                        显示
                                        @else
                                        隐藏
                                        @endif
                                    </td>
                                    <td>{{$introduction->created_at}}</td>
                                    <td>
                                        <a href="{{route('merchant.introduction.edit',$introduction->id)}}" class='down btn btn-default btn-xs btn-edit'>修改</a>

                                        @if($introduction->status == 1)
                                        <button class='down btn btn-default btn-xs btn-status-toggle' data-value='0' data-id='{{$introduction->id}}'>隐藏</button>
                                        @else
                                        <button class='down btn btn-default btn-xs btn-status-toggle' data-value='1' data-id='{{$introduction->id}}'>显示</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    <table class="table" data-paging="true"></table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('#dataTables-products').DataTable(
                {
                    pageLength: 25,
                }
            );

            //控制输入框的输入==只能输入四位，且必须是数字
            $(".ipt_priority").attr("onkeyup", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");
            $(".ipt_priority").attr("onpaste", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");
            $(".ipt_priority").attr("oncontextmenu", "if(this.value.length>4){this.value=this.value.substr(0,4)};value=value.replace(/[^0-9]/g, '')");

            $('.btn-priority').on('click', function () {
                var priority = $(this).parent().find(".ipt_priority").val();
                var id = $(this).attr('data-id');
                $.ajax({
                    type : 'patch',
                    url : "{{env('APP_URL')}}/merchant/management/introductions/"+id,
                    contentType : 'application/x-www-form-urlencoded;charset=UTF-8',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType : 'json',
                    data: {"priority":priority},
                    success : function(data,textStatus,jqXHR){
                        if(data.error == 0){
                            alert('修改成功');
                            // window.location.reload();
                        }else{
                            alert(data.message);
                        }
                    }
                });
            });

            $('.btn-status-toggle').click(function(){
                var status = $(this).attr('data-value');
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "Patch",
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{env('APP_URL')}}/merchant/management/introductions/"+id,
                    data: {'status':status},
                    success: function (result) {
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
            });
        });


    


    </script>
@endsection