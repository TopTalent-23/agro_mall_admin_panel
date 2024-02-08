  $img1 =  $row['img1'];
                    $img2 = $row['img2'];
                    $img3 = $row['img3'];
                    $img4 = $row['img4'];
                    $img5 = $row['img5'];
                    echo '<div class="col-sm-6 my-3">
                <div class="card m-auto shadow border" style="width: 18rem;">
                    <div class="card-body ">';
                    ?>
                    <div class="">
                        
                        <?php if ($img1 != null) {?>
                            
                        
                            <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img1); ?>" height="200" width="200" class="card-img-top">
                       
                        <?php }
                       elseif ($img2 != null) {?>
                            
                        
                      
                            <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img2); ?>" height="200" width="200" class="card-img-top">
                       
                         <?php }
                       elseif ($img3 != null) {?>
                       
                           <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img3); ?>" height="200" width="200" class="card-img-top">
                       
                         <?php }
                      elseif ($img4 != null) {?>
                        
                            <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img4); ?>" height="200" width="200" class="card-img-top">
                        
                         <?php }
                      elseif ($img5 != null) {?>
                       
                           <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img5); ?>" height="200" width="200" class="card-img-top">
                        
                         <?php }
                         
                         ?>
                        
                       
                    </div>