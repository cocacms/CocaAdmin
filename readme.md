# CocaAdmin

Coca-Admin is a general modular web system developed based on  [Laravel 5.4](http://laravel.com/) and [LayuiCMS](https://github.com/BrotherMa/layuiCMS).
> 声明：本系统采用 [Laravel 5.4](http://laravel.com/) 框架 与  [LayuiCMS前端模板](https://github.com/BrotherMa/layuiCMS) 开发
本系统目前开发中，存在未知BUG，仅供学习使用请勿用于商业用途，谢谢！

### 系统特性
1.  ...(待完善)

### 其他开源模块
1.  [内容管理模块](https://github.com/rojer95/Content).
2.  开发中...

### 模块命令行说明

##### 创建模块
```
php artisan module:create Content
```

> 这里Content是模块名,下文出现也是模块名,执行时换成自己的

##### 创建控制器
```
php artisan module:make:controller ControllerName --module=Content
```

> 更多参数参考laravel文档 此处增加了module参数作为模块名称 下同 不做多解释


##### 创建中间件
```
php artisan module:make:middleware MiddlewareName --module=Content
```

##### 创建模型
```
php artisan module:make:model ModelName --module=Content
```

##### 创建数据迁移
```
php artisan module:make:migration migration_name --module=Content
```

##### 数据迁移
```
php artisan module:migrate Content
```

##### 数据回滚
```
php artisan module:migrate:rollback Content
```