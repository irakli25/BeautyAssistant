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
        <div>
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

                                        <div class="container">
                                    

                                        
                                        <section class="main">
                                        
                                            <div id="sb-container" class="sb-container">
                                            
                                                <div class ="tab-selector" tab = "id1" >
                                                    <span class="sb-icon "><i class="fas fa-home"></i></span>
                                                    <h4>პროფილი</h4>
                                                </div>

                                                <div class ="tab-selector" tab = "id2" >
                                                    <span class="sb-icon "><i class="far fa-user"></i></span>
                                                    <h4>ჩემს შესახებ</h4>
                                                </div>

                                                <div class ="tab-selector" tab = "id3" >
                                                    <span class="sb-icon "><i class="fas fa-images"></i></span>
                                                    <h4>პორტფოლიო</h4>
                                                </div>


                                                <div class ="tab-selector" tab = "id4" >
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
                    <span>
                        <select id="experience" ></select>
                    </span>
                
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

  function get_img(){
      $mysql = $this->db;
      $query = "SELECT `rand_name` FROM `file` WHERE `id` = '$this->img'";
      $img = $mysql->getResult($query);
        return 'server/uploads/'.$img;
  }

}

?>