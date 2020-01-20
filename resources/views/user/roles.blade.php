@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content table-responsive-lg">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="col-lg-1">#</th>
                            <th class="col-lg-2">角色</th>
                            <th class="col-lg-6">拥有权限</th>
                            <th class="col-lg-3">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="line">系统管理员</span></td>
                            <td>Samantha</td>
                            <td class="text-navy">
                                <button class="btn btn-w-m btn-primary">修改</button>
                                <button class="btn btn-w-m btn-danger">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="line">商家</span></td>
                            <td>Samantha</td>
                            <td class="text-navy">
                                <button class="btn btn-w-m btn-primary">修改</button>
                                <button class="btn btn-w-m btn-danger">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="line">系统管理员</span></td>
                            <td>Samantha</td>
                            <td class="text-navy">
                                <button class="btn btn-w-m btn-primary">修改</button>
                                <button class="btn btn-w-m btn-danger">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection