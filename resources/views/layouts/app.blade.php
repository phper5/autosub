<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?c4e50da99341ceb5669be8c7977bb021";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <title>@hasSection('app_title') @yield('app_title') @else {{ config('app.name', 'autosub-在线自动字幕生成-图片去水印') }} @endif</title>
    <meta name="Keywords" content="autosub-在线自动字幕生成,图片去水印,图像修复"/>
    <meta name="description" content="@hasSection('app_description') @yield('app_description')  @else  {{config('app.desc')}} @endif"/>
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <meta property="og:locale" content="zh_CN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="diandi.org - @hasSection('app_title')
@yield('app_title')
    @else
    {{ config('app.name', 'Laravel') }} @endif" />
    <meta property="og:description" content="@hasSection('app_description')   @yield('app_description')@else {{config('app.desc')}} @endif" />
    <meta property="og:url" content="https://www.diandi.org/" />
    <meta property="og:site_name" content="@hasSection('app_title') @yield('app_title') @else {{ config('app.name', 'autosub-在线自动字幕生成-图片去水印') }} @endif" />
    <script src="/js/jq.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.1/js/bootstrap.bundle.js"></script>
    <script src="/js/tools.js"></script>
    <link   href="/css/font.css"rel="stylesheet">
    <!-- Styles -->
    <link href="/css/default-app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    auto<span class="domain">sub</span>
                    <!--<img src="/images/logo-b.png" alt="{{ config('app.name', 'autosub-在线自动字幕生成') }}"> -->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><a  class="nav-link"  href="/image-tools/inpainting-image">图像修复</a></li>
                        <li><a  class="nav-link"  href="/image-tools/watermark-removal-auto">自动水印清除</a></li>
                        <!--
                        <li><a  class="nav-link"  href="/image-tools/watermark-removal-long-text">长条水印清除</a></li>
                        <li><a  class="nav-link"  href="/image-tools/watermark-removal-repeat">平铺水印清除</a></li>
                        -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" id="_user_menu">
                        <!-- Authentication Links -->
{{--                        @guest--}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}" onclick="showLogin();return false;">登录</a>
                            </li>
{{--                            @if (Route::has('register'))--}}
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{ route('register') }}" onclick="showRegister();return false;">注册</a>
                                </li>
{{--                            @endif--}}
{{--                        @else--}}
                            <li class="nav-item dropdown" id="_loged" style="display: none">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     <span class="caret" id="_username">22</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
{{--                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"--}}
                                        onclick="logout();return false;"
                                    >
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
{{--                        @endguest--}}
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
        <footer class="d-none-mobile-app mt-8">
            <div class="upper pb-4 pt-2 py-md-5">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md">
                            <h2 class="pb-md-3 pt-4 pt-md-2">
                                产品
                            </h2>
                            <div class="upper-footer-line"><a class="upper-footer-link" href="/">autosub字幕生成</a></div>
                            <div class="upper-footer-line"><a class="upper-footer-link" href="https://www.diandi.org" target="_blank">图像修复/去水印</a></div>
                        </div>
                        <div class="col-md">
                            <h2 class="pb-md-3 pt-4 pt-md-2">
                                更多
                            </h2>
                            <div class="upper-footer-line"><a class="upper-footer-link" href="/pricing">定价</a></div>
                        </div>
                        <div class="col-md">
                            <h2 class="pb-md-3 pt-4 pt-md-2">
                                工具 &amp; API
                            </h2>
                            <div class="upper-footer-line"><a class="upper-footer-link" href="/api">API 文档</a></div>
                        </div>
                        <div class="col-md">
                            <h2 class="pb-md-3 pt-4 pt-md-2">
                                支持
                            </h2>
                            <div class="upper-footer-line"><a class="upper-footer-link" target="_blank" href="#">Help &amp; FAQs</a></div>
                            <div class="upper-footer-line"><a class="upper-footer-link" href="/support">联系我们</a></div>
                        </div>

                    </div>
                    <div class="row row-eq-height align-items-center mt-3 mt-md-5">
                        <div class="col-md-3 pt-2">
                            <a class="btn btn-outline-secondary" href="#/languages">
                                <i class="fal fa-globe fa-lg"></i>
                                <span class="ml-1 mr-2">
                中文
              </span>
                                <i class="fas fa-chevron-right"></i>
                            </a>          </div>
                        <div class="col-md-9 text-md-right pt-2">
                            <a class="upper-footer-link" href="#/privacy">隐私策略</a> |
                            <a class="upper-footer-link" href="#/tos">服务条款</a> |
                        </div>
                    </div>
                </div>
            </div>
            <div class="lower py-5 text-center">
                <div class="container" style="opacity: 0.5;">
                    <p class="mt-4 copyright-line">
                        Copyright 2020-2020 diandi.org - All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal fade login" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="login-switch-box is-qrcode-login"><p class="text">使用其他方式登录</p></div>

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="login-switch _display_none"><p class="text">使用其他方式登录</p></div>
                    <button type="button" title="关闭" data-dismiss="modal" aria-label="Close" class="mfp-close"><span aria-hidden="true">×</span></button>
                    <h2>登录</h2>

                </div>
                <div class="modal-body flex-center _qrcode-login">

                    <img  src="#">
                    <p>微信扫码，关注“点滴工具”登录</p>
                </div>
                <div class="modal-body flex-center _password-login"  style="display: none">


                        <form method="POST" id="_login_form" action="/login">
                            <input type="hidden" name="_token" value="bAVNkcUFIvbkMkGfj8o8XRY2Fds7BLoJm6ZFC2Cl">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">邮箱地址</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control " name="email" value="" required=""
                                           autocomplete="off" autofocus="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAUBJREFUOBGVVE2ORUAQLvIS4gwzEysHkHgnkMiEc4zEJXCMNwtWTmDh3UGcYoaFhZUFCzFVnu4wIaiE+vvq6+6qTgthGH6O4/jA7x1OiCAIPwj7CoLgSXDxSjEVzAt9k01CBKdWfsFf/2WNuEwc2YqigKZpK9glAlVVwTTNbQJZlnlCkiTAZnF/mePB2biRdhwHdF2HJEmgaRrwPA+qqoI4jle5/8XkXzrCFoHg+/5ICdpm13UTho7Q9/0WnsfwiL/ouHwHrJgQR8WEwVG+oXpMPaDAkdzvd7AsC8qyhCiKJjiRnCKwbRsMw9hcQ5zv9maSBeu6hjRNYRgGFuKaCNwjkjzPoSiK1d1gDDecQobOBwswzabD/D3Np7AHOIrvNpHmPI+Kc2RZBm3bcp8wuwSIot7QQ0PznoR6wYSK0Xb/AGVLcWwc7Ng3AAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control " name="password" required="" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAUBJREFUOBGVVE2ORUAQLvIS4gwzEysHkHgnkMiEc4zEJXCMNwtWTmDh3UGcYoaFhZUFCzFVnu4wIaiE+vvq6+6qTgthGH6O4/jA7x1OiCAIPwj7CoLgSXDxSjEVzAt9k01CBKdWfsFf/2WNuEwc2YqigKZpK9glAlVVwTTNbQJZlnlCkiTAZnF/mePB2biRdhwHdF2HJEmgaRrwPA+qqoI4jle5/8XkXzrCFoHg+/5ICdpm13UTho7Q9/0WnsfwiL/ouHwHrJgQR8WEwVG+oXpMPaDAkdzvd7AsC8qyhCiKJjiRnCKwbRsMw9hcQ5zv9maSBeu6hjRNYRgGFuKaCNwjkjzPoSiK1d1gDDecQobOBwswzabD/D3Np7AHOIrvNpHmPI+Kc2RZBm3bcp8wuwSIot7QQ0PznoR6wYSK0Xb/AGVLcWwc7Ng3AAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                                </div>
                            </div>
                            <div class="col-md-12 text-red"></div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        登录
                                    </button>
                                    <a class="btn btn-link" href="/password/reset" target="_blank">
                                        忘记密码?
                                    </a>
                                </div>
                                <div class="col-md-8 offset-md-4">
                                    <a class="btn btn-link" href="#" id="_login_register">
                                        注册帐号
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <a href="#" class="weixin"></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="#" class="qq"></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="#" class="weibo"></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="#" class="dingtalk"></a>
                                </div>
                            </div>
                        </form>

                </div>
                <div class="modal-body flex-center _register-login" style="display: none">
                    <form method="POST" id="_register_form" action="/register" _lpchecked="1">
                        <input type="hidden" name="_token" value="bAVNkcUFIvbkMkGfj8o8XRY2Fds7BLoJm6ZFC2Cl">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">昵称</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control " name="name" autocomplete="name" autofocus="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">邮箱地址</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control " name="email" value="" required="" autocomplete="email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">密码(最低6位)</label>

                            <div class="col-md-8">
                                <input id="r-password" type="password" class="form-control " name="password" required="" autocomplete="new-password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">确认密码</label>

                            <div class="col-md-8">
                                <input id="r-password-confirm" type="password" class="form-control" name="password_confirmation" required="" autocomplete="new-password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                            </div>

                        </div>
                        <div class="col-md-12 text-red"></div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    注册
                                </button>
                            </div>
                            <div class="col-md-8 offset-md-4">
                                <a class="btn btn-link" href="#" id="_login_login">
                                    已有账户/登录
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
