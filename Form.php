<?php


/**
 * Description of FormHtml
 *
 * @author gesfor.rgonzalez
 */
class Form
{

   private $id = '';
   private $style = '';
   private $class = '';   
   private $name = '';
   
   private $action = '';
   private $autocomplete = '';
   private $method = '';
   private $target = '';
   private $novalidate = '';
   
   private $breakup = '';
   
   public function SetID($id_)
   {
      if ($id_ !== '')
      {
	 $this->id = ' id="' . $id_ . '"';
      }
   }
   public function SetName($name_)
   {
      if ($name_ !== '')
      {
	 $this->name = ' name="' . $name_ . '"';
      }
   }
   public function SetStyle($style_)
   {
      if ($style_ !== '')
      {
	 $this->style = ' style="' . $style_ . '"';
      }
   }
   public function SetClass($class_)
   {
      if ($class_ !== '')
      {
	 $this->class = ' class="' . $class_ . '"';
      }
   }   
   
   public function SetAction($action_)
   {
      if ($action_ !== '')
      {
	 $this->action = ' action="' . $action_ . '"';
      }
   }  
   public function SetAutocomplate($autocomplete_)
   {
      if ($autocomplete_ !== '')
      {
	 $this->autocomplete = ' autocomplete="' . $autocomplete_ . '"';
      }
   }  
   public function SetMethod($method_)
   {
      if ($method_ !== '')
      {
	 $this->method = ' method="' . $method_ . '"';
      }
   }  
   public function SetTarget($target_)
   {
      if ($target_ !== '')
      {
	 $this->target = ' target="' . $target_ . '"';
      }
   }  
   public function SetNovalidate($novalidate_)
   {
      if ($novalidate_ !== '')
      {
	 $this->novalidate = ' novalidate';
      }
   }  
   public function SetBreakUp($breakup_)
   {
      if ($breakup_ !== '')
      {
	 $this->breakup = $breakup_; 
      }
   }
   
   public function CreateForm()
   {
      $numargs = func_num_args();
      $nomargs = func_get_args();
      
      $inputs = '';
      foreach ($nomargs as $key => $value)
      {
	  $inputs .= $value . $this->breakup;
      }
      
      $stringform = <<<EOF
<form$this->id$this->name$this->action$this->method$this->style$this->class$this->target$this->autocomplete$this->novalidate>
$inputs
</form>
EOF;
      return $stringform;
   }
   
   
}
