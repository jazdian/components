<?php


/**
 * Description of WrapControl
 *
 * @author gesfor.rgonzalez
 */
class WrapControl
{
   
   private $htmlcode = '';

   public function SetHtmltoCode($htmlcode_)
   {
      if ($htmlcode_ !== '')
      {
	 $this->htmlcode = $htmlcode_; 
      }
   } 
      
   public function CreateWrapControl($search, $replace)
   {
      if ($this->htmlcode !== '')
      {
	      str_replace($search, $replace, $this->htmlcode);
      }
      return $this->htmlcode;
   }
   //put your code here
}
