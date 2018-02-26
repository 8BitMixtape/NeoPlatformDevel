<?php namespace Mixtapes\Mixtapes\Classes;

use RainLab\Translate\Classes\Translator;
use Closure;
use Session;

class LocaleMiddleWareLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])){
            $country_code = $_SERVER["HTTP_CF_IPCOUNTRY"];
        }else{
            return $next($request);
        }

        if(!Session::has('first_time_locale'))
        {
            if($country_code == 'ID'){
                $locale_lang = 'id';
            }else{
                $locale_lang = 'en';
            }

            $translator = Translator::instance();
            $translator->isConfigured();
            $translator->setLocale($locale_lang);

            Session::put('first_time_locale', 'true');
            return $next($request);
        }else{
            return $next($request);
        }

    }
}
