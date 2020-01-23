@extends('layouts.app')

@section('title','角色列表')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>角色列表</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>角色</th>
                            <th>拥有权限</th>
                            <th>操作</th>
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