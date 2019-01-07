<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenIdController extends Controller
{
    public function home(Request $request)
    {
        if(isset($request->code)) {
            // $opts = array(
            //     'http'=>array(
            //       'method'=>"POST",
            //       'header' => 'Content-type: application/xwww-form-urlencoded',
			//       'content' => http_build_query(array(
            //             'grant_type' => 'authorization_code',
            //             'code' => $request->code,
            //             'redirect_uri' => 'http%3A%2F%2Flocalhost%3A8000',
            //             'client_id' => 'teste1',
            //             'client_secret' => '$client_secret',
            //         ))
            //     )
            //   );
            // $context = stream_context_create($opts);
            // // Open the file using the HTTP headers set above
            // $file = file_get_contents('http://127.0.0.1:8080/auth/realms/test_keycloak/protocol/openid-connect/token', false, $context);
            // dd($file);


            $cpost = http_build_query([
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => 'http%3A%2F%2F127.0.0.1%3A8000',
                'client_id' => 'teste1',
                'client_secret' => '65b0d71d-0936-4f3b-a161-9540578ae917',
            ]);
            // $client = new \GuzzleHttp\Client([
            //     // You can set any number of default request options.
            //     // 'timeout'   => 2000.0,
            //     // 'debug'     => true,
            //     'allow_redirects' => false,
            //     'proxy'     => [
            //         'http'  => 'http://mbarbosa:yobuYI40@cache01.pbh:3128',
            //         'https' => 'http://mbarbosa:yobuYI40@cache01.pbh:3128',
            //         'no'    => ['.pbh.gov.br', '127.0.0.1', 'localhost'] ,
            //     ]
            //     // 'headers'   => [
            //     //     'Content-type' => 'application/json',
            //     // ],
            // ]);
            // $res = $client->request(
            //         'POST',
            //         'http://127.0.0.1:8080/auth/realms/test_keycloak/protocol/openid-connect/token', [
            //             'body' => $cpost
            //         ]
            // );
            // echo $res->getStatusCode();
            // // "200"
            // echo $res->getHeader('content-type');
            // // 'application/json; charset=utf8'
            // echo $res->getBody();
            // // {"type":"User"...'
            // exit;

            $curl_handle=curl_init();

            curl_setopt($curl_handle, CURLOPT_HEADER, false);
            curl_setopt($curl_handle, CURLOPT_POST, true);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $cpost);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($curl_handle, CURLOPT_PROXY, 'http://cache01.pbh:3128');
            curl_setopt($curl_handle, CURLOPT_PROXYUSERPWD, "mbarbosa:yobuYI40");
            curl_setopt($curl_handle, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);

            // curl_setopt($curl_handle, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($curl_handle, CURLOPT_URL, 'http://127.0.0.1:8080/auth/realms/test_keycloak/protocol/openid-connect/token');

            $result = curl_exec($curl_handle);
            var_dump($result);
            $info = curl_getinfo($curl_handle);
            $error = curl_error($curl_handle);
            curl_close($curl_handle);

            // return redirect('http://127.0.0.1:8080/auth/realms/test_keycloak/protocol/openid-connect/token?grant_type=authorization_code&code='.$request->code.'&client_id=teste1&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2F&client_secret=');
        }

        return view('welcome');
    }

    public function login()
    {
        return redirect('http://127.0.0.1:8080/auth/realms/test_keycloak/protocol/openid-connect/auth?response_type=code&client_id=teste1&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2F&state=d0e65e2d23');
    }
}
