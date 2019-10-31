<?php 



class Client {

  protected $id;
  protected $db ;
  protected $name;
  protected $surname;
  protected $email;

  function __construct ($db){
      $this->id = $_SESSION['USER'];
      $this->db = $db;

      $res =  $db->getResults("SELECT `name`, `surname`, `email` FROM `users` WHERE id = $this->id LIMIT 1");
      $arr = $res[0];
      $this->name = $arr['name'];
      $this->surname = $arr['surname'];
      $this->email   = $arr['email'];


  }

  function getPage(){
        return '
        <div>
            <div class="user-pic-wrap">
                <div class="user-pic"></div>
            </div>
<div class="info-grid">
        <div>
            <div class="row-wrapper">
                <span>სახელი</span> 
                <input type="text" value="'.$this->name.'" /> 
                <button class="edit">
                    <i class="fas fa-pencil-alt"></i>
                </button> 
                <button class="done">
                    <i class="fas fa-check"></i>
                </button>
                
            </div>
            <div class="row-wrapper">
                <span>გვარი</span> 
                <input type="text" value="'.$this->surname.'" />
                <button class="edit">
                    <i class="fas fa-pencil-alt"></i>
                </button> 
                <button class="done">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            <div class="row-wrapper">
                <span>ელფოსტა</span>  
                <input type="text" value="'.$this->email.'" />
                <button class="edit">
                    <i class="fas fa-pencil-alt"></i>
                </button> 
                <button class="done">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div> 
        <div class="phone-grid">
                
                <div class="phone-grid-in">
                    <span>ტელეფონი</span> <input type="text" value="'.$this->email.'" />
                    <button class="add">
                        <i class="fas fa-plus"></i>
                    </button> 
                    
                </div>
                <div class="phone-grid-in">
                    <span></span><input type="text" value="'.$this->email.'" />
                    <button class="add">
                        <i class="fas fa-plus"></i>
                    </button> 
                </div>
                <div class="phone-grid-in">
                    <span></span><input type="text" value="'.$this->email.'" />
                    <button class="add">
                        <i class="fas fa-plus"></i>
                    </button> 
                </div>
        </div>
</div>

        </div>
        
        ';
  }

}


?>