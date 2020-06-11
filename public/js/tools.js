var task_queue=new Array();
function getServ() {
     return "http://a.com";
    xy = document.location.protocol;
    if (!xy) {
        xy='http:';
    }
    if (document.location.hostname.indexOf('mypic') !=-1)
    {
        return "https://www.mypic.life";
    }
    else if (document.location.hostname.indexOf('d.com') !=-1)
    {
        return "https://www.mypic.life";
    }
    return "https://real.diandi.org";

}
function generateUUID() {
    var d = new Date().getTime();
    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now(); //use high-precision timer if available
    }
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
    return uuid;
}
function closeDownload() {
    $(".download-modal").hide();
    stopCheckPayment();
}
var checkPaymentHandle = null;

function getResource($resource_id,callback) {

    let _token = getToken();
    $data = {"api_token": _token,'preview_width':getMaxCanvasWidth()};
    apiRequest('/api/resources/'+$resource_id,'get',$data,{
        'success':function ($data) {
            if (callback.success) {
                callback.success($data);
            }
        },
        'error':function ($data) {
            if (callback.error) {
                callback.error($data);
            }
        }
    });
}

function downloadFile($dom) {
    $box = $($dom).parents(".img-wrapper")
    let _token = getToken();
    $data = {"api_token": _token,'preview_width':400};
    $resource_id = $("._resource_file",$box).attr('data_id')
    apiRequest('/api/resources/'+$resource_id,'get',$data,{
        'success':function (result) {
            console.log(result)
            $url = result.image_preview_url;
            if (result.is_payed){
                $("#_download_id").attr('href',$url);
                $("#_download_id_box").show();
                $("#_pay_box").hide();
            }else{
                $("#_download_id_box").hide();
                $("#_pay_box").show();
                console.log(document.location.origin+"/api/payment/resource/"+$resource_id)
                $("#_pay_qrcode").html("");
                new QRCode(document.getElementById("_pay_qrcode"), document.location.origin+"/api/payment/resource/"+$resource_id);
                //$("#_pay_box").html(' <a href="/t2/'+result.resource_id+'" target="_blank">请点击支付</a>');
                checkPaymentHandle =  setInterval( function () {
                    getResource(result.resource_id,{
                        'success':function (result) {
                            if (result.is_payed){
                                $url = result.image_original_url;
                                $("#_download_id").attr('href',$url);
                                $("#_download_id_box").show();
                                $("#_pay_box").hide();
                                if (checkPaymentHandle)
                                {
                                    clearInterval(checkPaymentHandle);
                                }
                            }
                        }
                    })
                },2000);
            }
            $("#_download_preview").attr('src',$url);
            $("#_download_image_info").html(result.image_width+'x'+result.image_height);

            $(".download-modal").show();
        }
    });
}
function stopCheckPayment() {
    if (typeof (task_queue)!='checkPaymentHandle' && checkPaymentHandle)
    {
        clearInterval(checkPaymentHandle );
    }
}

/**
 * 上传一个文件
 * 通过回调进行响应。
 * upload_before
 * upload_after
 * upload_process
 * upload_error
 *
 * @param e
 * @param callback
 */
var upload = function (file,callback={},append_params={}) {

    let filename = file.name;
    let ext = filename.substring(filename.indexOf(".")+1)
    let dst_filename = generateUUID()+'.'+ext;
    let type = file.type.substring(0,file.type.indexOf("/"));
    if (type !=file_type) {
        console.log('file type wrong ' + file.type);
        alert("您选择的不是图片文件");
        return ;
    }
    params = {
        upload_before:callback.upload_before?callback.upload_before:null,
        upload_process:callback.upload_process?callback.upload_process:null,
        upload_after:callback.upload_after?callback.upload_after:null,
        upload_error:callback.upload_error?callback.upload_error:null,
    }
    var doupload = function(token)
    {
        if (params.upload_before) {
            params.upload_before(this,file);
        }
        $data = {"api_token":token,"params":append_params};
        apiRequest('/api/resource/auth','get',$data,{
            'success':function (result) {
                if (result) {
                    let client = new OSS({
                        accessKeyId: result.AccessKeyId,
                        accessKeySecret: result.AccessKeySecret,
                        stsToken: result.SecurityToken,
                        endpoint: result.endpoint,
                        bucket: result.bucket
                    });
                    // if (typeof (task_queue)!='undefined' && task_queue)
                    // {
                    //     clearInterval(task_queue );
                    // }
                    //storeAs表示上传的object name , file表示上传的文件
                    client.multipartUpload(result['path']+dst_filename, file,{
                        callback: {
                            url: result.callback.callbackUrl,
                            /**host: result.callback.callbackBody,**/
                            /* eslint no-template-curly-in-string: [0] */
                            body: result.callback.callbackBody+"&x_filename="+file.name+'&x_screen_width='+window.screen.width+'&x_preview_width='+getMaxCanvasWidth(),
                            contentType: result.callback.callbackBodyType,
                            customValue: {
                                x_filename: file.name
                            },
                        },
                        progress: function (p, checkpoint) {
                            // 断点记录点。浏览器重启后无法直接继续上传，您需要手动触发继续上传。
                            tempCheckpoint = checkpoint;
                            console.log(p);
                            if (params.upload_process) {
                                params.upload_process(this,file,p);
                            }
                        }
                    }).then(function (result) {
                        console.log(result);
                        if (params.upload_after) {
                            params.upload_after(this,file,result);
                        }
                    }).catch(function (err) {
                        console.log(err);
                        if (params.upload_error) {
                            params.upload_error(this,file,err);
                        }
                    });
                }
            }
        });

    }
    getToken(doupload);
};

function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}

/**
 * 读取token，以回调方式处理同步请求。
 * @param callback
 * @returns {string}
 */
function getToken(callback=null) {
    token = localStorage.getItem('token');
    id = localStorage.getItem('id');
    if (token && id && token !="undefined" && id!="undefined") {
        if (callback)
        {
            callback(token);
        }
        return token;
    }
    success = function ($data) {
        $token = $data.token;
        $id = $data.id;
        $username = $data.name;
        localStorage.setItem('token',$token);
        localStorage.setItem('username',$username);
        localStorage.setItem('id',$id);
        if (callback)
        {
            callback($token);
        }

    };
    apiRequest('/api/token','get',{},{
        'success':success
    });
}

/**
 * 发送api请求，同步以回调方式处理
 * @param $api
 * @param $method
 * @param $data
 * @param $callback
 */
function apiRequest ($api,$method,$data={},$callback=null)
{
    $server= getServ();
    $.ajax({
        url: $server+$api,
        method: $method,
        data: $data,
        dataType: "json",
        success: function (data) {
            if (typeof  $callback.success !="undefined")
            {
                $callback.success(data.data)
            }
        },
        error : function(e){
            console.log(e.status);
            console.log(e.responseText);
            if (typeof  $callback.error !="undefined")
            {
                $callback.error(e)
            }else{
                if (e.responseJSON.code==102) {
                    localStorage.removeItem('token');
                    alert("用户信息失效，请重试");
                }
                if (e.responseJSON.code=='error') {
                    alert("用户信息失效，请重试");
                }
                if (e.responseJSON.code==103) {
                    alert(e.responseJSON.message);
                }
            }
        }
    });
}

function _show_qrcode() {
    $("._qrcode-login").show();
    $(".login-switch").removeClass('pwd');
    $("._password-login").hide();
    $("._register-login").hide();
    $(".modal-header h2").html('登录');
    $('#myModal').modal()
}
function _show_register() {
    $("._qrcode-login").hide();
    $("._password-login").hide();
    $("._register-login").show();
    $(".modal-header h2").html('注册');
    $('#myModal').modal()
}
function _show_pwd() {
    $(".login-switch").addClass('pwd');
    $("._qrcode-login").hide();
    $("._password-login").show();
    $("._register-login").hide();
    $(".modal-header h2").html('登录');
    $('#myModal').modal()
}
function showLogin() {
    // _show_qrcode();
    _show_pwd();
}
function showRegister() {
    _show_register();
}
function taskQueue($task_id,callback=null) {
    console.log($task_id);
    let _token = getToken();
    $data = {"api_token": _token,'task_id':$task_id,'preview_width':getMaxCanvasWidth()};
    apiRequest('/api/tasks/'+$task_id,'get',$data,{
        'success':function ($data) {
            if ($data.status < 0 || $data.status >20) {
                if (task_queue[$task_id])
                {
                    clearInterval(task_queue[$task_id] );
                }
            }
            if ($data.status <0) {
                alert("处理失败");
            }
            if ($data.status == 30) {
                if (callback.success) {
                    callback.success($data);
                }
            }
        }
    });

}
function getUserId() {
    id =  localStorage.getItem('id');
    return id;
}
function isGuest() {
    id =  localStorage.getItem('id');
    if (id && id!="undefined" && id.substring(0,1) !='-')
    {
        return false;
    }
    return true;
}
function getUsername() {
    username =  localStorage.getItem('username');
    if (!username){
        username='用户'
    }
    return username;
}
function initUserInfo() {

    getToken(function ($token) {
        if (isGuest()){
            $("#_user_menu li").hide();
            $("#_user_menu li:not(#_loged)").show();
        }else{
            $("#_user_menu li").hide();
            $("#_username").html(getUsername());
            $("#_user_menu #_loged").show();
        }
    });
}
function logout() {
    localStorage.removeItem('username');
    localStorage.removeItem('token');
    localStorage.removeItem('id');
    localStorage.clear()
    initUserInfo();
}
function logSuccess(){
    $('#myModal').modal("hide");
    initUserInfo();
}
$(document).ready(function(){
    initUserInfo();
    $("#_login_form").submit(function (event) {
        event.preventDefault();  //prevent the actual form post
        $form = $(this);
        $mothed = $form.attr('method');
        $url = '/api/token';
        apiRequest($url,$mothed,$form.serialize(),{
            'success':function ($data) {
                $token = $data.token;
                $('#myModal').modal("hide");
                $id = $data.id;
                $username = $data.name;
                localStorage.setItem('token',$token);
                localStorage.setItem('username',$username);
                localStorage.setItem('id',$id);
                logSuccess();
                console.log($data)

            },
            'error':function (e) {
                if (e.responseJSON.code==104) {
                    $(".text-red",$form).html(e.responseJSON.message);
                    // alert(e.responseJSON.message);
                }
            }
        })
    });
    $("#_register_form").submit(function (event) {
        event.preventDefault();  //prevent the actual form post
        $form = $(this);
        $mothed = $form.attr('method');
        $url = '/api/users';
        apiRequest($url,$mothed,$form.serialize(),{
            'success':function ($data) {
                $token = $data.token;
                $id = $data.id;
                $username = $data.name;
                localStorage.setItem('token',$token);
                localStorage.setItem('username',$username);
                localStorage.setItem('id',$id);
                console.log($data)
                logSuccess();
            },
            'error':function (e) {
                if (e.responseJSON.code==103) {
                    $(".text-red",$form).html(e.responseJSON.message);
                    // alert(e.responseJSON.message);
                }
            }
        })

    });


    $(".login-switch").on('click',function (e) {
        return ;// 取消二维码登录
        if ($(this).hasClass('pwd')) {
            _show_qrcode();
        }
        else{
            _show_pwd();
        }
    });
    $("#_login_register").on('click',function (e) {
        _show_register();
    });
    $("#_login_login").on('click',function (e) {
           _show_pwd();
        })

});
