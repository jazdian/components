<?php

/**
 * Description of ComboBox
 *
 * @author gesfor.rgonzalez
 */
class ComboBox
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
    private $itemselected = '0';
    private $onblur = '';
    private $onchange = '';
    private $onfocus = '';
    private $onselect = '';
    private $onclick = '';
    private $onsubmit = '';
    private $disabled = false;
    private $addrowfirst = array();
    private $addrowend = array();
    private $wraphtmlcode = '';
    private $bootstrap_form = false;
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

    public function SetItemSelected($itemselected_)
    {
        $this->itemselected = $itemselected_;
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

    public function SetAddRowFirst($addrowfirstval_, $addrowfirst_)
    {
        $this->addrowfirst =array($addrowfirstval_,  $addrowfirst_);
    }

    public function SetAddRowEnd($addrowendval_, $addrowend_)
    {
        $this->addrowend = array($addrowendval_,  $addrowend_);
    }

    public function SetWrapHtmlCode($wraphtmlcode_)
    {
        if ($wraphtmlcode_ !== '') {
            $this->wraphtmlcode = $wraphtmlcode_;
        }
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

    public function CreateComboBox()
    {
        $disabled = '';
        if ($this->disabled === true) {
            $disabled = 'disabled';
        }

        $class = ($this->class === '') ? '' : 'class="' . $this->class . '"';
        $id = ($this->id === '') ? '' : 'id="' . $this->id . '"';
        $style = ($this->style === '') ? '' : 'style="' . $this->style . '"';
        $name = ($this->name === '') ? '' : 'name="' . $this->name . '"';
        $script = $this->StringFunctionsJavaScript();

        $IniSelect = <<<SEL
<select $id $class $style $name $disabled $script> 
SEL;

        $Options = '';
        $valfield = $this->datavaluefield;
        $textfield = $this->datatextfield;

        if (!empty($this->addrowfirst)) {
            $Options = '<option value="'.$this->addrowfirst[0].'">' . $this->addrowfirst[1] . '</option>';
        }

        $msgErr = $this->ValidateObject($this->datasource);
        if($msgErr !== '')
        {
            $Options = '<option selected value="0">.: Error :.</option>';
            $Options .= '<option value="1">.: ' . $msgErr . ' :.</option>';
            $FinSelect = '</select>';
            return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);
        }

        if ($this->datasource !== null) {

            if( isset($this->datasource[0]->code) )
            {
                $Options = '<option selected value="0">.: 0 rows matched :.</option>';
                $FinSelect = '</select>';
                return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);                
            }
            foreach ($this->datasource as $key => $value) {
                if ($this->itemselected == $value->$valfield) {
                    $Options = $Options . '<option selected value="' . $value->$valfield . '">' . $value->$textfield . '</option>';
                } else {
                    $Options = $Options . '<option value="' . $value->$valfield . '">' . $value->$textfield . '</option>';
                }
            }

            if(!empty($this->addrowend))
            {
                $Options = $Options . '<option value="'.$this->addrowend[0].'">' . $this->addrowend[1] . '</option>';
            }

            $FinSelect = '</select>';
            return $this->WrapInputInHtml($IniSelect . $Options . $FinSelect);
        } else {
            $Options = '<option selected value="0">.: Connection or DataBase error :.</option>';
            $FinSelect = '</select>';
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

    private function StrPull($string_)
    {
        $pos1 = strpos($string_, "\"");
        $newstr = substr($string_, $pos1 + 1);
        $pos2 = strpos($newstr, "\"");
        $newstr2 = substr($string_, $pos1 + 1, $pos2);
        return $newstr2;
    }

    private function StringFunctionsJavaScript()
    {
        $eventosscript = '';

        if ($this->onblur !== '') {
            $eventosscript .= "onblur=\"$this->onblur\"";
        }
        if ($this->onchange !== '') {
            $eventosscript .= "onchange=\"$this->onchange\"";
        }
        if ($this->onfocus !== '') {
            $eventosscript .= "onfocus=\"$this->onfocus\"";
        }
        if ($this->onselect !== '') {
            $eventosscript .= "onselect=\"$this->onselect\"";
        }
        if ($this->onclick !== '') {
            $eventosscript .= "onclick=\"$this->onclick\"";
        }
        if ($this->onsubmit !== '') {
            $eventosscript .= "onsubmit=\"$this->onsubmit\"";
        }

        return $eventosscript;
    }



}
