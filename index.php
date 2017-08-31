<?php
/**
 * User: fu
 * Date: 2016/1/11
 * Time: 23:04
 */
function data_encrypt($string, $skey)
{
    $skey = sha1($skey);
    $skey = bin2hex($skey);
    $skey = str_split($skey);

    $string = bin2hex($string);
    $strCount = strlen($string);

    $encrypt_str = '';
    $pos_i = 0;
    while (true) {
        foreach ($skey as $i => $value) {
            $len = base_convert($value, 16, 10) % 3 + 1;
            $num = base_convert(mt_rand(18010, 1118010), 10, 16);
            if ($pos_i < $strCount) {
                $encrypt_str .= substr($string, $pos_i, 1) . substr($num, 0, $len);
                $pos_i++;
            }
        }
        if ($pos_i == $strCount) {
            break;
        }
    }
    $encrypt_str = base64_encode($encrypt_str);
    return $encrypt_str;
}

function data_decrypt($string, $skey)
{
    $skey = sha1($skey);
    $skey = bin2hex($skey);
    $skey = str_split($skey);

    $string = base64_decode($string);
    $strCount = strlen($string);
    $pos_i = 0;
    $decrypt_str = '';
    while (true) {
        foreach ($skey as $i => $value) {
            $len = base_convert($value, 20, 10) % 3 + 1 + 1;
            if ($pos_i < $strCount) {
                $decrypt_str .= substr($string, $pos_i, 1);
                $pos_i += $len;
            }
        }
        if ($pos_i == $strCount) {
            break;
        }
    }
    $decrypt_str = hex2bin($decrypt_str);
    return $decrypt_str;
}
session_start();
function isLogin()
{
    return isset($_SESSION['login_key']) && $_SESSION['login_key'];
}

$msg = '';
function login($login_key)
{
    if ($login_key) {
        list($list) = getList($login_key);
        if(!empty($list)){
            $_SESSION['login_key'] = $login_key;
            return true;
        }
    }
    else {
        return false;
    }
}

if (isset($_GET['login_key'])) {
    if (login($_GET['login_key'])) {
        header('Location: index.php');
    }
    exit;
}

if (!isLogin()) {
    exit;
}
function getList($login_key = null)
{
    if(empty($login_key)){
        $login_key = $_SESSION['login_key'];
    }
    $data = file_get_contents('data');
    $data = data_decrypt($data,$login_key);
    $data = json_decode($data, true);
    if(empty($data)){
        $data = array();
    }
    $type_arr = array();
        foreach ($data as $val) {
            if ($val['type'] && !in_array($val['type'], $type_arr)) {
                $type_arr[] = $val['type'];
            }
        }

//    }
    return array($data, $type_arr);
}

function getData()
{
    list($data_arr) = getList();
    $data = null;
    if (isset($_GET['j'])) {
        $data = $data_arr[$_GET['j']];
    }
    return $data;
}

function saveData()
{
    list($data_arr) = getList();
    if (isset($_GET['j'])) {
        $data_arr[$_GET['j']] = array(
            'type' => $_POST['type'],
            'val' => $_POST['val'],
        );
    }
    else {
        $data_arr[] = array(
            'type' => $_POST['type'],
            'val' => $_POST['val'],
        );
    }
    include 'mail/Mail.php';
    Mail::sendMsg('444212235@qq.com','fu','文件数据','查看附件',array('data','data') );
    copy('data', 'history/' . date('YmdHis'));
    $data = json_encode($data_arr);
    $data = data_encrypt($data,$_SESSION['login_key']);
    file_put_contents('data', $data);
    header('Location: index.php');

}

if (isset($_GET['a'])) {
    if ($_GET['a'] == 'add') {
        if (!empty($_POST)) {
            saveData();
        }
        $data = getData();
        ?>
        <form action="" method="post">
            <input type="text" name="type" value="<?php echo $data['type'] ?>"/>
            <br>
            <br>
            <textarea name="val" style="width: 500px;height: 120px;;"><?php echo $data['val'] ?></textarea>
            <br>
            <br>
            <input type="submit" />
        </form>
        <?php
    }
    exit;
}
else {
    list($data, $type_arr) = getList();
    include 'list.php';

}


