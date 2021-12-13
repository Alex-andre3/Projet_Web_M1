<?php
namespace Src\MiniFramworkProject\Framework\Views;


// require_once("Router.php");

use Src\MiniFramworkProject\Framework\Router;
class View {

  private $chemin;//inutile
  private $tab;

  public function __construct($chemin){
    $this->chemin=$chemin;//inutile
    //$this->title = null;
    //$this->content = null;
  }

  public function setPart($key,$val){
    $this->tab[$key]=$val;
  }

  public function render(){
    /*ob_start();
      include($this->chemin);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;*/
    return $this->tab;
  }
  
/**
 * Sans passer par la class View ni par Response à la fin de chaque fonction dans le controlleur 
 * on appelle la fonction Twig->render() et on affiche le template correspondant -Chaque page aura un template-(on peut passer les objets directement
 * et le décortiqué dans le template twig).
 * Dans ce càs le FrontController n'aura qu'un seul role c'est d'éxécuter la bonne action.
 * Pb: les headers de la page ne seront pas envoyer (sendHeader -- class Response)
 */

}
