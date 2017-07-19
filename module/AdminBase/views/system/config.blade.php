@extends('layout.layout')
@section('title', '编辑系统基本参数')

@section('content')
<form class="layui-form">
    <table class="layui-table">
        <colgroup>
            <col width="20%">
            <col width="50%">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>参数说明</th>
            <th>参数值</th>
            <th>变量名</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>网站名称</td>
            <td><input type="text" name="webname" class="layui-input cmsName" value="{{system_config('webname')}}" placeholder="请输入网站名称"></td>
            <td>webname</td>
        </tr>

        <tr>
            <td>网站Logo</td>
            <td style="text-align: left">
                <img src="{{asset(system_config('weblogo'))}}" style="max-height: 120px" class="layui-circle" id="webLogoImg">
                <br/>
                <input type="file" name="webLogoFile" class="layui-upload-file" lay-title="更换Logo">
                <input type="hidden" name="weblogo" class="layui-input cmsName" value="{{system_config('weblogo')}}" >
            </td>
            <td>weblogo</td>
        </tr>
        <tr>
            <td>默认关键字</td>
            <td><input type="text" name="keywords" class="layui-input keywords" value="{{system_config('keywords')}}" placeholder="请输入默认关键字"></td>
            <td>keywords</td>
        </tr>
        <tr>
            <td>网站描述</td>
            <td><textarea name="description" placeholder="请输入网站描述" class="layui-textarea description">{{system_config('description')}}</textarea></td>
            <td>description</td>
        </tr>

        <tr>
            <td>版权信息</td>
            <td><input type="text" name="powerby" class="layui-input powerby" value="{{system_config('powerby')}}" placeholder="请输入网站版权信息"></td>
            <td>powerby</td>
        </tr>

        <tr>
            <td>网站备案号</td>
            <td><input name="record" type="text" class="layui-input record" value="{{system_config('record')}}" placeholder="请输入网站备案号"></td>
            <td>record</td>
        </tr>
        </tbody>
    </table>
    <div class="layui-form-item" style="text-align: right;">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="systemParameter">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection

@section('jsImport')
@jsimport(systemParameter)
@endsection