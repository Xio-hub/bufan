@extends('merchants.layouts.app')

@section('title','风格分类列表')

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
                        <span class='col-md-1'><h5>风格分类列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('merchant.style.category.create')}}">添加风格分类</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id='dataTables-products' >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>分类名称</th>
                                <th>封面</th>
                                <th>展示优先级</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $i => $category)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td><img src="{{$category->cover}}"  width='70' height='45'/></td>
                                    <td>
                                        <span id="priority_box_{{$category->id}}" style="display: none">{{$category->priority}}</span>
                                        <input type='text' value="{{$category->priority}}"  maxlength="4" class="ipt_priority">
                                        <button data-id='{{$category->id}}' class='down btn btn-default btn-xs btn-priority'>确认</button>    
                                    </td>
                                    <td>{{$category->created_at}}</td>
                                    <td>
                                        <a href="{{route('merchant.style.category.edit',$category->id)}}" class='down btn btn-default btn-xs btn-delete'>修改</a>
                                        <button onclick='deleteItem("{{$category->id}}")' class='down btn btn-default btn-xs btn-delete'>删除</button>
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
                    url : "{{env('APP_URL')}}/merchant/management/styles/categories/"+id,
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
            if(confirm('删除分类会删除分类下的所有数据，该操作不可回撤，确认删除该分类吗？')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/merchant/management/styles/categories/"+id,
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