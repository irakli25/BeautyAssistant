<?php
class Staff {

    
  protected $id;
  protected $db ;
  protected $name;
  protected $surname;
  protected $email;


  protected $isuser;


  function __construct ($db,$uid){
        $this->db = $db;
        $res =  $db->getResults("SELECT `id` FROM `users` WHERE `uid` = '$uid' LIMIT 1");
        $this->id = $res[0]['id'];

        $this->isuser = ($this->id == $_SESSION['USER'] ? true : false);
      


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
                   
                </div>
            </div>
            <div id="tabs">
                <ul>
                    <li><a href="#id1">პროფილი</a></li>
                    <li><a href="#id2">ჩემს შესახებ</a></li>
                    <li><a href="#id3">პორტფოლიო</a></li>
                    <li><a href="#id4">ისტორია</a></li>
                </ul>
            <div id="id1">
                        <div class="info-grid">
                                <div>
                                    <div class="row-wrapper">
                                        <span>სახელი</span> 
                                        <input type="text" value="'.$this->name.'" /> 
                                        '.( $this->isuser ? 
                                                  ' <button class="edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                        
                                    </div>
                                    <div class="row-wrapper">
                                        <span>გვარი</span> 
                                        <input type="text" value="'.$this->surname.'" />
                                        '.( $this->isuser ? 
                                                  ' <button class="edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>ელფოსტა</span>  
                                        <input type="text" value="'.$this->email.'" />
                                        '.( $this->isuser ? 
                                                  ' <button class="edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input type="text" value="" />
                                        '.( $this->isuser ? 
                                                  ' <button class="edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
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
                                <div class="districts-grid">
                                    <div><span>უბნები</span> </div>
                                    <div class=" districts">
                                            
                                            '.( $this->isuser ? 
                                                    ' <div>
                                                            <select id="district_multi" ></select>
                                                        </div>' 
                                                        
                                                        : ''
                                            
                                            ).'
                                    </div>
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
                <div class="portfolio_wrap">
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-pic"></div>
                    <div class="portfolio-add" ><i class="fa fa-plus-circle"></i></div>
                </div>
            </div>
            <!-- END id3 -->

            <div id="id4">
            
            </div>
            <!-- END id4 -->
        </div>
        
        
        ';
  }

}

?>