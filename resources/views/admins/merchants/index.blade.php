@extends('layouts.app')

@section('title','商家列表')

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
                        <span class='col-md-1'><h5>商家列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('merchants.create')}}">添加商家</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>optoions</th>
                            </tr>
                            </thead>

                            <tbody>

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

            $('.dataTables-example').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{url('api/v1/merchants')}}",
                    dataFilter: function(data){
                        var json = jQuery.parseJSON( data );
                        return JSON.stringify( json ); // return JSON string
                    }
                },
                columns: [
                    {
                        "data": "id",
                        "orderable" : false,
                        "className" : "text-center", //居中显示
                        "title" : "序号", //表头
                        "render" : function (data, type, row, meta) {
                            return meta.row + 1 + meta.settings._iDisplayStart; //切换分页序号 也自动叠加
                        }
                    },
                    {
                        "data": "name" ,
                        "title" : "商家名称",
                    },
                    { 
                        "data": "options",
                        "title": "操作"
                    }
                ],
                pageLength: 25,
                columnDefs : [ {
                    // 定义操作列,######以下是重点########
                    "targets" : -1,//操作按钮目标列
                    "searchable": false,
                    "render" : function(data, type,row) {
                        var id = row.merchant_id;
                        var html = "<a href='merchants/"+ id +"/edit'  class='delete btn btn-default btn-xs'>修改配置</a>";
                        html += "<a href='merchants/"+ id +"/password' class='down btn btn-default btn-xs'>修改密码</a>";
                        html += "<button onclick='deleteMerchant("+ id +")' class='down btn btn-default btn-xs btn-delete'>删除</button>";
                        return html;
                    }
                } ],
                responsive: true
            });
        });

        function deleteMerchant(id){
            if(confirm('该操作不可回撤，确认删除商家吗？')){
                $.ajax({
                    type : 'delete',
                    url : "{{env('APP_URL')}}/administer/management/merchants/"+id,
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