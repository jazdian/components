<?php

/**
 * Description of Input
 *
 * @author gesfor.rgonzalez
 */
class TextBox
{

   private $id		 = '';
   private $name		 = '';
   private $style		 = '';
   private $class		 = '';
   private $text		 = '';
   private $type		 = '';
   private $maxlength	 = '';
   private $readonly	 = false;
   private $attrhtml5	 = array(
       "autofocus"	 => false,
       "max"		 => "",
       "min"		 => "",
       "placeholder"	 => "",
       "required"	 => false,
       "pattern"	 => "",
       "autocomplete"	 => "off"
   );
   private $onblur		 = '';
   private $onchange	 = '';
   private $onfocus	 = '';
   private $onselect	 = '';
   private $disabled	 = false;
   private $wraphtmlcode = '';
   private $otherattr	 = '';
   private $labelname	 = '';

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
   public function SetType($type_)
   {
      if ($type_ !== '')
      {
	 $this->type = ' type="' . $type_ . '"';
      }
   }
   public function SetText($text_)
   {
      if ($text_ !== '')
      {
	 $this->text = ' value="' . $text_ . '"';
      }
   }
   public function SetMaxlength($maxlength_)
   {
      if ($maxlength_ !== '')
      {
	 $this->maxlength = ' maxlength="' . $maxlength_ . '"';
      }
   }
   /**
    * 
    * @param bool $readonly_
    */
   public function SetReadonly($readonly_)
   {
      if ($readonly_ === true)
      {
	 $this->readonly = 'readonly';
      }
   }
   /**
    * Set values a private array $attrhtml5.
    * Default values:
    * array(
    * "autofocus"=>false,
    * "max"=>0,
    * "min"=>0,
    * "placeholder"=>"",
    * "required"=>false,
    * "pattern"=>"",
    * "autocomplete"=>"off"
    * ) 
    * You can rewrite the values of array, and send only de items that you
    * want to change.
    * array("placeholder"=>"My placeholder","required"=>true)
    * 
    * @param array $attrhtml5_
    * @access public
    * @return void
    */
   public function SetAttrhtml5($attrhtml5_)
   {

      if (!array_key_exists('autofocus', $attrhtml5_))
      {
	 $attrhtml5_['autofocus'] = false;
      }
      if (!array_key_exists('max', $attrhtml5_))
      {
	 $attrhtml5_['max'] = "";
      }
      if (!array_key_exists('min', $attrhtml5_))
      {
	 $attrhtml5_['min'] = "";
      }
      if (!array_key_exists('placeholder', $attrhtml5_))
      {
	 $attrhtml5_['placeholder'] = "";
      }
      if (!array_key_exists('required', $attrhtml5_))
      {
	 $attrhtml5_['required'] = false;
      }
      if (!array_key_exists('pattern', $attrhtml5_))
      {
	 $attrhtml5_['pattern'] = "";
      }
      if (!array_key_exists('autocomplete', $attrhtml5_))
      {
	 $attrhtml5_['autocomplete'] = "off";
      }

      $this->attrhtml5 = $attrhtml5_;
   }
   public function SetOnBlur($onblur_)
   {
      $this->onblur = $onblur_;
   }
   public function SetOnChange($onchange_)
   {
      $this->onchange = $onchange_;
   }
   public function SetOnFocus($onfocus_)
   {
      $this->onfocus = $onfocus_;
   }
   public function SetOnSelect($onselect_)
   {
      $this->onselect = $onselect_;
   }
   public function SetDisabled($disabled_)
   {
      if($disabled_ === true)
      {
	 $this->disabled = 'disabled';
      }
   }
   /**
    * Search a replace.
    * 
    * @param string $search
    * @param string $replace
    * @param string $wraphtmlcode_
    */
   public function SetWrapHtmlCode($wraphtmlcode_)
   {
      if ($wraphtmlcode_ !== '')
      {
	 $this->wraphtmlcode = $wraphtmlcode_;
      }      
   }
   public function SetOtherAttr($otherattr_)
   {
      if ($otherattr_ !== '')
      {
	 $this->otherattr = $otherattr_;
      }      
   }
   public function SetLabelName($labelname_)
   {
      if ($labelname_ !== '')
      {
	 $this->labelname = $labelname_;
      }      
   }      
   
   public function CreateTextBox()
   {     
      $stringjavascript = $this->StringFunctionsJavaScript();
      $stringhtml5 = $this->StringAttrHtml5();
      
      $stringTextBox = <<<EOF
<input$this->id$this->type$this->name$this->text$this->style$this->class$this->maxlength$this->disabled$this->readonly$stringhtml5$stringjavascript$this->otherattr>
EOF;

      if($this->wraphtmlcode === '')
      {
	 return $stringTextBox;
      }
      else
      {
	 
	 $newhtmlcode = str_replace("_INPUT_", $stringTextBox, $this->wraphtmlcode);
	 $newhtmlcode2 = str_replace("_ID_", $this->StrPull($this->id), $newhtmlcode);
	 $newhtmlcode3 = str_replace("_LNAME_", $this->labelname, $newhtmlcode2);
	 return $newhtmlcode3;
      }
   }
   
   private function StrPull($string_)
   {
      $pos1 = strpos($string_, "\"");
      $newstr = substr($string_, $pos1 + 1);
      $pos2 = strpos($newstr, "\"");
      $newstr2 = substr($string_, $pos1 + 1, $pos2);
      return $newstr2;
   }
      
   private function StringAttrHtml5()
   {
      $attrhtml5 = '';
      
      if ($this->attrhtml5['autofocus'] !== false)
      {
	 $attrhtml5 .= ' autofocus';
      }
      if ($this->attrhtml5['max'] !== "")
      {
	 $attrhtml5 .= ' max="' . $this->attrhtml5['max'] . '"';
      }
      if ($this->attrhtml5['min'] !== "")
      {
	 $attrhtml5 .= ' min="' . $this->attrhtml5['min'] . '"';
      }
      if ($this->attrhtml5['placeholder'] !== '')
      {
	 $attrhtml5 .= ' placeholder="' . $this->attrhtml5['placeholder'] . '"';
      }
      if ($this->attrhtml5['required'] !== false)
      {
	 $attrhtml5 .= " required";
      }
      if ($this->attrhtml5['pattern'] !== '')
      {
	 $attrhtml5 .= ' pattern="' . $this->attrhtml5['pattern'] . '"';
      }
      if ($this->attrhtml5['autocomplete'] !== 'off')
      {
	 $attrhtml5 .= ' autocomplete="' . $this->attrhtml5['autocomplete']. '"';
      }
      return $attrhtml5;    
   }

   private function StringFunctionsJavaScript()
   {
      $eventosscript = '';

      if ($this->onblur !== '')
      {
	 $eventosscript .= "onblur=\"$this->onblur\"";
      }
      if ($this->onchange !== '')
      {
	 $eventosscript .= "onchange=\"$this->onchange\"";
      }
      if ($this->onfocus !== '')
      {
	 $eventosscript .= "onfocus=\"$this->onfocus\"";
      }
      if ($this->onselect !== '')
      {
	 $eventosscript .= "onselect=\"$this->onselect\"";
      }

      return $eventosscript;
   }

}
