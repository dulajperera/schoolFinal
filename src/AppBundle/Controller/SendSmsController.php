<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SmsController extends Controller
{

    private function get_web_page( $url )
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
        );

        $ch = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $header = curl_getinfo( $ch );
        curl_close( $ch );

        return $content;
    }

    /**
     * @Route("/sms/{to}/{content}", name="sms")
     */
    public function smsAction($to, $content){

        $user = "94718825963";
        $password = "3783";
        $text = urlencode($content);

        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = $this->get_web_page($url);
        $res= explode(":",$ret);

        $html="";
        if (trim($res[0])=="OK")
        {
            $html =  "Message Sent - ID : ".$res[1];
        }
        else
        {
            $html =  "Sent Failed - Error : ".$res[1];
        }

        return new Response($html);
    }

}