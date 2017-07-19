<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/7
 * Time: 14:41
 */

namespace App\Providers;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class DefinedServiceProvider extends ServiceProvider
{

    public function boot()
    {
        parent::boot();
        Blade::directive('captcha', function ($expression) {
            $expression = explode(',',$expression);
            $w = $expression[0];
            $h = $expression[1];
            return "<?php echo route('captcha',['w'=>$w,'h'=>$h,'t'=>time()]); ?>";
        });


        Blade::directive('canshow', function ($expression) {
            return "<?php if(hasRoutePermission('$expression')){ ?>";
        });

        Blade::directive('endcanshow', function () {
            return "<?php } ?>";
        });
    }

    public function map()
    {
        Route::group(['middleware' => 'web'],function (){
            //验证码模块
            Route::get('/captcha',function (Request $request){
                //生成验证码图片的Builder对象，配置相应属性
                $builder = new CaptchaBuilder((new PhraseBuilder())->build(4, 'ABDEFHJKMPT123456789'));
                //可以设置图片宽高及字体
                $builder->build($request->input('w',100), $request->input('h',40));
                //获取验证码的内容
                $phrase = $builder->getPhrase();
                //把内容存入session
                session()->flash('_captcha',$phrase);
                //生成图片
                return (new Response($builder->output(), 200))
                    ->header('Content-Type', 'image/jpeg')
                    ->header('Cache-Control', 'no-cache, must-revalidate');
            })->name('captcha');
        });

        //上传模块
        Route::post('/upload',function(Request $request){
            $name = $request->input('name');
            $path = $request->file($name)->store('uploads','public');
            return response()->json(success_json('storage/'.$path));
        });

        Route::get('/notFound',function (){
            return view('notFound');
        })->name('notFound');

        Route::get('/notPermission',function (){
            return view('notPermission');
        })->name('notPermission');

    }
}