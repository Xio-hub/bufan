@extends('merchants.layouts.app')

@section('title', '单个空间列表')

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
                        <span class='col-md-1'><h5>单个空间列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('merchant.panorama.single_space.create')}}">添加单个空间</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id='dataTables-products' >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>材质</th>
                                <th>风格</th>
                                <th>空间</th>
                                <th>图片</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($single_spaces as $i => $single_space)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$single_space->material}}</td>
                                    <td>{{$single_space->style}}</td>
                                    <td>{{$single_space->space}}</td>
                                    <td><a href="{{$single_space->source_url}}" target="blank">{{$single_space->source_url}}</a></td>
                                    <td>{{$single_space->created_at}}</td>
                                    <td><button onclick='deleteItem("{{$single_space->id}}")' class='down btn btn-default btn-xs btn-delete'>删除</button></td>
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
                    url : "{{env('APP_URL')}}/merchant/management/panoramas/single_spaces/"+id,
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