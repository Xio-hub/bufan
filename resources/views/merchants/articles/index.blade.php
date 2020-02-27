@extends('merchants.layouts.app')

@section('title','文章列表')

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
                        <span class='col-md-1'><h5>文章列表</h5></span>
                        <a class='btn btn-w-m btn-success' href="{{route('articles.create')}}">添加文章</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>no</th>
                                <th>title</th>
                                <th>created_at</th>
                                <th>options</th>
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
                url: "{{route('articles.list')}}",
                dataFilter: function(data){
                    var json = jQuery.parseJSON( data );
                    return JSON.stringify( json ); // return JSON string
                }
            },
            columns: [
                {
                    "data": "no",
                    "orderable" : false,
                    "className" : "text-center", //居中显示
                    "title" : "序号", //表头
                    "render" : function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart; //切换分页序号 也自动叠加
                    }
                },
                {
                    "data": "title" ,
                    "title" : "文章标题",
                },
                { 
                    "data": "created_at",
                    "title": "创建时间"
                },
                { 
                    "data": "options",
                    "title": "操作",
                    "searchable": "false"
                }
            ],
            pageLength: 25,
            columnDefs : [ {
                // 定义操作列,######以下是重点########
                "targets" : -1,//操作按钮目标列
                "searchable": false,
                "render" : function(data, type,row) {
                    var id = row.id;
                    var html = "<a href='articles/"+ id +"/edit'  class='delete btn btn-default btn-xs'>修改文章</a>";
                    html += "<button onclick='deleteItem("+ id +")' class='down btn btn-default btn-xs btn-delete'>删除</button>";
                    return html;
                }
            } ],
            responsive: true
        });
    });

    function deleteItem(id){
        if(confirm('该操作不可回撤，确认删除文章吗？')){
            $.ajax({
                type : 'delete',
                url : "{{env('APP_URL')}}/merchant/management/articles/"+id,
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