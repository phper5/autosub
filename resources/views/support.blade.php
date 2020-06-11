@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref">
            <div class="overflow-hidden banner">
                <div class="banner-welcome">
                    <div class="title mb-4">欢迎使用autosub-在线自动字幕生成</div>
                    <div class="font-size1">在这里您可以借助人工智能更高效的完成您的工作</div>
                </div>
                <img src="/images/banner.jpg">
            </div>
            <div class="mt-5">
                <div class="mb-4">我们的完善离不开您的参与，欢迎留下宝贵意见</div>
                <form novalidate="novalidate" action="/support" accept-charset="UTF-8" method="post" _lpchecked="1">


                    <div class="form-group">
                        <label for="contact">联系方式</label>
                        <input type="text" name="contact" id="contact" autocomplete="contact" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="subject">主题</label>
                        <input type="text" name="subject" id="subject" class="form-control">
                        <input id="user_info" name="user_info" value="0" type="hidden">
                    </div>

                    <div class="form-group">
                        <label for="message">内容</label>
                        <textarea name="message" id="message" class="form-control" rows="15" cols="50" style=";"></textarea>
                    </div>

                    <script>
                        $id = getUserId();
                        $("#user_info").val($id);
                    </script>

                    <div class="text-center">
                        <button class="g-recaptcha btn btn-primary" type="submit">发送信息</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
