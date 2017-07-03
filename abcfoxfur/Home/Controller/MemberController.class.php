<?php
/**
 *
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/20/2017
 * Time: 8:28 AM
 */

namespace Home\Controller;

use Think\Controller;

header('cache_control', 'no-cache');

class MemberController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->member = D('Member');
    }

    public function login()
    {
        if (IS_POST) {
//            p($_SESSION);
            $member_name = I('username');
            $password = I('password');
            //search for matching member name
            $info = $this->member->where('member_name="' . $member_name . '"')->find();
            if (!$info) {
                $this->error('username or password doesnt exist');
            }
            //set salt as the value retrived from db
            $this->member->salt = $info['member_salt'];
            //use model function password for encryption
            $password = $this->member->password($password);
            if ($password == $info['member_pwd']) {
                //store username and login status if password matches
                session('Home_member_name', $info['member_name']);
//               store member id for obtaining in order list
                session('Home_member_id', $info['member_id']);
                session('Home_is_login', 1);
                //last login time
                session('Home_login_time', $info['login_time']);
                $data = array(
                    'Home_login_time' => time(),
                    'Home_member_id' => $info['member_id']
                );
                //update login time data
                $this->member->save($data);
                //jump to the redirect location if
                if($url = I('get.redire')){
                    $this->success('login successfully',U($url));die;
                }

                if (! $this->member->save($data)) {
                    $this->success('welcome back!', U('index/index'), 2);
                    die;
                } else {
                    $this->error($this->member->getError());
                    die;
                }
            }
        }
        $this->display();
    }


    public function register()
    {
        if (IS_POST) {
            if (!$info = $this->member->create()) {
                $this->error($this->member->getError());
                die;
            }
            $res = $this->member->add();
            if ($res) {
                //store user login status in session
                session('Home_member_name', $info['member_name']);
                session('Home_is_login', 1);
                session('Home_member_id', $info['member_id']);
                session('Home_login_time', $info['login_time']);
                $this->success('sign up successfully!', U('index/index'), 3);
                die;
            } else {
                $this->error('sign up failed');
                die;
            }
        }
        $this->display();
    }

    public function logout()
    {
        session('Home_member_name', null);
        session('Home_is_login', null);
        session('Home_login_time', null);
        setcookie('PHPSESSID', null);
        $this->success('logout successfully!', U('member/login'), 1);
    }

    // processing data from front end ajax and relay to service provider, returning result to front end after getting confirmation from provider
    public function sms_verify()
    {
        //die if it isnt from ajax
        if (!IS_AJAX) {
            die;
        }
        //if the frquency of click is more then once and clicking is under 60s, its invalid
        if (session('sms_time') > 1 && time() - session('sms_time') < 5) {
            //reuturn a json array
            $result = array(
                'code' => 1,
                'msg' => 'click too frequently'
            );
            echo json_encode($result);
        }
        //caution!!!cannot change mobile number to integer as it will exceeds max integer digit and will result in incorrect number!!!
        $mobile = I('get.mobile');
        $user = 'newuser';
        //use sendSMS API function, return obj result
        $res = sendSMS($user, $mobile);
        //convert obj into an array
        $res = (array)$res->result;
        $result = array(
            'code' => $res['err_code'],
            'msg' => $res['success'],
        );
        echo json_encode($result);
    }

//find password
    public function find()
    {
        if (IS_POST) {
            //retrieve member info from form
            $username = I('post.username');
            $email = I('post.email');
            //find member information
            $info = D('Member')->where("member_name='$username' AND member_email='$email'")->find();
            //error if cant find userinfo
            if (!$info) {
                $this->error('error in user information!Please try again');
                die;
            }
            //url in email to redirect to reset(), as it is an external link we hav eto use http and $server to make up the url
            $url = 'http://' . $_SERVER['HTTP_HOST'] . U('Member/reset', array('member_id' => $info['member_id']));
            //content in email
            $content = <<<ABC
            <h3>京西商城</h3>
<p>Dear {$username}, <br>To reset your password, click the following link:<br><a href="$url">click to retrieve password</a></p>'
ABC;
            $res = sendMail($info['member_email'], $info['member_name'], 'reset password', $content);
            if ($res) {
                $this->success('email sent successfully!please reset your password through email');
                die;
            } else {
                $this->error('email sent failed, please contact administrator', '', 20);
                die;
            }
        }
        $this->display();
    }

    public function reset()
    {
        $member_id = $_GET['member_id'];
        //make a different variable name so that it wont inherit anything from above!
        $mem = D('Member');
        if (IS_POST) {
            // get post and validate data by create
            if (!$mem->create()) {
                $this->error($mem->getError());
                die;
            }
            //save new pw according to member id
            $res = $mem->where("member_id=$member_id")->save();
            if ($res) {
                $this->success('reset password successfully', U('Member/login'));
                die;
            } else {
                $this->error('reset failed');
                die;
            }
        }
        $this->display();
    }

//    qq login, from oath/index
    public function qq()
    {
        require_once("./Tools/qq/API/qqConnectAPI.php");
        //need \as qc is from the outer source php file
        $qc = new \QC();
//need appid, appkey to generate in install.php page in order for it to work
        $qc->qq_login();
    }

    public function qqlogin()
    {
        require_once("./Tools/qq/API/qqConnectAPI.php");
        $qc = new \QC();
//get login success user's access_tocken
//echo $qc->qq_callback();
//get openid from qq to identify new qq member
        $openid = $qc->get_openid();
            $mem =D('Member');
//find info from old uer qq openid
        $info = $this->mem->where("openid='$openid'")->find();
        if ($info) {
            //store name, login status and login time from last time
            session('member_name', $info['member_name']);
            session('member_login', 1);
            session('login_time', $info['login_time']);

            //update login time
            $data = array(
                'login_time' => time(),
                'member_id' => $info['member_id']
            );
            //update login time data
            $this->mem->save($data);
                //url open in parent window
              $url = U('Index/index');
                die;
        } else {
            //store new session openid if cannot find openid in table
            session('openid', $openid);
            //bind openid by redirecting to bind()
            $url = U('Member/bind');
//         open url in the parent window instead of small window by echoing js
//   opener is the parent window relative to small window, close the small window
            echo "<script>opener.location.href = '$url';window.close();</script>";die;
        }
    }
    //bind old user's openid
    public function bind(){
        if(IS_POST){
            $_POST['open_id']=session('openid');
            //validate all info in post
            $info =D('Member')->create();
            if(!$info){
                $this->error(D('Member')->getError());die;
            }
            $res =D('Member') ->save();
            if($res){
               session('member_name', $info['member_name']);
            session('member_login', 1);
            $this->success('binding success!',U('Index/index'));die;
            }else{
                $this->error('binding failed');die;
            }
        }
        $this->display();
    }
}