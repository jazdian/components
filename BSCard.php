<?php


/**
 * Description of BSCard
 *
 * @author gesfor.rgonzalez
 */
class BSCard
{

   private $datasource = array();
   
   public function SetDataSource($datasource_)
   {
      $this->datasource = $datasource_;
   }   

   public function CreateBSCard()
   {
      $strCard = '';
      
      foreach ($this->datasource as $key => $value)
      {
	 $srcImg = $value['srcimg'];
	 $cardTitle = $value['cardtitle'];
	 $cardText = $value['cardtext'];
	 $valueButton = $value['valuebutton'];
	 $textButton = $value['textbutton'];

	 $strCard .= <<<EOF
<div class="card" style="width: 20rem;">
   <img class="card-img-top" src="$srcImg" alt="image">
   <div class="card-body">
      <h4 class="card-title">$cardTitle</h4>
      <p class="card-text">$cardText</p>
      <button type="submit" class="btn btn-primary" name="goto" value="$valueButton">$textButton</button>
   </div>
</div>
EOF;
      
      }

      return $strCard;

   }
   
}
