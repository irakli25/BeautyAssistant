<?php 



class Client {

  protected $id;
  protected $db ;
  protected $name;
  protected $surname;
  protected $email;
  protected $birthday;
  protected $img;
  protected $about;

  function __construct ($db){
      $this->id = $_SESSION['USER'];
      $this->db = $db;

      $res =  $db->getResults("SELECT `id`,`name`, `surname`, `email`, `birthday`,`img`, about FROM `users` WHERE id = '$this->id' AND `uid` = 'client' LIMIT 1");
      $arr = $res[0];
      $this->id = $arr['id'];
      $this->name = $arr['name'];
      $this->surname = $arr['surname'];
      $this->email   = $arr['email'];
      $this->birthday = $arr['birthday'];
      $this->img       = $arr['img'];
      $this->about       = $arr['about'];

  }

  function getPage(){

      if($this->id != "")  return '
        <div>
            <div class="main-grid">
                <div class="user-pic-wrap">
                    <div class="user-pic" style="background-image:url('.$this->get_img().')"> 
                        <div class="change_user_pic"><i class="fas fa-camera"></i></div> 
                    </div>
                </div>
                <div >
                    <h1>'.$this->name.' '.$this->surname.'</h1>
                    <div class="bautycoin" >
                        <div class="coin"></div>
                        <h4>BeautyCoin : 20 </h4>
                    </div>
                </div>
            </div>




                            <div class="container">
                                                    

                                                        
                            <section class="main">
                            
                                <div id="sb-container" class="sb-container">
                                
                                    <div class ="tab-selector" tab = "id1" >
                                        <span class="sb-icon "><i class="fas fa-home"></i></span>
                                        <h4>პროფილი</h4>
                                    </div>

                                    <div class ="tab-selector" tab = "id2" >
                                        <span class="sb-icon "><i class="far fa-user"></i></span>
                                        <h4>შენ შესახებ</h4>
                                    </div>



                                    <div class ="tab-selector" tab = "id3" >
                                        <span class="sb-icon "><i class="fas fa-history"></i></span>
                                        <h4>ისტორია</h4>
                                    </div>
                                    
                                    <div class ="tab-selector" tab = "id1" >
                                        <h4><span>Profile</span></h4>
                                        <span class="sb-toggle">დააჭირე</span>
                                        <h5><span>გადაშალე &hearts; </span></h5>											
                                    </div>
                                    
                                    
                                </div><!-- sb-container -->
                                
                            </section>
                            
                        </div>








            <div id="tabs">
                
            <div id="id1" class="tab">
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
                                    '.$this->get_phones().'
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

            <div id="id2" class="tab">
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
            <div id="id3" class="tab">
            
            </div>
            <!-- END id3 -->
        </div>
        
        <input id="uploader" type="file" name="up_pic" />
        <input id="uploader_user_pic" type="file" name="uploader_user_pic" />
        <input type="hidden" id="user_id" value="'.$this->id.'" />


        ';
  }


  function get_phones(){
    $html = "";
    $mysql = $this->db;
    $query = "SELECT `id`,`phone` from `phones` WHERE active = 1 AND `user_id`=" . $this->id;
    $res = $mysql->query($query);
    $i=0;
    while($result = $res->fetch_assoc()){
        $html.='<div class="phone-grid-in">
                    <input type="text" value="'.$result['phone'].'" readonly/>
                    
                        <button class="delete" title="წაშლა" row_id = "'.$result['id'].'" >
                            <i class="fas fa-minus"></i>
                        </button> 
                </div>';
        $i++;
    }
    if($i<3 ){
        $html .= '<div class="phone-grid-in">
                    <input type="text" value="" maxlength="9"/>
                    <button class="add" title="დამატება">
                        <i class="fas fa-plus"></i>
                    </button> 
                </div>';
    }

    return $html;
  }

  function get_img(){
    $mysql = $this->db;
    $query = "SELECT `rand_name` FROM `file` WHERE `id` = '$this->img'";
    $img = $mysql->getResult($query);
      return 'server/uploads/'.$img;
}

}
   

?>