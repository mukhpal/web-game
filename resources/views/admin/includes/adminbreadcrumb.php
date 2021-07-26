<div class="app-title">
  <div>
    <h1><!-- <i class="fa fa-th-list"></i> --> <?php echo $breadcrumbTitle; ?></h1>
    <!-- <p>Table to display analytical data effectively</p> -->
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><a href='<?php echo route("admin.dashboard"); ?>'><i class="fa fa-home fa-lg"></i></a></li>
    <?php
   	if(!empty($breadcrumbLink)){ ?>
   		<li class="breadcrumb-item"><a href='<?php echo route($breadcrumbLink); ?>'><?php echo $breadcrumbItem; ?></a></li>
   	<?php }else{ ?>
   		<li class="breadcrumb-item"><?php echo $breadcrumbItem; ?></li>
   	<?php } ?>
    
    <?php if(!empty($breadcrumbTitle2)){ ?>
    	<li class="breadcrumb-item active"><?php echo $breadcrumbTitle2; ?></li>
	<?php } ?>
  </ul>
</div>