<?php
return [
    'tools'=>[
        [
            'title'=>'图片格式转换工具',
            'desc'=>'支持.webp .heic  .jpg .jpeg .gif .png .bmp 等图片格式之间互相转换',
            'url'=>'/image-tools/convert-image',
            'name'=>'convert',
        ],
        [
            'title'=>'图片压缩工具',
            'desc'=>'jpg，png图片压缩。压缩成功后，图片尺寸不会变，视觉效果也不会有太大差异。',
            'url'=>'/image-tools/compress-image',
            'name'=>'compress',
        ],
        [
            'title'=>'图片智能修复',
            'desc'=>'点滴在线修复工具是一款在线去水印软件。无需安装，即可快速批量去除水印，文字，杂物，修复破损图片，并且保持原始文件的画质与格式。',
            'url'=>'/image-tools/inpainting-image',
            'name'=>'inpainting',
        ]        ,
        [
            'title'=>'在线图片转卡通',
            'desc'=>'autosub-在线自动字幕生成-线图片转卡通，可以帮助用户方便的将图片卡通化。',
            'url'=>'/image-tools/cartoonise-image',
            'name'=>'cartoonise',
        ]        ,
        [
            'title'=>'在线图片去噪处理',
            'desc'=>'autosub-在线自动字幕生成-在线图片去噪点，可以有效的去除图片的z噪声。对椒盐噪声，高斯噪声均有较好的处理结果',
            'url'=>'/image-tools/denoise-image',
            'name'=>'denoise',
        ]        ,
        [
            'title'=>'证件照换背景',
            'desc'=>'在线把证件照片背景色修改为白色、红色、蓝色、灰色或指定您指定您指定的颜色。',
            'url'=>'#',///image-tools/change-id-photo-background
            'name'=>'id-background',
        ],
//        [
//            'title'=>'图片信息读取',
//            'desc'=>'支持.webp .heic .ico .jpg .jpeg .gif .png .bmp 等图片格式之间互相转换',
//            'url'=>'#',
//            'name'=>'cot',
//        ],
//        [
//            'title'=>'图片在线编辑',
//            'desc'=>'支持.webp .heic .ico .jpg .jpeg .gif .png .bmp 等图片格式之间互相转换',
//            'url'=>'#',
//            'name'=>'cot',
//        ]
    ]
];
