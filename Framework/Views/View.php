<?php
namespace Project21911226\Framework\Views;


// require_once("Router.php");

use Project21911226\Framework\Router;
class View {

  private $chemin;
  private $tab;

  public function __construct($chemin){
    $this->chemin=$chemin;
    $this->title = null;
    $this->content = null;
  }

  public function setPart($key,$val){
    $this->tab[$key]=$val;
  }

  public function render(){
    ob_start();
      include($this->chemin);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }


}
