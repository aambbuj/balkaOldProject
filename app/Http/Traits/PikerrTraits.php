<?php 
    namespace App\Http\Traits;

  trait PikerrTraits
  {
    
    function checkCOD($from_pincode,$to_pincode)
    {
      $url = 'https://pickrr.com/api/check-pincode-service/';

        $data = array (
            'from_pincode' => $from_pincode,
            'to_pincode' => $to_pincode,
            'auth_token' => env('pickrr_auth_token'),
            );
            
            $params = '';
        foreach($data as $key=>$value)
                    $params .= $key.'='.$value.'&';

            $params = trim($params, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$params ); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        return $result;

    }

    function placeOrder($params)
    {
        try{
            $json_params = json_encode( $params );
            $url = 'https://www.pickrr.com/api/place-order/';
            //open connection
            $ch = curl_init();
            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $json_params);
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            //execute post
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            return $result;
            //close connection
            curl_close($ch);
            if(gettype($result)!="array")
              throw new \Exception( print_r($result, true) . "Problem in connecting with Pickrr");
            if($result['err']!="")
              throw new \Exception($result['err']);
            return $result['tracking_id'];
        }
        catch (\Exception $e) {
          return  $e;
            }
    }

    public function checkSheppingCharges($params)
    {

      $url = 'https://pickrr.com/api-v2/client/fetch-price-calculator-generic/';

      $data = array (
          'shipment_type' => $params['shipment_type'],
          'pickup_pincode' => $params['pickup_pincode'],
          'drop_pincode' => $params['drop_pincode'],
          'delivery_mode' => $params['delivery_mode'],
          // 'length' => $params['length'],
          // 'breadth' => $params['breadth'],
          // 'height' => $params['height'],
          // 'weight' => $params['weight'],
          'payment_mode' => $params['payment_mode'],
          'auth_token' => env('pickrr_auth_token'),
          );
          
          $params = '';
      foreach($data as $key=>$value)
                  $params .= $key.'='.$value.'&';

          $params = trim($params, '&');

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url.'?'.$params ); //Url together with parameters
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7); //Timeout after 7 seconds
      curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
      curl_setopt($ch, CURLOPT_HEADER, 0);

      $result = curl_exec($ch);
      curl_close($ch);
      return $result;         
    }
    
    function orderTracking($tracking_number)
    {
        $url = 'https://pickrr.com/api/tracking-json/';
        $data = array (
            'tracking_id' => $tracking_number,
            'auth_token' => env('pickrr_auth_token')
            );
            $params = '';
            foreach($data as $key=>$value)
                    $params .= $key.'='.$value.'&';
            $params = trim($params, '&');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url.'?'.$params ); //Url together with parameters
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7); //Timeout after 7 seconds
            curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $result = curl_exec($ch);
            curl_close($ch);
            echo $result;
    }

  }
