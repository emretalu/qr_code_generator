<?php

    include "qr_code.php";

    $type = isset($_POST['type']) ? $_POST['type'] : "";
    $save = isset($_POST['save']) ? $_POST['save'] : "";

    if($type != ""){
        $qr_code = new qr_code();

        switch($type){
            case("text"):
                $qr_code->text('Test');

                break;
            case("url"):
                $qr->url('http://www.domain.com');

                break;
            case("email"):
                $qr->email('test@domain.com', 'Test', 'Example content');

                break;
            case("phone"):
                $qr->phone('5554443322');

                break;
            case("sms"):
                $qr->sms('5554443322', 'example message content');

                break;
            case("contact"):
                $qr->contact('Example User', 'Example address', '5554443322', 'test@domain.com');

                break;
            case("content"):
                $qr->content('Example', '150', 'Example Content');

                break;
        }

        if($save == "image"){
            $qr_code->qrCode(250, 'images/test.png');
        }else{
            $qr_code->qrCode();
        }
    }