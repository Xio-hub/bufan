@extends('layouts.app')

@section('title','角色列表')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content table-responsive-lg">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">角色</th>
                            <th scope="col" class="col-md-5">拥有权限</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td><span class="line">系统管理员</span></td>
                            <td>Samantha</td>
                            <td class="text-navy">
                                <button class="btn btn-w-m btn-primary">修改</button>
                                <button class="btn btn-w-m btn-danger">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">2</td>
                            <td><span class="line">商家</span></td>
                            <td>Samantha</td>
                            <td class="text-navy">
                                <button class="btn btn-w-m btn-primary">修改</button>
                                <button class="btn btn-w-m btn-danger">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">3</td>
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