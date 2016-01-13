<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 
$urbax['behindpage']=<<<EDO
 <div id="login" class="closed">
 <form method='post'>
  Användarnamn: <input type="text" name="acronym"> 
  Lösenord:   <input type="password" name='password'>
  &nbsp;&nbsp; <input type='submit' name='login' value='Logga in'/>
  <span style='font-size:12px;'> &nbsp;&nbsp; (Befintliga user/pass: <b>admin/admin</b>
    &amp; <b>doe/doe</b>)</span>
</form>
</div>
EDO;*/

if(isset($_POST['newuser']))
{
  $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            <h3 style="margin:0; margin-bottom:5px;">Ange önskat användarnamn och lösenord</h3>
            <span style="display:inline-block; width:100px;">Namn: </span><input type="text" name='newname'> 
            <br/><span style="display:inline-block; width:100px;">Lösenord: </span><input type="text" name='newpass'>
            <div style="margin-top:10px;"><input type='submit' name='fixnewaccount' value='Skapa nytt konto'/>
            <input type='submit' name='abort' value='Avbryt'/></div>
          </form>
          </div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
eod;
}
else if(isset($_POST['fixnewaccount']))
{
 
  if(strlen($_POST['newname'])<3 || strlen($_POST['newpass'])<3 )
  {
  $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            <h3 style="margin:0; margin-bottom:5px;">Användarnamn eller lösenord för kort!
            <input type='submit' name='newuser' value='Försök igen'/>
            <input type='submit' name='abort' value='Avbryt'/>
              </div>
          </form>
          </div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
eod;
  }
 else {
    $urbax['behindpage']= <<< eod
          <div id="login"><form>Nytt konto skapat.  
          <input type="submit" name="abort" value="ok"></form></div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
eod;
  }
}
else if($user->IsAuthenticated())
{
$name = $user->getName();
$urbax['behindpage']=<<<EDO
        <div id="login" class="closed">
          <form method='post'>
            <input type='submit' name='logout' value='Logga ut'/>
          </form>
        </div>
        <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Inloggad som <strong>$name</strong></div>    
EDO;
}
else if($user->status)
{
  $urbax['behindpage']=<<<EDO
        <div id="login">
        <form method='post'>
         Användarnamn: <input type="text" name='acronym'> 
         Lösenord:   <input type="password" name='password'>
         &nbsp;&nbsp; <input type='submit' name='login' value='Logga in'/>
         <span style='font-size:12px;'> &nbsp;&nbsp; (Befintliga user/pass: <b>admin/admin</b>
           &amp; <b>doe/doe</b>)</span> {$user->status}
       </form>
       </div>
        <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Logga in</div>
EDO;
}
else
{
  $urbax['behindpage']=<<<EDO
        <div id="login" class="closed">
        <form method='post' style="display:inline-block;">
         Användarnamn: <input type="text" name='acronym'> 
         Lösenord:   <input type="password" name='password'>
         &nbsp;&nbsp; <input type='submit' name='login' value='Logga in'/>
         <span style='font-size:12px;'> &nbsp;&nbsp; (Befintliga user/pass: <b>admin/admin</b>
           &amp; <b>doe/doe</b>)</span> 
       </form>
       <form method="post" style="display:inline-block;">
           &nbsp;<input type='submit' name='newuser' value='Skapa nytt användarkonto'/>
       </form>
       </div>
        <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Logga in</div>
EDO;
}
