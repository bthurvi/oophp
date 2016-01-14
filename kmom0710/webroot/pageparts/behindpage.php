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
if(isset($_POST['editprofile']))
{
  $us = $_SESSION['user'];
$urbax['behindpage'] =<<< html
   <div id="login" class='editprofilediv'>
  <form method='post'>
  <p></p>
  <h1 style='margin: 0; margin-bottom:10px;'>Editera profil</h1>
  <p class='infolabel'>Namn:</p>
  <p class='infodiv'>{$us->name}&nbsp;</p>
  <p class='infolabel'>Intressen:</p>
  <p class='infodiv'>{$us->intrests}&nbsp;</p>
  <p class='infolabel'>Musik:</p>
  <p class='infodiv'>{$us->music}&nbsp;</p>
  <p class='infolabel'>Böcker:</p>
  <p class='infodiv'>{$us->books}&nbsp;</p>
  <p class='infolabel'>Favoritfilm:</p>
  <p class='infodiv'>{$us->favoritemovie}&nbsp;</p>
  <p>
  <br/>
  <input type='submit' name='saveprofile' value='Spara'>
  <input type='submit' name='abort' value='Avbryt'>
  </p>
  </form>
  </div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
html;

}else if(isset($_POST['newuser']))
{
  $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            <h3 style="margin:0; margin-bottom:5px;">Ange önskat användarnamn och lösenord</h3>
            <span style="display:inline-block; width:100px;">Namn: </span><input type="text" name='newname'> 
            <br/><span style="display:inline-block; width:100px;">Lösenord: </span><input type="text" name='newpass'>
            <div style="margin-top:10px;"><input type='submit' name='fixnewaccount' value='Skapa'/>
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
   
    $username = filter_input(INPUT_POST,'newname',FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST,'newpass',FILTER_SANITIZE_STRING);
    
    if(!$user->isUsernameAvaliable($username))
    {
      $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            Användarnamnet finns redan!
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
      
      if($user->addUser($username,$password))
      {
      $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            Nytt konto skapat.
            <input type='submit' name='abort' value='ok'/>
              </div>
          </form>
          </div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
eod;
      }
      else
      {
        $urbax['behindpage']= <<< eod
          <div id="login">
          <form method="post" style="display:inline-block;">
            Ooops - nått gick fel. Inget nytt konto skapat.
            <input type='submit' name='abort' value='ok'/>
              </div>
          </form>
          </div>
          <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Nytt konto</div>
eod;
      }
    }
    
    
    
    
  }
}
else if($user->IsAuthenticated())
{
$name = $user->getName();
$urbax['behindpage']=<<<EDO
        <div id="login" class="closed">
          <form method='post'>
            <input type='submit' name='logout' value='Logga ut'/>
            <input type='submit' name='editprofile' value='Editera profil'/>
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
