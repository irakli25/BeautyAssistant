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
  protected $status;


  protected $isuser;


  function __construct ($db,$uid){
        $this->db = $db;
        $res =  $db->getResults("SELECT `id` FROM `users` WHERE `uid` = '$uid' LIMIT 1");
        $this->id = $res[0]['id'];

        $this->isuser = ($this->id == $_SESSION['USER'] ? true : false);
      


      $res =  $db->getResults("SELECT `name`, `surname`, `email`, `birthday`,`img`, about, `status` FROM `users` WHERE id = $this->id LIMIT 1");
      $arr = $res[0];
      $this->name      = $arr['name'];
      $this->surname   = $arr['surname'];
      $this->email     = $arr['email'];
      $this->birthday  = $arr['birthday'];
      $this->img       = $arr['img'];
      $this->about       = $arr['about'];
      $this->status    = $arr['status'];



  }

  function getPage(){
        return '

        <div id="order_window" class="modal">

        <div class="modal-content animate" >
          <div class="imgcontainer">
            <span  id ="close_order_window" class="close" title="Close Modal">&times;</span>
            
          </div>

          <div class="windowContainer">
            <div><b>თქვენი შეკვეთა</b></div>
            <br>
            <p>ასისტენტი : <b id="get_assistant"  user_id="'.$this->id.'" >'.$this->name.' '.$this->surname.'</b> </p> <br>
            <div class="flex"><p> მომსახურება : </p> <p class="flex" style="margin-left: 10px;"  id="get_service"></p></div><br>
            <div class="flex"><p> ფასი : </p> <p class="flex" style="margin-left: 10px;" id="get_price"></p></div><br>
                        <div class="address-grid" > 
                            <div class="address-in">
                                <label for="district" style="margin-top:12px" >უბანი</label>
                                    <select id="order_district" ></select>
                            </div>
                            <div class="address-in" >
                                <label for="street" style="margin-top:12px" >ქუჩა</label>
                                    <select id="order_street" ></select>
                            </div>
                            <div class="address-in" >
                                <div>
                                    <label for="street" style="margin-top:12px" >დააზუსტე მისამართი</label>
                                </div>
                                   
                                            <input class="register_in"  id="order_corect_address"  />
                                   
                            
                            </div>

                            <div class="address-in" >
                                <div>
                                    <label for="street" style="margin-top:12px" >მოსვლის დრო</label>
                                </div>
                                   
                                            <input type="text" class="register_in datetime"  id="order_time"  />
                                   
                            
                            </div>
                        
                        
                        </div>
           
                        <br>
                        <p><b>გთხოვთ გადაამოწმოთ შეკვეთის დეტალები, შეკვეთის შემთხვევაში მას ვერ გააუქმებთ !</b></p>
                        <br>
                        <button id="order_done_button" form="none" class="register_button" type="submit" >შეკვეთა</button><br/>

          </div>

          <div class="windowContainer" style="background-color:#f1f1f1">


          </div>
        </div>
      </div>


      <div id="history_window" class="modal">

        <div class="modal-content animate" >
            <div class="imgcontainer">
                <span  id ="close_history_window" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="history_container">
                <div class="history_flex" >
                    <label for="history_date"  >დრო</label>
                    <span id="history_date"></span>
                </div>
                <div class="history_flex">
                    <label for="history_name"  >სახელი და გვარი</label>
                    <span id="history_name"></span>
                </div>
                <div class="history_flex">
                    <label for="history_product"  >მომსახურება</label>
                    <span id="history_product"></span>
                </div>

                <div class="history_flex">
                    <label for="history_address"  >მისამართი</label>
                    <span id="history_address"></span>
                </div>
                
                <div class="history_flex">
                    <label for="history_price"  >ფასი</label>
                    <span id="history_price"></span>
                </div>

            </div>


            <div class="windowContainer" style="background-color:#f1f1f1">
                    
            </div>
            </div>
        </div>



        <div class="staff_profile">
        '.( $this->isuser ? '<div id="status_wrapper">
            <span>აქტიური სტატუსი <b id="status_text">'.($this->status ? "ჩართული" : "გამორთული").'</b></span>
            <div id="switcher">
                <input type="checkbox" id="status" '.($this->status ? "checked" : "").'/>
                <label for="status"></label>
            </div>
        </div>' : '').'
        <div class="calculator shadow">
            <label>მომსახურება</label>
            <div>
                <select id="calc_experience" multiple ></select>
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
                <div class="profile_name" >
                    <h1>'.$this->name.' '.$this->surname.'</h1>
                   
                </div>
            </div>

            <div id="tabs">
            <ul>
                <li><a href="#id1" >
                    <div class="tab-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="tab-text">
                        პროფილი
                    </div>
                </a></li>
                <li><a href="#id2" >
                <div class="tab-icon">
                        <i class="far fa-user"></i>
                </div>
                    <div class="tab-text">
                        ჩემს შესახებ
                    </div>
                </a></li>
                <li><a href="#id3" >
                    <div class="tab-icon">
                            <i class="fas fa-images"></i>
                    </div>
                    <div class="tab-text">
                        პორტფოლიო
                    </div>
                </a></li>
                '.( $this->isuser ?
                '<li><a href="#id4" >
                    <div class="tab-icon">
                            <i class="fas fa-history"></i>
                    </div>
                    <div class="tab-text">
                        ისტორია
                    </div>
                </a></li>' : ''
                ).'
                <li><a href="#id5" >
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
                                                        <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                                    </button> 
                                                    <button class="done" target="name"   title="შენახვა">
                                                        <i class="fas fa-check"></i> შენახვა 
                                                    </button> ' : ''
                                        
                                        ).'
                                        
                                    </div>
                                    <div class="row-wrapper">
                                        <span>გვარი</span> 
                                        <input id="surname" type="text" value="'.$this->surname.'" readonly/>
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="surname"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                                    </button> 
                                                    <button class="done" target="surname"   title="შენახვა">
                                                        <i class="fas fa-check"></i> შენახვა 
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>ელფოსტა</span>  
                                        <input id="email" type="text" value="'.$this->email.'" readonly/>
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="email"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                                    </button> 
                                                    <button class="done" target="email"    title="შენახვა">
                                                        <i class="fas fa-check"></i> შენახვა 
                                                    </button> ' : ''
                                        
                                        ).'
                                    </div>
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input id="birthday" class="date" type="text" value="'.$this->birthday.'"  readonly />
                                        <input type="hidden" id="hidden_birth" value="'.$this->birthday.'" />
                                        '.( $this->isuser ? 
                                                  ' <button class="edit" target="birthday"   title="ჩასწორება">
                                                        <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                                    </button> 
                                                    <button class="done" target="birthday"   title="შენახვა">
                                                        <i class="fas fa-check"></i> შენახვა 
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
                                    <div class="districts">
                                            
                                            '.( $this->isuser ? 
                                                    ' <div>
                                                            <select id="district_multi" multiple ></select>
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
                    <label for="experience" style="margin-top:12px 0" >გამოცდილება : </label>
                    
                    '.( $this->isuser ? 
                    ' <span>
                            <select id="experience" multiple ></select>
                        </span>' 
                        
                        : $this->get_experience()
            
            ).'
                
                </div>
                

                <div class="person_info">
                  
                        <textarea id="about" placeholder="დაამატე ინფორმაცია"   readonly >'.$this->about.'</textarea>
                        <button class="edit" target="about"   title="ჩასწორება">
                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                        </button> 
                        <button class="done" target="about"   title="შენახვა">
                            <i class="fas fa-check"></i> შენახვა 
                        </button> 
                 
                    
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
            '.($this->isuser ?
                '<div id="id4" class="tab" >
                '.$this->get_history().'
              </div>' : ''
            )
            
            .'
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
                            <i class="fas fa-minus"></i> წაშლა
                        </button> ' : '' ).
                '</div>';
        $i++;
    }
    if($i<3 && $this->isuser ){
        $html .= '<div class="phone-grid-in">
                    <input type="text" value="" maxlength="9"/>
                    <button class="add" title="დამატება">
                        <i class="fas fa-plus"></i> დამატება
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
    $query = "SELECT  GROUP_CONCAT(`district`.`name` SEPARATOR ', ') AS `name` 
                    FROM user_district
                    JOIN district On district.id = user_district.district_id
                    WHERE user_district.user_id = $this->id";
    $res = $mysql->query($query);
    while($result = $res->fetch_assoc()){
        $html .= $result['name'];
    }
    $html .="</div>";
    return $html;
  }

  function get_experience() {
    $html = "<div class='experiences'>";
    $mysql = $this->db;
    $query = "SELECT  group_concat(`experience`.`name` SEPARATOR ', ') AS `name`
                    FROM user_experience
                    JOIN experience On experience.id = user_experience.experience_id
                    WHERE user_experience.user_id = $this->id";
    $res = $mysql->query($query);
    while($result = $res->fetch_assoc()){
        $html .= $result['name'];
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
                LEFT JOIN finance ON finance.user_id = users.id AND experience.id = finance.experience_id
                WHERE users.id = $this->id";

    $res = $mysql->query($query);

    while($result = $res->fetch_assoc()){
        $html .= "<div class='finance_input'> <label>".$result['name']."</label><input class='f_in shadow' id='".$result['ex_id']."' type='number' value='".$result['price']."' ".( $this->isuser ? '' : 'disabled' ) . "/> </div>";
    }
    $html .="</div><div  class='finance_button'><button id='save_finance' >შენახვა</button></div>";
    return $html;
  }


  function get_history(){
    $mysql = $this->db;

    $query = "SELECT o.id,o.datetime, CONCAT(clients.`name`,' ',clients.surname)  AS client, GROUP_CONCAT(experience.`name` SEPARATOR ', ') AS `exp`

    FROM orders o
    JOIN users AS staff ON o.staff_id = staff.id
    JOIN users AS clients ON o.client_id = clients.id
    JOIN products ON products.order_id = o.id
    JOIN experience ON experience.id = products.experience_id
    WHERE staff.id = $_SESSION[USER]
    group by o.id";

$result = $mysql->query($query);
$html = "";
while($res = $result->fetch_assoc()){
    $html .='<div class="history_item shadow" order_id = "'.$res[id].'">
                <div>დრო : '.$res[datetime].'</div>
                <div>კლიენტი : '.$res[client].'</div>
                <div>მომსახურება : '.$res[exp].'</div>
                
            </div>';
}
if($html == "") $html = "<h2>თქვენ არ გაქვთ გამოძახების ისტორია &#128546;</h2>";
        return '<div class="history_container"> 
                    '.$html.'
                    
        
        </div>';
  }

}

?>