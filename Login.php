<?php

/**
 * Description of Login
 *
 * @author gesfor.rgonzalez
 */
class Login
{
   //put your code here

   private $sendByAjax = false;
   private $sendActionFile = '';
   private $pathLogo = '';
   private $styleLogin = "Materialize";
   private $title = '';
   
   public function setTitle($title)
   {
      $this->title = $title;
      return $this;
   }

   public function SetSendByAjax($sendByAjax_)
   {
      $this->sendByAjax = $sendByAjax_;
   }
   public function SetSendActionFile($sendActionFile_)
   {
      $this->sendActionFile = $sendActionFile_;
   }
   public function SetStyleLogin($styleLogin_)
   {
      $this->styleLogin = $styleLogin_;
   }
   public function SetPathLogo($pathLogo_)
   {
      $this->pathLogo = $pathLogo_;
   }

   public function CreateLogin()
   {
      if($this->styleLogin === 'Materialize')
      {
	 return $this->StrLoginMaterialize();
      }
      else if($this->styleLogin === 'Bootstramp')
      {
	 
      }
      
   }

   private function StrLoginMaterialize()
   {
      $ispost = ($this->sendByAjax === true) ? '' : 'method="post"';
      $submit = ($this->sendByAjax === true) ? 'type="button"' : 'type="submit"';

      $action = ($this->sendActionFile === '') ? '' : 'action="'.$this->sendActionFile.'"';
      $logoimg = ($this->pathLogo === '') ? '' : '<img src="'.$this->pathLogo.'" alt="logo" class="center_percent" style="z-index:1001;"/>';
      $title = ($this->title === '') ? '' : $this->title;

      $strLogin = <<<EOF
<div class="row center_percent">
   <div class="col">
      <div class="card">
	 <div id="loading" style="display:none; position: absolute;  width:100%; height: 100%; z-index: 1000; background-color:rgba(192,192,192,0.4);">
	   <img src="loading.gif" alt="" class="center_percent" style="z-index:1001;"/>
	 </div>
	 <div class="card-content">
	    $logoimg
	    <span class="card-title">
	       $title
	    </span>
	    <br>
	    <div class="row">
	       <form class="col s12" $ispost $action>
		  <div class="row">
		     <div class="input-field col s12">
			<i class="material-icons prefix">account_circle</i>
			<input id="user" type="text" name="user">
			<label for="user">User</label>
		     </div>
		     <div class="input-field col s12">
			<i class="material-icons prefix">lock</i>
			<input id="password" type="password" name="password">
			<label for="password">Password</label>
		     </div>
		  </div>
		  <div class="card-action">
		     <button id="send" $submit class="btn waves-effect waves-light blue darken-4" name="send" value="sended">Enter
			<i class="material-icons right">send</i>
		     </button>
		  </div>
	       </form>
	    </div>
	    <div id="loading_foot" class="card-footer text-muted" style="display: none; padding: 3px 3px 3px 3px;" class="green lighten-4">
	       Checkin credentiales...
	    </div>
	 </div>
      </div>      
   </div>
</div>
EOF;
      return $strLogin;
   }
   
   private function StrLoginBootstrap()
   {
      
   }
   
   public function FunctionAjax()
   {
      $strFuncAjax = '';
      
      if($this->sendByAjax === true)
      {
	 $strFuncAjax = <<<EOF

var btn_enter = document.getElementById('send');
btn_enter.addEventListener('click', EnterSys);

 function EnterSys()
 {
    var JsonData = {
       "vars": {"NameFunction": "LogUser", "user": $("#user").val(), "passw": $("#password").val()}
    };

    CallBacksAjaxLog("$this->sendActionFile", 'POST', JsonData, 'JSON', function (ObjectData)
    {
       console.log(ObjectData);
       var DatsBD = ObjectData['obj_'];
       console.log(DatsBD);
       OnSuccedMake(ObjectData['num_']);
    });
 }

 function CallBacksAjaxLog(pUrl, pType, pData, pDatatype, MyCallBack)
 {
    var ObjectData;
    $.ajax({
       url: pUrl,
       type: pType,
       data: {MyJson: pData},
       datatype: pDatatype,
       async: true,
       beforeSend: function ()
       {
	  $("#loading").show(300);
	  $("#loading_foot").show(300);
       }
    }).done(function (jsonStr, textStatus, jqXHR)
    {
       if (console && console.log)
       {
	  console.log("Success: " + textStatus + ". " + jqXHR + ". " + jsonStr);
       }
       $("#loading").hide();
       ObjectData = JSON.parse(jsonStr);	   
       MyCallBack(ObjectData);
       return ObjectData;
    }).fail(function (jqXHR, textStatus, errorThrown)
    {
       if (console && console.log)
       {
	  console.log("Error: " + textStatus + ". " + errorThrown + ". " + jqXHR);
       }
       ObjectData = "Sorry, Error: " + errorThrown + ". Status: " + textStatus;
       MyCallBack(ObjectData);
       return ObjectData;
    });
 }

 function OnSuccedMake(response)
 {
    if(response == 0)
    {
       $('#loading_foot').hide(300, function(){  
	  $('#loading_foot').removeClass( "green lighten-4" ).addClass( "red lighten-4" );
	  $('#loading_foot').show(300, function(){
	     $('#loading_foot').html('Invalid Credentials.');
	  });
       })
    }
    else
    {
       $('#loading_foot').hide(300, function(){  
	  $('#loading_foot').removeClass( "green lighten-4" ).addClass( "blue lighten-4" );
	  $('#loading_foot').show(200, function(){
	       $('#loading_foot').html('Enter to the system...');
	       location.reload();
	  });
       });
    }
 }       

EOF;
      }

      return $strFuncAjax;
   }
   
}
