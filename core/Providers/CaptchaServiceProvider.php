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

class CaptchaServiceProvider extends ServiceProvider
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
    }

    public function map()
    {
        Route::group(['middleware' => 'web'],function (){
            Route::get('/captcha',function (Request $request){
                //生成验证码图片的Builder对象，配置相应属性
                $builder = new CaptchaBuilder((new PhraseBuilder())->build(5, 'ABDEFHJKMPT123456789'));
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


    }
}