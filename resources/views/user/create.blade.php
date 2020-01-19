@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content">
                    <form method="get">
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">用户名</label>
                            <div class="col-sm-5"><input type="text" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">电子邮箱</label>
                            <div class="col-sm-5"><input type="email" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">管理角色</label>
                            <div class="col-sm-5">
                                <div class="i-checks"><label> <input type="radio" value="option1" name="a"> <i></i> 管理员 </label></div>
                                <div class="i-checks"><label> <input type="radio" checked="" value="option2" name="a"> <i></i> 商家 </label></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">密码</label>
                            <div class="col-sm-5"><input type="password" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">确认密码</label>
                            <div class="col-sm-5"><input type="password" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <button type="submit" class="btn btn-w-m btn-success">确认</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection