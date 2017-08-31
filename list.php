<?php
/**
 * User: fu
 * Date: 2016/1/11
 * Time: 23:15
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <title>f</title>
    <style type="text/css">
        body{margin:0;padding:0;font-family:"微软雅黑",Arial,"宋体";font-size:12px;color:#333;}
        html,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,p{margin:0;padding:0;}
        input,select,textarea{vertical-align:middle;font-family:"微软雅黑",Arial,"宋体";font-size:12px;}img{border:0;}ul,li{list-style-type:none;}
        a{color:#333;text-decoration:none;}a:hover{text-decoration:underline;color:#333;}a:focus{outline:none;}
        a{transition-duration:300ms;}
        .parent{ float: left;width: 100px;background: #d8dbde;position: fixed;bottom:0;top:0;}
        .parent .p_li{ height: 30px; line-height: 30px; padding-left: 10px;    border-bottom: 1px solid #ccc;}
        .child{display: none; margin-left: 100px;   min-height: 600px;}
        .child li{border-bottom: 1px solid #ccc; padding: 10px ; overflow: hidden;position: relative;}
        .child li:hover{background: #f6f6db;}
        .child li .edit{display: none;position: absolute; right: 10px;bottom: 10px;}
        .child li:hover .edit{display: block;}
        .parent .p_hover,.parent .p_li:hover{background: #fff;}
    </style>
    <script type="text/javascript" src="jquery.min.js"></script>
</head>
<body>

<ul class="parent">
    <?php foreach($type_arr as $type):?>
        <li class="p_li">
            <?php echo $type?>
        </li>
    <?php endforeach?>
    <li class="p_li">
        <a href="?a=add">添加</a>
    </li>
</ul>
<?php foreach($type_arr as $i => $type):?>
<ul class="child">
    <?php foreach ($data as $j => $val): ?>
        <?php if ($type == $val['type']): ?>
            <li class="c_li">

                <?php $str_arr = explode("\n",(trim($val['val']))); ?>
                <?php foreach($str_arr as $k => $str):?>
                    <?php
                        if($k == 0){
                            echo '<h3>'.$str.'</h3>';
                        }else{
                            echo trim($str).'<br>';
                        }
                    ?>
                <?php endforeach?>
                <a class="edit"   href="?a=add&j=<?php echo $j ?>">编辑</a>
            </li>
        <?php endif; ?>
    <?php endforeach ?>
</ul>
<?php endforeach?>

<script type="text/javascript">
    $('.parent li').hover(function(){
        $('.parent li').removeClass('p_hover');
        var $this = $(this);
        $this.addClass('p_hover');
        var i = $('.parent li').index(($(this)));
        $('.child').hide();
        $('.child').eq(i).show();
    });
</script>
</body>
</html>
