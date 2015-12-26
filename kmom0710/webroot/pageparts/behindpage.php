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



if($user->IsAuthenticated())
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
else
{
  $urbax['behindpage']=<<<EDO
        <div id="login" class="closed">
        <form method='post'>
         Användarnamn: <input type="text" name='acronym'> 
         Lösenord:   <input type="password" name='password'>
         &nbsp;&nbsp; <input type='submit' name='login' value='Logga in'/>
         <span style='font-size:12px;'> &nbsp;&nbsp; (Befintliga user/pass: <b>admin/admin</b>
           &amp; <b>doe/doe</b>)</span>
       </form>
       </div>
        <div id="logininfo" onclick='showLogin()'><i class="fa fa-angle-down"></i> 
         &nbsp;Logga in</div>
EDO;
}
