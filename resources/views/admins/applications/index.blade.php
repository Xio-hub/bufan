@extends('layouts.app')

@section('title','申请列表')

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
                        <span class='col-md-1'><h5>申请列表</h5></span>
                    </div>
                </div>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>no</th>
                                <th>company_name</th>
                                <th>mobile</th>
                                <th>address</th>
                                <th>introduction</th>
                                <th>created_at</th>
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
                    url: "{{route('merchants.applications.list')}}",
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
                        "data": "company_name" ,
                        "title" : "企业名称",
                    },
                    { 
                        "data": "mobile",
                        "title": "手机号码",
                    },
                    { 
                        "data": "address",
                        "title": "公司地址"
                    },
                    { 
                        "data": "introduction",
                        "title": "企业介绍"
                    },
                    { 
                        "data": "created_at",
                        "title": "申请时间",
                        "searchable": false
                    },

                ],
                pageLength: 25,
                responsive: true
            });
        });
    </script>
@endsection