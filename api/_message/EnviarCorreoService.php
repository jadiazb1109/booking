<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './libs/email_templates/phpmailer/src/Exception.php';
require './libs/email_templates/phpmailer/src/PHPMailer.php';
require './libs/email_templates/phpmailer/src/SMTP.php';

require './libs/email_templates/phpmailer/autoload.php';

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';

class EnviarCorreoService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => []
    );  

    function asDollars($value) {
        return '$' . number_format($value, 2).' USD';
    }

    function correoPrueba($currentRideBooking){
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        setlocale(LC_MONETARY, 'en_US');
        try {
   
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = "info-flexwit@erp-soft.dev";                     //SMTP username
            $mail->Password   = "3sc0rp10n.JD";                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
            //Recipients
            $mail->setFrom("info-flexwit@erp-soft.dev", "HR TRANSPORTATION");
            $mail->addReplyTo("reservations@hrtransportation.us", "HR TRANSPORTATION");
            $mail->addAddress($currentRideBooking["client"]["email"], $currentRideBooking["client"]["name"]);     //Add a recipient
            $mail->addBCC("reservations@hrtransportation.us","HR TRANSPORTATION");
           
        
            //Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Booking confirmation";


            $room_number = "";

            if ($currentRideBooking["service"]["room_number"] == 1) {
                $room_number = '
                    <tr>
                        <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                    </tr>                                                                                    
                    <tr>
                        <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                        <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                            <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;Room Number: '.$currentRideBooking["room_number"].'</span> </font>
                        </td>
                    </tr>
                ';
            }

            $return_str = "";

            if ($currentRideBooking["return"]["date"] != null) {
                $return_str = '
                    <tr>
                        <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                            <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title">Return</span> </font>
                        </td>
                    </tr>    
                    <tr>
                        <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                    </tr>                                                                                    
                    <tr>
                        <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                        <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                            <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$currentRideBooking["return"]["to"].' / '.$currentRideBooking["return"]["date"].' / '.$currentRideBooking["return"]["pick_up_time"]["time"].'</span> </font>
                        </td>
                    </tr>
                ';
            }

            $client_name = "";
            $client_phone = "";
            $client_email = "";
            $client_destiny = "";

            if ($currentRideBooking["client"] != null) {
                $client_name = $currentRideBooking["client"]["name"];
                $client_phone = $currentRideBooking["client"]["phone"];
                $client_email = $currentRideBooking["client"]["email"];
                $client_destiny = $currentRideBooking["client"]["destiny"] ? " ( ".$currentRideBooking["client"]["destiny"]." )" : "";
            }

            $passenger = 0;
            $price = 0;
            $additional = 0;
            $pay = 0;

            if ($currentRideBooking["passenger_group"] != null) {
                $passenger = $currentRideBooking["passenger_group"]["passenger_min"] ." - ". $currentRideBooking["passenger_group"]["passenger_max"];
                $price = $this->asDollars((double)$currentRideBooking["passenger_group"]["price"]);
                $additional = $this->asDollars((double)$currentRideBooking["passenger_group"]["additional"]);
                $pay = $this->asDollars((double)$currentRideBooking["pay"]);
            }else{
                $passenger = $currentRideBooking["passenger_qty"];
                $price = $this->asDollars((double)$currentRideBooking["destiny"]["price"]);
                $additional = $this->asDollars((double)$currentRideBooking["destiny"]["additional"]);
                $pay = $this->asDollars((double)$currentRideBooking["pay"]);
            }

            

            $mail->Body = '
        
                <div tabindex="0" aria-label="Cuerpo del mensaje" class="ulb23 GNqVo allowTextSelection OuGoX" id="UniqueMessageBody_6">
                    <div visibility="hidden">
                        <style>
                            <!--
                            .rps_95c2 .x_ExternalClass {
                                width: 100%
                            }

                            .rps_95c2 .x_ExternalClass,
                            .rps_95c2 .x_ExternalClass p,
                            .rps_95c2 .x_ExternalClass span,
                            .rps_95c2 .x_ExternalClass font,
                            .rps_95c2 .x_ExternalClass td,
                            .rps_95c2 .x_ExternalClass div {
                                line-height: 100%
                            }

                            .rps_95c2>div {
                                margin: 0;
                                padding: 0;
                                border: 0;
                                width: 100%
                            }

                            .rps_95c2 table td {
                                border-collapse: collapse
                            }

                            .rps_95c2 a {
                                text-decoration: none;
                                color: #0D89F6
                            }

                            .rps_95c2 a :visited {
                                color: #0D89F6
                            }

                            .rps_95c2 a :active {
                                color: #FFF
                            }

                            .rps_95c2 img {
                                display: block
                            }

                            .rps_95c2 .x_tbl-100 {
                                width: 100% !important
                            }

                            .rps_95c2 .x_tbl-40 {
                                width: 40%
                            }

                            .rps_95c2 .x_primary-container {
                                border-spacing: 0;
                                border-collapse: collapse;
                                border-radius: 4px;
                                box-shadow: 1px 1px 4px 0 #BBB;
                                margin: 0 auto;
                                width: 100% !important;
                                max-width: 600px !important
                            }

                            .rps_95c2 .x_primary-strip {
                                border-radius: 4px 4px 0 0;
                                color: #fff
                            }

                            .rps_95c2 .x_primary-strip-spacer-h {
                                line-height: 13px
                            }

                            .rps_95c2 .x_primary-content {
                                line-height: 125%
                            }

                            .rps_95c2 .x_primary-button {
                                width: 100%;
                                border-radius: 4px;
                                text-decoration: none;
                                display: block;
                                color: #fff;
                                border: 0 solid #0F9354
                            }

                            .rps_95c2 .x_primary-button-container {
                                min-width: 65%
                            }

                            .rps_95c2 .x_primary-button td {
                                font-family: "Open sans", sans-serif;
                                font-size: 24px
                            }

                            .rps_95c2 .x_text-welcome {
                                font-family: "Ubuntu", sans-serif;
                                font-size: 26px
                            }

                            .rps_95c2 .x_text-title {
                                font-family: "Ubuntu", sans-serif;
                                font-size: 20px
                            }

                            .rps_95c2 .x_text-body {
                                font-family: "Open sans", sans-serif;
                                font-size: 18px
                            }

                            .rps_95c2 .x_text-button {
                                font-family: "Ubuntu", sans-serif;
                                font-size: 18px
                            }

                            .rps_95c2 .x_text-car-title {
                                font-family: "Open sans", sans-serif;
                                font-size: 26px
                            }

                            .rps_95c2 .x_text-bold {
                                font-weight: bold
                            }

                            .rps_95c2 .x_text-spacing {
                                line-height: 150%
                            }

                            .rps_95c2 .x_heading-divider {
                                border-bottom: 3px solid #0D89F6;
                                width: 25%
                            }

                            .rps_95c2 .x_thinRule {
                                border-bottom: 2px solid #CCC
                            }

                            .rps_95c2 .x_section-icons {
                                width: 24px
                            }

                            .rps_95c2 .x_confirmed-img {
                                display: inline;
                                margin-left: 4px
                            }

                            .rps_95c2 .x_green-tick-icon {
                                width: 28px
                            }

                            .rps_95c2 .x_hide-d {
                                display: none
                            }

                            .rps_95c2 .x_list-icon,
                            .rps_95c2 .x_list-icon img {
                                width: 20px
                            }

                            .rps_95c2 .x_image-car {
                                width: 100%;
                                max-width: 200px
                            }

                            .rps_95c2 .x_image-supplier {
                                max-height: 50px
                            }

                            .rps_95c2 .x_price-amount {
                                text-align: left
                            }

                            @media screen and (max-width: 580px) {
                                .rps_95c2 .x_m-span10 {
                                    width: 100% !important
                                }

                                .rps_95c2 .x_m-span9 {
                                    width: 90% !important
                                }

                                .rps_95c2 .x_m-block {
                                    display: block !important;
                                    width: 100% !important;
                                    float: none !important
                                }

                                .rps_95c2 .x_m-hide {
                                    display: none !important
                                }

                                .rps_95c2 .x_m-center {
                                    text-align: center !important;
                                    float: none !important;
                                    margin: 0 auto !important
                                }

                                .rps_95c2 .x_mb10 {
                                    margin-bottom: 10px !important
                                }

                                .rps_95c2 .x_m-font-18 {
                                    font-size: 18px !important;
                                    line-height: 28px !important
                                }

                                .rps_95c2 .x_m-no-padding {
                                    padding: 0 !important
                                }

                                .rps_95c2 .x_mob-stack {
                                    width: 100% !important;
                                    display: block !important
                                }

                                .rps_95c2 .x_hide-d {
                                    display: block !important
                                }

                                .rps_95c2 .x_hide-m {
                                    display: none !important
                                }

                                .rps_95c2 .x_primary-button-container {
                                    width: 100% !important
                                }

                                .rps_95c2 .x_price-amount {
                                    text-align: right
                                }

                            }
                            -->
                        </style>
                        <div class="rps_95c2">
                            <div>
                                <table style="background-color:#F5F5F5; width:100%" bgcolor="#F5F5F5" width="100%" cellpadding="0" cellspacing="0" align="center" class="x_tbl-100">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table style="background-color:#05384D; width:100%" cellpadding="0" cellspacing="0" border="0" width="100%" class="x_tbl-100" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td align="center">
                                                                <table style="background-color:#05384D" cellpadding="0" cellspacing="0" border="0" class="x_m-span10" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="line-height:20px; font-size:20px; height:20px" colspan="1" class="x_spacer-20-h" height="20">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="x_spacer-20-h" style="font-family:"Ubuntu",Arial,sans-serif; font-size:30px; line-height:22px; font-weight:700; color:#FFFFFF">
                                                                            <font face=""Ubuntu", Arial, sans-serif"><span style="color:#FFFFFF">Booking number: '. $currentRideBooking["id"] .'</span> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="line-height:20px; font-size:20px; height:20px" colspan="1" class="x_spacer-20-h" height="20">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="background-color:#F5F5F5" bgcolor="#F5F5F5" cellpadding="0" cellspacing="0" align="center" class="x_tbl-100">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:15px" width="15">&nbsp;</td>
                                                            <td align="center">
                                                                <table cellpadding="0" cellspacing="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:16px; line-height:16px" height="16">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table style="width:600px; background-color:#FFFFFF" class="x_primary-container" width="600" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background-color:#0766BC" bgcolor="#0D89F6" class="x_primary-strip x_text-title">
                                                                                <table cellpadding="0" cellspacing="0" class="x_tbl-100">
                                                                                    <tbody>
                                                                                        <tr class="x_primary-strip-spacer-h">
                                                                                            <td colspan="3">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width:13px" width="13">&nbsp;</td>
                                                                                            <td>
                                                                                                <table cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td><img alt="" width="24" class="x_section-icons" src="https://erp-soft.dev/booking/_img/icono.png"></td>
                                                                                                            <td style="width:10px" width="10">&nbsp;</td>
                                                                                                            <td style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#FFFFFF">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold">Ride</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td style="width:13px" width="13">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr class="x_primary-strip-spacer-h">
                                                                                            <td colspan="3">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="x_primary-content x_text-body">
                                                                                <table cellpadding="0" cellspacing="0" class="x_tbl-100">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="height:15px; line-height:15px" height="15" colspan="3">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width:15px" width="15">&nbsp;</td>
                                                                                            <td>
                                                                                                <table cellpadding="0" cellspacing="0" class="x_tbl-100">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-title x_text-bold"><b>Origin</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td  style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$currentRideBooking["origin"]["name"].'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title"><b>Service</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>    
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                                    
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;('.$currentRideBooking["service"]["type"].') - '.$currentRideBooking["service"]["name"].'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title"><b>Destiny</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>    
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                                    
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$currentRideBooking["destiny"]["destiny"]. $client_destiny.'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title"><b>Departure day & Pick up time</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>    
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                                    
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$currentRideBooking["date"].' / '.$currentRideBooking["pick_up_time"]["time_format"].'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        '.$return_str.'
                                                                                                        <tr>
                                                                                                            <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title"><b>Contact Information</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        '.$room_number.'                                                                                                        
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                               
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$client_name.'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>  
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$client_phone.'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>  
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;'.$client_email.'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:20px; line-height:20px" height="20">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2" style="font-family:"Ubuntu",Arial,sans-serif; font-size:20px; line-height:22px; font-weight:700; color:#000000" colspan="2">
                                                                                                                <font face=""Ubuntu", Arial, sans-serif"><span class="x_text-bold x_text-title"><b>Passengers & Pay</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                                    
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;Passenger: '.$passenger.'</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>                                                                                    
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp;Price: '.$price.' + ( '.$additional.' )</span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="height:10px; line-height:10px" height="10">&nbsp;</td>
                                                                                                        </tr>  
                                                                                                        <tr>
                                                                                                            <td class="x_list-icon" ><img alt="" src="https://www.rentalcars.com/images/site_graphics/newsite/outlined-tick-circle-green.png"></td>
                                                                                                            <td style="font-family:"Open sans",Arial,sans-serif; font-size:18px; line-height:20px; color:#000000">
                                                                                                                <font face=""Open sans", Arial, sans-serif"><span>&nbsp;&nbsp; <b>Pay: '.$pay.'</b></span> </font>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td style="width:15px" width="15">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="height:15px; line-height:15px" height="15" colspan="3">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:16px; line-height:16px" height="16">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:16px; line-height:16px" height="16">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:16px; line-height:16px" height="16">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td style="width:15px" width="15">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="width:100%; background-color:#ffffff" bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table style="width:100%; background-color:#05384D" class="x_m-span10" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:3px; line-height:1px; font-size:1px" height="3">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="height:16px; line-height:16px" height="16" align="center">
                                                                <br>This email was sent by an automated system. Please do not reply to this message.
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
            ';
        
            
            $mail->send();
            $this->response["state"] = "ok";
            $this->response["message"] = "Message sent" ;
           
        
        } catch (Exception $e) {
        
            $this->response["state"] = "ko";
            $this->response["message"] = "Unsent message -> ". $mail->ErrorInfo ;
        }

        return $this->response;

    }
}