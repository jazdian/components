<?php


/**
 * Description of Button
 *
 * @author gesfor.rgonzalez
 */
class Button
{
   
   private $id		= '';
   private $class	= '';
   private $style	= '';
   private $type	= '';
   private $name	= '';
   private $text	= '';
   private $image	= '';
   private $attrib	= '';
   private $onclick	= '';
   private $param	= '';

   public function SetID($id_)
   {
      if ($id_ !== '')
      {
	 $this->id = ' id="' . $id_ . '"';
      }
   }
   public function SetClass($class_)
   {
      if ($class_ !== '')
      {
	 $this->class = ' class="' . $class_ . '"';
      }
   }
   public function SetStyle($style_)
   {
      if ($style_ !== '')
      {
	 $this->style = ' style="' . $style_ . '"';
      }
   }
   public function SetType($type_)
   {
      if ($type_ !== '')
      {
	 $this->type = ' type="' . $type_ . '"';
      }
   }
   public function SetName($name_)
   {
      if ($name_ !== '')
      {
	 $this->name = ' name="' . $name_ . '"';
      }
   }
   public function SetText($text_)
   {
      if ($text_ !== '')
      {
	 $this->text = '' . $text_ . '';
      }
   }
   public function SetImage($image_)
   {
      if ($image_ !== '')
      {
	 $this->image = '<img src="' . $image_ . '">';
      }
   }
   public function SetAttrib($attrib_)
   {
      if ($attrib_ !== '')
      {
	 $this->attrib = ' ' . $attrib_ . '';
      }
   }
   public function SetOnclick($onclick_)
   {
      if ($onclick_ !== '')
      {
	 $this->onclick = ' onclick="' . $onclick_ . '"';
      }
   }
   public function SetParam($param_)
   {
      if ($param_ !== '')
      {
	 $this->param = ' ' . $param_ . '';
      }
   }
   
   public function CreateButton()
   {
      $strbtn = <<<EOF
<button $this->type$this->id$this->name$this->class$this->style$this->attrib$this->onclick >
$this->image$this->text
</button>
EOF;
      return $strbtn;
   }   
   
}
