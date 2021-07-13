<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url(); ?>assets/img/<?php echo $userdata->foto; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $userdata->nama; ?></p>
        <!-- Status -->
        <a href="<?php echo base_url(); ?>assets/#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">LIST MENU</li>
      <!-- Optionally, you can add icons to the links -->

      <!--<li <?php if ($page == 'home') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Home'); ?>">
          <i class="fa fa-home"></i>
          <span>Home</span>
        </a>
      </li>
      
      <li <?php if ($page == 'pegawai') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Pegawai'); ?>">
          <i class="fa fa-user"></i>
          <span>Data Pegawai</span>
        </a>
      </li>

      <li <?php if ($page == 'posisi') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Posisi'); ?>">
          <i class="fa fa-briefcase"></i>
          <span>Data Posisi</span>
        </a>
      </li>
      
      <li <?php if ($page == 'kota') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Kota'); ?>">
          <i class="fa fa-location-arrow"></i>
          <span>Data Kota</span>
        </a>
      </li>-->

      <li <?php if ($page == 'usersegmentation') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('UserSegmentation'); ?>">
          <i class="fa fa-location-arrow"></i>
          <span>User Segmentation</span>
        </a>
      </li>

      <li <?php if ($page == 'refactorimageshop') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('RefactorImageShop'); ?>">
          <i class="fa fa-location-arrow"></i>
          <span>Refactor Image Shop</span>
        </a>
      </li>

      <li <?php if ($page == 'matchpricesshop') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('MatchPricesShop'); ?>">
          <i class="fa fa-location-arrow"></i>
          <span>Match Price Shop</span>
        </a>
      </li>

      <li <?php if ($page == 'cronwp') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('CronWP'); ?>">
          <i class="fa fa-location-arrow"></i>
          <span>Cron WP</span>
        </a>
      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>