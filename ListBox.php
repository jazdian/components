<?php

/**
 * Description of ListBox
 *
 * @author Rene Gonzalez Campos
 */
class ListBox
{
    //Propiedades
    
    private $id = '';
    private $name = '';      
    private $style = '';
    private $class = '';
    private $datavaluefield = '';
    private $datatextfield = '';
    private $datasource = array();
    private $selected = false;
    private $valselected = '0';
    private $onblur = '';
    private $onchange = '';    
    private $onfocus = '';    
    private $onselect = '';
    private $onclick = '';    
    private $onsubmit = '';
    private $disabled = false;
    private $wraphtmlcode = '';
    private $labelname = array();
    
    public function SetID($id_)
    {
        $this->id = $id_;
    }
    public function SetName($name_)
    {
        $this->name = $name_;
    }     
    public function SetStyle($style_)
    {
        $this->style = $style_;
    }
    public function SetClass($class_)
    {
        $this->class = $class_;
    }
    public function SetDataValueField($valsource_)
    {
        $this->datavaluefield = $valsource_;
    }
    public function SetDataTextField($textsource_)
    {
        $this->datatextfield = $textsource_;
    }
    public function SetDataSource($arraysource_)
    {
        $this->datasource = $arraysource_;
    }
    public function SetSelected($selected_)
    {
        $this->selected = $selected_;
    }
    public function SetValSelected($valselected_)
    {
        $this->valselected = $valselected_;
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
    public function SetOnClick($onclick_)
    {
        $this->onclick = $onclick_;
    }
    public function SetOnSubmit($onsubmit_)
    {
        $this->onsubmit = $onsubmit_;
    }
    public function SetDisabled($disabled_)
    {
        $this->disabled = $disabled_;
    }    

    public function SetWrapHtmlCode($wraphtmlcode_)
    {
        if ($wraphtmlcode_ !== '') {
            $this->wraphtmlcode = $wraphtmlcode_;
        }
    }

    /**
     * 
     * @param string $labelname_    Texto de la etiqueta
     * @param string $lblclass_     Clase de la etiqueta
     * @return self
     */    
    public function SetLabelName($labelname_, $lblclass_)
    {
        $this->labelname = array($labelname_,  $lblclass_);
    }

    /**
     * Set the value of bootstrap_form
     * @param bool $bootstrap_form  Default value is false. Si el valor es true se aplica el estilo de boostrap de un form-control
     * 
     * 
     * @return  self
     */ 
    public function SetBootstrapForm($bootstrap_form)
    {
        $this->bootstrap_form = $bootstrap_form;

        return $this;
    }
    
    public function CreateListBox()
    {
        $disabled = '';
        if($this->disabled === true) { $disabled = 'disabled'; }
	
        $IniSelect = '<select multiple id="'.$this->id.'" class="'.$this->class.'" style="'.$this->style.'" name="'.$this->name.'" '
                . ''.$this->StringFunctionsJavaScript().' '.$disabled.'>';
        
        $Options = '';
        $valfield = $this->datavaluefield;
        $textfield = $this->datatextfield;

        $msgErr = $this->ValidateObject($this->datasource);
        if($msgErr !== '')
        {
            $Options = '<option selected value="0">.: Error :.</option>';
            $Options .= '<option value="1">.: ' . $msgErr . ' :.</option>';
            $FinSelect = '</select>';
            return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);
        }

        if($this->datasource !== null)
        {        
            foreach ($this->datasource as $key => $value)
            {
                if($this->valselected == $value->$valfield)
                {
                    $Options = $Options . '<option selected value="' . $value->$valfield . '">' . $value->$textfield . '</option>';                    
                }
                else
                {
                    $Options = $Options . '<option value="' . $value->$valfield . '">' . $value->$textfield . '</option>';                    
                }
            }

            $FinSelect = '</select>';
            //return $IniSelect . $Options . $FinSelect;
            return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);
        }else
        {
            $Options = '<option selected value="0">.: Connection or DataBase error :.</option>';
            $FinSelect = '</select>';
            //return $IniSelect . $Options . $FinSelect; 
            return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);
        }

        
    }
    
    private function ValidateObject($object)
    {
        try
        {
            if (!isset($object[0])) {
                throw new Exception('DataSource Object is not valid...');
            } else {
                if (!is_object($object[0])) {
                    throw new Exception('DataSource Object is not valid...');
                }
            }
            return '';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function WrapInputInHtml($strcombobox)
    {

        if ($this->wraphtmlcode != '')
        {
            $newhtmlcode = str_replace("_INPUT_", $strcombobox, $this->wraphtmlcode);
            //$newhtmlcode2 = str_replace("_ID_", $this->StrPull($this->id), $newhtmlcode);
            $newhtmlcode2 = str_replace("_ID_", $this->id, $newhtmlcode);
            $newhtmlcode3 = str_replace("_LNAME_", $this->labelname[0], $newhtmlcode2);
            $newhtmlcode4 = str_replace("_LCLASS_", $this->labelname[1], $newhtmlcode3);
            return $newhtmlcode4;            
        } 

        if($this->wraphtmlcode == '' && $this->bootstrap_form == false)
        {
            return $strcombobox;
        }
        else
        {
            $form_group = '  <div class="form-group">
                <label for="'.$this->id.'">'.$this->labelname[0].'</label>
                '.$strcombobox.'
            </div>';
            return $form_group;
        }

    }

    private function StringFunctionsJavaScript()
    {
        $eventosscript = '';
        
        if ($this->onblur !== '') { $eventosscript .= 'onblur="'.$this->onblur.'"'; }
        if ($this->onchange !== '') { $eventosscript .= 'onchange="'.$this->onchange.'"'; }
        if ($this->onfocus !== '') { $eventosscript .= 'onfocus="'.$this->onfocus.'"'; }
        if ($this->onselect !== '') { $eventosscript .= 'onselect="'.$this->onselect.'"'; }
        if ($this->onclick !== '') { $eventosscript .= 'onclick="'.$this->onclick.'"'; }
        if ($this->onsubmit !== '') { $eventosscript .= 'onsubmit="'.$this->onsubmit.'"'; }
        
        return $eventosscript;
    }
    
}
