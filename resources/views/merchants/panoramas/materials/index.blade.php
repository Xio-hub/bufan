@extends('merchants.layouts.app')

@section('title','材质列表')

@section('styles')
    <link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class = 'row'>
                        <span class='col-md-1'><h5>材质列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('merchant.material.create')}}">添加材质</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id='dataTables-products' >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>材质名称</th>
                                <th>封面</th>
                                <th>展示优先级</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($materials as $i => $material)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$material->name}}</td>
                                    <td><img src="{{$material->cover}}"  width='70' height='45'/></td>
                                    <td>
                                        <span id="priority_box_{{$material->id}}" style="display: none">{{$material->priority}}</span>
                                        <input type='text' value="{{$material->priority}}"  maxlength="4" class="ipt_priority">
                                        <button data-id='{{$material->id}}' class='down btn btn-default btn-xs btn-priority'>确认</button>
                                    </td>
                                    <td>{{$material->created_at}}</td>
                                    <td>
                                        <a href="{{route('merchant.material.edit',$material->id)}}" class='down btn btn-default btn-xs btn-delete'>修改</a>
                                        <button onclick='deleteItem("{{$material->id}}")' class='down btn btn-default btn-xs btn-delete'>删除</button>
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
                    type : 'post',
                    url : "{{env('APP_URL')}}/merchant/management/materials/"+id,
                    contentType : 'application/x-www-form-urlencoded;charset=UTF-8',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType : 'json',
                    data: {"priority":priority},
                    success : function(data,textStatus,jqXHR){
                        if(data.error == 0){
                            $('#priority_box_'+id).text(priority);
                            alert('修改成功');
                            // window.location.reload();
                        }else{
                            alert(data.message);
                        }
                    }
                });
            });
        });

        function deleteItem(id){
            if(confirm('删除操作会删除该材质下的所有数据，该操作不可回撤，确认删除该材质吗？')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/merchant/management/materials/"+id,
                    contentType : 'application/json;charset=UTF-8',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType : 'json',
                    success : function(data,textStatus,jqXHR){
                        if(data.error == 0){
                            alert('删除成功');
                            window.location.reload();
                        }else{
                            alert(data.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection