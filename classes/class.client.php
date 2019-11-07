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
            <div class="main-grid">
                <div class="user-pic-wrap">
                    <div class="user-pic"></div>
                </div>
                <div >
                    <h1>'.$this->name.' '.$this->surname.'</h1>
                    <div class="bautycoin" >
                        <div class="coin"></div>
                        <h4>BeautyCoin : 20 </h4>
                    </div>
                </div>
            </div>
            <div id="tabs">
                <ul>
                    <li><a href="#id1">პროფილი</a></li>
                    <li><a href="#id2">შენს შესახებ</a></li>
                    <li><a href="#id3">ისტორია</a></li>
                </ul>
            <div id="id1">
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
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input type="text" value="" />
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

                        <div class="address-grid">
                                <div class="address-in">
                                    <label for="district" style="margin-top:12px" >უბანი</label>
                                    <span>
                                        <select id="district" ></select>
                                    </span>
                                
                                </div>
                                <div class="address-in" >
                                    <label for="street" style="margin-top:12px" >ქუჩა</label>
                                    <span>
                                        <select id="street" ></select>
                                    </span>
                                
                                </div>
                                <div class="address-in" >
                                <div><label for="street" style="margin-top:12px" >დააზუსტე მისამართი</label></div>
                                    <kendo-textbox-container floatingLabel="corect_address">
                                            <input id="corect_address" kendoTextBox />
                                    </kendo-textbox-container>
                                
                                </div>
                        
                        
                        </div>

            </div>
            <!-- END id1 -->

            <div id="id2">
                <div class="per-info">
                    <label for="hear" style="margin-top:12px" >თმის ტიპი</label>
                    <span>
                        <select id="hear" ></select>
                    </span>
                
                </div>
                <div class="per-info">
                    <label for="skin" style="margin-top:12px" >კანის ტიპი</label>
                    <span>
                        <select id="skin" ></select>
                    </span>
                
                </div>

                <div>
                    <kendo-textbox-container  floatingLabel="First name" >
                        <textarea id="add_info" placeholder="დაამატე ინფორმაცია" kendoTextArea></textarea>
                    </kendo-textbox-container>
                
                </div>

            
            </div >
            <!-- END id2 -->
            <div id="id3">
            
            </div>
            <!-- END id3 -->
        </div>
        
        
        ';
  }

}
   

?>