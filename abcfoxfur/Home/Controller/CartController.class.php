<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/27/2017
 * Time: 10:09 PM
 */
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
    public function __construct(){
        parent::__construct();
        //instantialize cart object
        $this->cart = new \Library\Cart();

    }
    public function index(){
        dump($this->cart);
    }
    public function add(){
    $product_id  =I('post.product_id');
    $product_name    =I('post.product_name');
    //as there are decimal place for price
    $product_price   =I('post.product_price',0,'floatval');
    $amount  =I('post.amount',0,'intval');
        $data = array(
            'goods_id' => $product_id,
            'goods_name' => $product_name,
            'goods_price' => $product_price,
            'goods_buy_number' =>$amount,
            'goods_total_price' => $product_price *$amount,
        );
        //use add() from library , it wont return any data
        $this->cart->add($data);
        $cartinfo = $this->cart->getCartInfo();
        if(isset($cartinfo[$product_id])){
            //if product exists, get total number price
            $result =$this ->cart->getNumberPrice();
            $result['error_code'] = 0 ;
            $result['message'] = 'add product to cart successfully';
        }else{
            $result =array(
                'error_code' => 1,
                'message' => 'fail to add product to cart!'
            );
        }
        echo json_encode($result);
    }

    public function flow1(){
        $cart_info =$this->cart->getCartInfo();
        //get each thumb from products in the cart
        foreach($cart_info as $key=>$item) {
            $product_id = $item['goods_id'];
            $res = D('Product')->field('product_small_logo')->find($product_id);
            //add thumb to cartinfo array
            $cart_info[$key]['thumb'] = $res['product_small_logo'];
        }
        $this->cartinfo = $cart_info;
        $this->display();
    }
    public function flow2(){

        //jump to login if member hasnt login in session
        //give get param to redirect back once login has been done
        if(session('Home_is_login')!=1){
            $this->error('please login before proceeding',U('Home/Member/login').'?redire=Cart/flow2');die;
        }

        $cart_info =$this->cart->getCartInfo();
        foreach($cart_info as $key=>$item){
            $product_id = $item['goods_id'];
            $res = D('Product')->field('product_small_logo')->find($product_id);
            //add thumb to cartinfo array
            $cart_info[$key]['thumb'] = $res['product_small_logo'];
        }
        $this->cartinfo = $cart_info;

        //assign total price and total quantity to tempalte
        $this->getNumberPrice = $this->cart->getNumberPrice();

        $this->display();
    }

    public function buy(){
        $cart_info=$this->cart->getCartInfo();
        $getNumberPrice=$this->cart->getNumberPrice();

        $data['user_id'] =session('Home_member_id');
        $data['order_number']=date('YmdHis').mt_rand(100000,999999);
        $data['order_price']=$getNumberPrice['price'];
        //default as 支付寶
        $data['order_pay']=0;
        //default as unpaid
        $data['order_status']=0;
        $data['created_time']=time();
        $data['updated_time']=time();
        //store data into order model
        $res=D('Order')->add($data);

        //store info in order goods relationship table according to the new order generated
         foreach($cart_info as $item){
            $orderGoods['order_id']=$res;
            $orderGoods['goods_id']=$item['goods_id'];
             $orderGoods['goods_price']=$item['goods_price'];
             $orderGoods['goods_buy_number']=$item['goods_buy_number'];
              $orderGoods['goods_total_price']=$item['goods_total_price'];
              D('OrderGoods')->add($orderGoods);
         }

         //clear cart when everything is in the db as we assume the order is paied
        $this->cart->delall();
        //jump to alipay function
        //give params for alipay api
        $alipay['out_trade_no']=$data['order_number'];
        $alipay['subject']='test order';
        $alipay['total_fee']=$data['order_price'];
        $alipay['body']='testtest';
        D('Alipay')->alipayapi($alipay);
    }
    public function flow3(){
        $this->display();
    }
}
