<?php 



class Client {

  protected $id;
  protected $db ;
  protected $name;
  protected $surname;
  protected $email;
  protected $birthday;

  function __construct ($db){
      $this->id = $_SESSION['USER'];
      $this->db = $db;

      $res =  $db->getResults("SELECT `name`, `surname`, `email`, `birthday` FROM `users` WHERE id = '$this->id' LIMIT 1");
      $arr = $res[0];
      $this->name = $arr['name'];
      $this->surname = $arr['surname'];
      $this->email   = $arr['email'];
      $this->birthday = $arr['birthday'];

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
                                        <input id="name" type="text" value="'.$this->name.'" readonly/> 
                                        <button class="edit" target="name"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> 
                                        <button class="done" target="name"   title="შენახვა">
                                            <i class="fas fa-check"></i>
                                        </button> 
                                        
                                    </div>
                                    <div class="row-wrapper">
                                        <span>გვარი</span> 
                                        <input id="surname" type="text" value="'.$this->surname.'" readonly/>
                                        <button class="edit" target="surname"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> 
                                        <button class="done" target="surname"   title="შენახვა">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                    <div class="row-wrapper">
                                        <span>ელფოსტა</span>  
                                        <input id="email" type="text" value="'.$this->email.'" readonly/>
                                        <button class="edit" target="email"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> 
                                        <button class="done" target="email"    title="შენახვა">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input id="birthday" type="text" value="" class="datepicker"  readonly/>
                                        <input type="hidden" id="hidden_birth" value="'.$this->birthday.'" />
                                        <button class="edit" target="birthday"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> 
                                        <button class="done" target="birthday"   title="შენახვა">
                                            <i class="fas fa-check"></i>
                                        </button> 
                                    </div>
                                </div> 
                                <div class="phone-grid">
                                <span>ტელეფონი</span>
                                        <div class="phone-grid-in">
                                             <input type="text" value="'.$this->email.'" />
                                            <button class="add">
                                                <i class="fas fa-plus"></i>
                                            </button> 
                                            
                                        </div>
                                        <div class="phone-grid-in">
                                            <input type="text" value="'.$this->email.'" />
                                            <button class="add">
                                                <i class="fas fa-plus"></i>
                                            </button> 
                                        </div>
                                        <div class="phone-grid-in">
                                            <input type="text" value="'.$this->email.'" />
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