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
      $this->isuser = ($this->id == $_SESSION['USER'] ? true : false);
      
      $res =  $db->getResults("SELECT `id`,`name`, `surname`, `email`, `birthday`,`img`, about, client_correct_address FROM `users` WHERE id = '$this->id' AND `uid` = 'client' LIMIT 1");
      $arr = $res[0];
      $this->id = $arr['id'];
      $this->name = $arr['name'];
      $this->surname = $arr['surname'];
      $this->email   = $arr['email'];
      $this->birthday = $arr['birthday'];
      $this->img       = $arr['img'];
      $this->about       = $arr['about'];
      $this->client_correct_address = $arr['client_correct_address'];


  }

  function getPage(){

      if($this->id != "")  return '


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


        <div class="client_profile">
            <div class="main-grid">
                <div class="user-pic-wrap">
                    <div class="user-pic" style="background-image:url('.$this->get_img().')"> 
                        <div class="change_user_pic"><i class="fas fa-camera"></i></div> 
                    </div>
                </div>
                <div class="profile_name">
                    <h1>'.$this->name.' '.$this->surname.'</h1>
                    <div class="bautycoin" >
                        <div class="coin"></div>
                        <h4>BeautyCoin : 20 </h4>
                    </div>
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
                        შენს შესახებ
                    </div>
                </a></li>
                <li><a href="#id3" >
                    <div class="tab-icon">
                            <i class="fas fa-history"></i>
                    </div>
                    <div class="tab-text">
                        ისტორია
                    </div>
                </a></li>
            </ul>
            <div id="id1" class="tab">
                        <div class="info-grid">
                                <div>
                                    <div class="row-wrapper">
                                        <span>სახელი</span> 
                                        <input id="name" type="text" value="'.$this->name.'" readonly/> 
                                        <button class="edit" target="name"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                        </button> 
                                        <button class="done" target="name"   title="შენახვა">
                                            <i class="fas fa-check"></i> შენახვა 
                                        </button> 
                                        
                                    </div>
                                    <div class="row-wrapper">
                                        <span>გვარი</span> 
                                        <input id="surname" type="text" value="'.$this->surname.'" readonly/>
                                        <button class="edit" target="surname"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                        </button> 
                                        <button class="done" target="surname"   title="შენახვა">
                                            <i class="fas fa-check"></i> შენახვა 
                                        </button>
                                    </div>
                                    <div class="row-wrapper">
                                        <span>ელფოსტა</span>  
                                        <input id="email" type="text" value="'.$this->email.'" readonly/>
                                        <button class="edit" target="email"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                        </button> 
                                        <button class="done" target="email"    title="შენახვა">
                                            <i class="fas fa-check"></i> შენახვა 
                                        </button>
                                    </div>
                                    <div class="row-wrapper">
                                        <span>დაბადების თარიღი</span>  
                                        <input id="birthday" class="date" type="text" value="'.$this->birthday.'"  readonly />
                                        <input type="hidden" id="hidden_birth" value="'.$this->birthday.'" />
                                        <button class="edit" target="birthday"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                        </button> 
                                        <button class="done" target="birthday"   title="შენახვა">
                                            <i class="fas fa-check"></i> შენახვა 
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
                                        <select id="district" ></select>
                                </div>
                                <div class="address-in" >
                                    <label for="street" style="margin-top:12px" >ქუჩა</label>
                                        <select id="street" ></select>
                                </div>
                                
                        
                        
                        </div>

                        <div class="correct_address" >
                                <div><label for="street" style="margin-top:12px" >დააზუსტე მისამართი</label></div> 
                                    <div class="address_wrap">
                                        <input class="register_in_address" id="client_correct_address" value="'.$this->client_correct_address.'" readonly />
                                        <button class="edit" target="client_correct_address"   title="ჩასწორება">
                                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                                        </button> 
                                        <button class="done" target="client_correct_address"   title="შენახვა">
                                            <i class="fas fa-check"></i> შენახვა 
                                        </button> 
                                    </div>
                            
                                
                                </div>

            </div>
            <!-- END id1 -->

            <div id="id2" class="tab">
                <div class="per-info">
                    <label for="hear" style="margin-top:12px" >თმის ტიპი</label>
                    <div class="selectric_wrap">
                        <select id="hear" ></select>
                    </div>
                
                </div>
                <div class="per-info">
                    <label for="skin" style="margin-top:12px" >კანის ტიპი</label>
                    <div class="selectric_wrap">
                        <select id="skin" ></select>
                    </div>
                
                </div>

                <div>
                  
                    <textarea id="about" placeholder="დაამატე ინფორმაცია"   readonly >'.$this->about.'</textarea>
                        <button class="edit fullWidth" target="about"   title="ჩასწორება">
                            <i class="fas fa-pencil-alt"></i> ჩასწორება 
                        </button> 
                        <button class="done fullWidth" target="about"   title="შენახვა">
                            <i class="fas fa-check"></i> შენახვა 
                        </button> 
                  
                
                </div>

            
            </div >
            <!-- END id2 -->
            
            '.($this->isuser ?
                '<div id="id3" class="tab">
                '.$this->get_history().'
              </div>' : ''
            )
            
            .'
            
            <!-- END id3 -->
        </div>
        <div class="modal" id="rating_modal">
        
            <div class="rating_wrapper">
            <div class="imgcontainer">
              <span  id ="close_rating_window"  title="Close Modal">&times;</span>
          </div>
                <p>შეაფასეთ ასისტენტის მომსახურება</p>
                <div class="rating">
                    <input type="radio"  value="5"  /><label  title="5"></label>
                    <input type="radio"  value="4"  /><label  title="4"></label>
                    <input type="radio"  value="3"  /><label  title="3"></label>
                    <input type="radio"  value="2"  /><label  title="2"></label>
                    <input type="radio"  value="1"  /><label  title="1"></label>
                </div>
            </div>
        <div>

        <input type="hidden" id="rating_user_id" value="'.$this->id.'" />
        <input type="hidden" id="rating_order_id" value="" />

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
                            <i class="fas fa-minus"></i> წაშლა
                        </button> 
                </div>';
        $i++;
    }
    if($i<3 ){
        $html .= '<div class="phone-grid-in">
                    <input type="text" value="" maxlength="9"/>
                    <button class="add" title="დამატება">
                        <i class="fas fa-plus"></i> დამატება
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



function get_history(){
    $mysql = $this->db;

    $query = "SELECT o.id,o.datetime, CONCAT(staff.`name`,' ',staff.surname)  AS staff, GROUP_CONCAT(experience.`name` SEPARATOR ', ') AS `exp`,
    rate
    FROM orders o
    JOIN users AS staff ON o.staff_id = staff.id
    JOIN users AS clients ON o.client_id = clients.id
    JOIN products ON products.order_id = o.id
    JOIN experience ON experience.id = products.experience_id
    WHERE clients.id = $_SESSION[USER]
    group by o.id";


$result = $mysql->query($query);
$html = "";

while($res = $result->fetch_assoc()){
    $stars = "";
    if ($res['rate'] != 0){
        for($i = 5; $i > 0; $i--){
            $stars .='<input type="radio"  value="'.$i.'" '.($res['rate'] >= $i ? "checked" : "").' disabled/>
            <label  title="'.$i.'"></label>';
        }

    }
    $html .='<div class="history_item_client shadow" order_id = "'.$res[id].'">
                <div>დრო : '.$res[datetime].'</div>
                <div>ასისტენტი : '.$res[staff].'</div>
                <div>მომსახურება : '.$res[exp].'</div>
                '.( $res[rate] > 0 ? 
                ' <div class="rate history_rate">
                    '.$stars.'
                </div>
                
                ' :
                '<div class="rate_buttons" >
                    <button class="rate_button" order_id = "'.$res[id].'" > შეაფასე </button>
                </div>' ).'
                
            </div>';
}
if($html == "") $html = "<h2>თქვენ არ გაქვთ გამოძახების ისტორია &#128546;</h2>";
        return '<div class="history_container"> 
                    '.$html.'
                    
        
        </div>';
  }


}
   

?>