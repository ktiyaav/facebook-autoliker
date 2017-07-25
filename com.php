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

if($_GET['id']){
$id = $_GET['id'];
require 'facebook.php';
include('config.php');

$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));

  $output = '';
   //get users and try liking
  $result = mysql_query("
      SELECT
         *
      FROM
         Likers
   ");
   

   
  if($result){
      while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$m = $row['access_token'];
			$facebook->setAccessToken ($m);
			 try {
$co1  = $_POST["comment1"];
$co2  = $_POST["comment2"];
$co3  = $_POST["comment3"];
$co4  = $_POST["comment4"];
$co5  = $_POST["comment5"];
$co6  = $_POST["comment6"];
$co7  = $_POST["comment7"];
 
 
 
$sen = array("Awesome dude :* ",
"nice pic :) ",
"really awsm  ",
"great!! ",
"no words!!",
"good :)",
":0 ",
";) perfect",
"END 3:)",
"heavyyyy ",
"yo bro",
"awesome <3 ",
" cha gya ",
"Mstt hai",
"heavy bhaii",
"superbbb...",
":( Inbox Plz",
"You are Great :D",
"Please Help me :( ",
"awesome :3",
"best :)",
"<3 <3",
"good good ",
"cutest ever :* ",
"no reply???",
"Rockstar :D",
"Reallyy ....Its Awsm",
"good one :)",
"nice pic dude",
"we support you <3 ",
" :D ",
"smart :3 :) ",
"oops!! you are awesome :D ",
"lots of likes",
"real beauty :3 ",
"you are great man..",
"plxxxxxx accept my request :( ",
"awesome bro :O ");
$msg = $sen[array_rand($sen)];
$facebook->api("/".$id."/comments",'post',array('message' => $msg));
$ok[]=1;
      }	   

catch (FacebookApiException $e) {
$no[]=1;
         }
}
}
echo count($ok).' Success <hr> '.count($no).' Failed';


mysql_close($connection);
}else{
header('Location: /comment.php');
}
?>