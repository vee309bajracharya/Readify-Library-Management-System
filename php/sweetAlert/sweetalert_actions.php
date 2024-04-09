    <?php
      if(isset($_SESSION['msg']) && $_SESSION['msg'] !=''){
    ?>
        <script>
            swal({
              title: "<?php echo $_SESSION['msg']; ?>",
              icon: "<?php echo $_SESSION['msg_code']; ?>",
            });        
        </script>

    <?php
        unset($_SESSION['msg']);
      }
    
    ?>