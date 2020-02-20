@extends('merchants.layouts.app')

@section('title','空间列表')

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
                        <span class='col-md-1'><h5>空间列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('merchant.space.create')}}">添加空间</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id='dataTables-products' >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>ID</th>
                                <th>空间名称</th>
                                <th>所属分类</th>
                                <th>封面</th>
                                <th>展示优先级</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($spaces as $i => $space)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$space->id}}</td>
                                    <td>{{$space->name}}</td>
                                    <td>{{$space->category_name}}</td>
                                    <td><a href="{{$space->cover}}" target="blank">{{$space->cover}}</a></td>
                                    <td>{{$space->priority}}</td>
                                    <td>{{$space->created_at}}</td>
                                    <td>
                                        <a href="{{route('merchant.space.edit',$space->id)}}" class='down btn btn-default btn-xs btn-delete'>修改</a>
                                        <button onclick='deleteItem("{{$space->id}}")' class='down btn btn-default btn-xs btn-delete'>删除</button>
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
        });

        function deleteItem(id){
            if(confirm('该操作不可回撤，确认删除该数据吗？')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/merchant/management/spaces/"+id,
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