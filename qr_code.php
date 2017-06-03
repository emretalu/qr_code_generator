<?php

class qr_code{
    private $google_chart_api = 'http://chart.apis.google.com/chart';
    private $qrcode;

    public function url($url = null){
        $this->qrcode = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
    }

    public function text($text){
        $this->qrcode = $text;
    }

    public function email($email = null, $subject = null, $message = null){
        $this->qrcode = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
    }

    public function phone($phone){
        $this->qrcode = "TEL:{$phone}";
    }

    public function sms($phone = null, $msg = null){
        $this->qrcode = "SMSTO:{$phone}:{$msg}";
    }

    public function contact($name = null, $address = null, $phone = null, $email = null){
        $this->qrcode = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
    }

    public function content($type = null, $size = null, $content = null){
        $this->qrcode = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
    }

    public function qrCode($size = 200, $filename = null){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->googleChartAPI);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->qrcode));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $img = curl_exec($ch);

        curl_close($ch);

        if($img){
            if($filename){
                if(!preg_match("#\.png$#i", $filename)){
                    $filename .= ".png";
                }

                return file_put_contents($filename, $img);
            }else{
                header("Content-type: image/png");
                print $img;

                return true;
            }
        }
        return false;
    }
}