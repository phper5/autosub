@extends('layouts.app')
@section('content')
    <script src="/ali-oss/dist/aliyun-oss-sdk.min.js"  defer="true" ></script>
    <div class="container">
        <div class="layui-tab category-menu">
            <ul class="layui-tab-title">
                <?php
                foreach (config('image.tools') as $tool) {
                    ?>
                    <li class="<?php if ($__env->yieldContent('current_image_tools') == $tool['name']) {
                        echo "layui-this";
                    } ?>"><a href="<?php echo $tool['url'];?>" alt="<?php echo $tool['desc']; ?>"><?php echo $tool['title']; ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>

        @yield('image-tools-content')
    </div>
@endsection
