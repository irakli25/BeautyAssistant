<?php
class Staff {

    
  protected $id;
  protected $db ;
  protected $name;
  protected $surname;
  protected $email;
  protected $birthday;
  protected $img;
  protected $about;


  protected $isuser;


  function __construct ($db,$uid){
        $this->db = $db;
        $res =  $db->getResults("SELECT `id` FROM `users` WHERE `uid` = '$uid' LIMIT 1");
        $this->id = $res[0]['id'];

        $this->isuser = ($this->id == $_SESSION['USER'] ? true : false);
      


      $res =  $db->getResults("SELECT `name`, `surname`, `email`, `birthday`,`img`, about FROM `users` WHERE id = $this->id LIMIT 1");
      $arr = $res[0];
      $this->name      = $arr['name'];
      $this->surname   = $arr['surname'];
      $this->email     = $arr['email'];
      $this->birthday  = $arr['birthday'];
      $this->img       = $arr['img'];
      $this->about       = $arr['about'];



  }

  function getPage(){
        return '

        <div id="order_window" class="modal">

        <div class="modal-content animate" >
          <div class="imgcontainer">
            <span  id ="close_order_window" class="close" title="Close Modal">&times;</span>
            
          </div>

          <div class="container">
            <label><b>თქვენი შეკვეთა</b></label>
            <p>ასისტენტი : <b id="get_assistant"  user_id="'.$this->id.'" >'.$this->name.' '.$this->surname.'</b> </p> 
            <div class="flex"><p> მომსახურება : </p> <p class="flex" style="margin-left: 10px;"  id="get_service"></p></div>
            <div class="flex"><p> ფასი : </p> <p class="flex" style="margin-left: 10px;" id="get_price"></p></div>
                        <div class="address-grid" style="grid-auto-flow: row"> 
                            <div class="address-in">
                                <label for="district" style="margin-top:12px" >უბანი</label>
                                <span>
                                    <select id="order_district" ></select>
                                </span>
                            
                            </div>
                            <div class="address-in" >
                                <label for="street" style="margin-top:12px" >ქუჩა</label>
                                <span>
                                    <select id="order_street" ></select>
                                </span>
                            
                            </div>
                            <div class="address-in" >
                                <div>
                                    <label for="street" style="margin-top:12px" >დააზუსტე მისამართი</label>
                                </div>
                                    <kendo-textbox-container floatingLabel="corect_address">
                                            <input class="register_in" style="width: 600px;" id="order_corect_address" kendoTextBox />
                                    </kendo-textbox-container>
                            
                            </div>
                        
                        
                        </div>
           

                        <p><b>გთხოვთ გადაამოწმოთ შეკვეთის დეტალები, შეკვეთის შემთხვევაში მას ვერ გააუქმებთ !</b></p>

                        <button id="order_done_button" form="none" class="register_button" type="submit" >შეკვეთა</button><br/>

          </div>

          <div class="container" style="background-color:#f1f1f1">


          </div>
        </div>
      </div>


        <div>
        <div class="calculator">
            <label>მომსახურება</label>
            <div>
                <select id="calc_experience" ></select>
            </div>
            <label>უბანი</label>
            <div>
                <select id="calc_district" ></select>
            </div>
            
            <div class="calc_price">
                <label>ფასი :</label>
                <span id="calc_price" class="flex"></span>
            </div>
            <div>

                <button id="order_button">შეკვეთა</button>
            </div>

        </div>
            <div class="main-grid">
                <div class="user-pic-wrap">
                    <div class="user-pic" style="background-image:url('.$this->get_img().')"> '.( $this->isuser ? ' 
                        <div class="change_user_pic"><i class="fas fa-camera"></i></div> ' : '' ) . ' 
                    </div>
                    
                </div>
                <div >
                    <h1>'.$this->name.' '.$this->surname.'</h1>
                   
                </div>
            </div>

            <div id="tabs">
            <ul>
                <li><a href="#id1" class="shadow">
                    <div class="tab-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="tab-text">
                        პროფილი
                    </div>
                </a></li>
                <li><a href="#id2" class="shadow">
                <div class="tab-icon">
                        <i class="far fa-user"></i>
                </div>
                    <div class="tab-text">
                        ჩემს შესახებ
                    </div>
                </a></li>
                <li><a href="#id3" class="shadow">
                    <div class="tab-icon">
                            <i class="fas fa-images"></i>
                    </div>
                    <div class="tab-text">
                        პორტფოლიო
                    </div>
                </a></li>
                <li><a href="#id4" class="shadow">
                    <div class="tab-icon">
                            <i class="fas fa-history"></i>
                    </div>
                    <div class="tab-text">
                        ისტორია
                    </div>
                </a></li>
                <li><a href="#id5" class="shadow">
                    <div class="tab-icon">
                            <i class="fas fa-coins"></i>
                    </div>
                    <div class="tab-text">
                        ჩემი ფინანსები
                    </div>
                </a></li>
            </ul>
            <div id="id1" class="tab">
                        <div class="info-grid">
                                <div>
                                    <div class="row-wrapper">
                                        <span>სახელი</span> 
                                        <input id="name" type="text" value="'.$this->name.'" readonly/> 
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="name"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done" target="name"   title="შენახვა">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                        
                                    </div>
                                    <div class="row-wrapper">
                                        <span>გვარი</span> 
                                        <input id="surname" type="text" value="'.$this->surname.'" readonly/>
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="surname"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done" target="surname"   title="შენახვა">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>ელფოსტა</span>  
                                        <input id="email" type="text" value="'.$this->email.'" readonly/>
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="email"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done" target="email"    title="შენახვა">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input id="birthday" type="text" value="" class="datepicker"  readonly/>
                                        <input type="hidden" id="hidden_birth" value="'.$this->birthday.'" />
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="birthday"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button> 
                                                    <button class="done" target="birthday"   title="შენახვა">
                                                        <i class="fas fa-check"></i>
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    
                                </div> 
                                <div class="phone-grid">
                                <span>ტელეფონი</span>
                                        '.$this->get_phones().'
                                </div>
                                <div class="districts-grid">
                                    <div><span>უბნები</span> </div>
                                    <div class=" districts">
                                            
                                            '.( $this->isuser ? 
                                                    ' <div>
                                                            <select id="district_multi" ></select>
                                                        </div>' 
                                                        
                                                        : $this->get_district()
                                            
                                            ).'
                                    </div>
                                </div>
                        </div>

                        

            </div>
            <!-- END id1 -->

            <div id="id2" class="tab">
                <div class="staff-info">
                    <label for="experience" style="margin-top:12px" >გამოცდილება</label>
                    
                    '.( $this->isuser ? 
                    ' <span>
                            <select id="experience" ></select>
                        </span>' 
                        
                        : $this->get_experience()
            
            ).'
                
                </div>
                

                <div>
                    <kendo-textbox-container  floatingLabel="First name" >
                        <textarea id="about" placeholder="დაამატე ინფორმაცია"  kendoTextArea readonly >'.$this->about.'</textarea>
                        <button class="edit" target="about"   title="ჩასწორება">
                            <i class="fas fa-pencil-alt"></i>
                        </button> 
                        <button class="done" target="about"   title="შენახვა">
                            <i class="fas fa-check"></i>
                        </button> 
                    </kendo-textbox-container>
                    
                </div>

            
            </div >
            <!-- END id2 -->
            <div id="id3" class="tab">
                <div class="portfolio_wrap">
                    
                    '.$this->get_portfolio().
                    ( $this->isuser ?
                    '<div id ="up_pic_port" class="portfolio-add" ><i class="fa fa-plus-circle"></i></div>' : ''
                    ).'
                </div>
            </div>
            <!-- END id3 -->

            <div id="id4" class="tab">
            
            </div>
            <!-- END id4 -->
            <div id="id5" class="tab">
                '.$this->get_finance().'
            </div>
            <!-- END id5 -->
        </div>
        <input id="uploader" type="file" name="up_pic" />
        <input id="uploader_user_pic" type="file" name="uploader_user_pic" />
        <input type="hidden" id="profile_id" value="'.$this->id.'" />
        
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
                    '.( $this->isuser ? '
                        <button class="delete" title="წაშლა" row_id = "'.$result['id'].'" >
                            <i class="fas fa-minus"></i>
                        </button> ' : '' ).
                '</div>';
        $i++;
    }
    if($i<3 && $this->isuser ){
        $html .= '<div class="phone-grid-in">
                    <input type="text" value="" maxlength="9"/>
                    <button class="add" title="დამატება">
                        <i class="fas fa-plus"></i>
                    </button> 
                </div>';
    }

    return $html;
  }

  function get_portfolio() {
    $html = "";
    $mysql = $this->db;
    $query = "SELECT `file`.`rand_name`  
                FROM `portfolio` 
                JOIN `file` ON `portfolio`.`file_id` = `file`.`id`
                WHERE `portfolio`.`active` = 1 AND `portfolio`.`user_id`=" . $this->id;
    $res = $mysql->query($query);
    while($result = $res->fetch_assoc()){
        $html .= '<div class="portfolio-pic" style="background-image:url(\'server/uploads/'.$result['rand_name'].'\')"></div>';
    }
    return $html;
  }

  function get_district() {
    $html = "<div>";
    $mysql = $this->db;
    $query = "SELECT  `district`.`name` 
                    FROM user_district
                    JOIN district On district.id = user_district.district_id
                    WHERE user_district.user_id = $this->id";
    $res = $mysql->query($query);
    while($result = $res->fetch_assoc()){
        $html .= "<span> ".$result['name'].", </span>";
    }
    $html .="</div>";
    return $html;
  }

  function get_experience() {
    $html = "<div>";
    $mysql = $this->db;
    $query = "SELECT  `experience`.`name` 
                    FROM user_experience
                    JOIN experience On experience.id = user_experience.experience_id
                    WHERE user_experience.user_id = $this->id";
    $res = $mysql->query($query);
    while($result = $res->fetch_assoc()){
        $html .= "<span> ".$result['name'].", </span>";
    }
    $html .="</div>";
    return $html;
  }

  function get_img(){
      $mysql = $this->db;
      $query = "SELECT `rand_name` FROM `file` WHERE `id` = '$this->img'";
      $img = $mysql->getResult($query);
        return 'server/uploads/'.$img;
  }

  function get_finance() {
    $html = "<div class='finance'>";
    $mysql = $this->db;
    $query = "SELECT  users.id , experience.`name`, experience.`id` AS `ex_id`, finance.price

                FROM users 
                JOIN user_experience ON user_experience.user_id = users.id
                JOIN experience ON experience.id = user_experience.experience_id
                JOIN finance ON finance.user_id = users.id AND experience.id = finance.experience_id
                WHERE users.id = $this->id";

    $res = $mysql->query($query);

    while($result = $res->fetch_assoc()){
        $html .= "<div class='finance_input'> <label>".$result['name']."</label><input class='f_in' id='".$result['ex_id']."' type='number' value='".$result['price']."' /> </div>";
    }
    $html .="</div><div  class='finance_button'><button id='save_finance' >შენახვა</button></div>";
    return $html;
  }

}

?>