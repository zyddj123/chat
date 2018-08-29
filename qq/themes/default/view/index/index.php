<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>chat</title>
    <link rel="shortcut icon" href="<?php echo HTTP_ROOT_PATH;?>/favicon.ico" />
    <link rel="stylesheet" href="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/amazeui/amazeui.min.css" />
    <link rel="stylesheet" href="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/main.css" />
    <script>
    var _REQUEST_HOST = '<?php echo APP_URL_ROOT;?>';
    var _THEMES_HOST = '<?php echo APP_HTTP_ROOT.$this->GetThemes();?>';
    </script>
</head>

<body>
    <div class="box">
        <div class="wechat">
            <div class="middle on">
                <div class="wx_search">
                    <img class="own_img" style="width: 25px;height: 25px; float: left;">
                    <input id="search" type="text" placeholder="搜索" />
                    <button id="logout_btn">-</button>
                </div>
                <div class="office_text">
                    <ul class="friends_list" id="mim_user_firends_list">
                    </ul>
                </div>
            </div>
            <div class="talk_window" id="mim_chat_dialog">
            </div>
        </div>
    </div>
    <script src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/amazeui/amazeui.min.js"></script>
    <script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/zUI.js"></script>
    <script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/wechat.js"></script>
    <script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/js/mim/mim.core.js"></script>
    <script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/js/mim/mim.chat.js"></script>
    <script type="text/javascript">
    if (typeof MIM != 'undefined') {
        MIM.OnOpen = function() {
            MIM.TokenLogin("<?php echo $_SESSION['mim'];?>");
        }
        MIM.Run('192.168.1.111', '2347');
        $("#logout_btn").click(function() {
            $.post(_REQUEST_HOST+"/Login/logout");
            MIM.Logout();
        });
    }
    </script>
</body>

</html>